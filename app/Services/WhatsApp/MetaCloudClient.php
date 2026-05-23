<?php

namespace App\Services\WhatsApp;

use App\Models\WhatsappLog;
use App\Models\WhatsappSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MetaCloudClient
{
    public function __construct(protected WhatsappSetting $settings)
    {
    }

    public static function fromSettings(): self
    {
        return new self(WhatsappSetting::current());
    }

    public function testConnection(): array
    {
        if (empty($this->settings->phone_number_id) || empty($this->settings->access_token)) {
            return [
                'success' => false,
                'message' => 'Phone Number ID and Access Token are required.',
            ];
        }

        $url = $this->graphUrl($this->settings->phone_number_id);

        try {
            $response = Http::withToken($this->settings->access_token)
                ->timeout(20)
                ->get($url, ['fields' => 'id,display_phone_number,verified_name']);

            $this->log('test_connection', null, null, null, [
                'url' => $url,
                'status' => $response->status(),
                'body' => $response->json(),
            ], $response->successful() ? 'sent' : 'failed', $response->successful() ? null : $response->body());

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Connected',
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => self::messageFromResponse($response->json(), 'Connection test failed.'),
                'data' => $response->json(),
            ];
        } catch (\Throwable $e) {
            $this->log('test_connection', null, null, null, ['url' => $url], 'failed', $e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send a template using a 1-based position map. Count is resolved from Meta (cached), then
     * adjusted automatically if Meta reports a mismatch.
     *
     * @param  array<int, string>  $positionValues  e.g. [1 => '123456', 2 => '5']
     * @param  int|null  $settingsFallbackCount  optional admin fallback when Meta lookup unavailable
     */
    public function sendTemplate(
        string $toE164,
        string $templateName,
        string $language,
        array $positionValues,
        string $messageType = 'otp',
        ?int $settingsFallbackCount = null
    ): array {
        if (empty($this->settings->phone_number_id) || empty($this->settings->access_token)) {
            return ['success' => false, 'message' => 'WhatsApp is not configured.'];
        }

        $resolvedCount = $this->resolveTemplateBodyParamCount($templateName, $language);
        $paramCount = $resolvedCount
            ?? TemplateParameterBuilder::initialParameterCount($positionValues, $settingsFallbackCount);

        return $this->sendTemplateWithCount($toE164, $templateName, $language, $positionValues, $paramCount, $messageType);
    }

    /**
     * @param  array<int, string>  $positionValues
     */
    protected function sendTemplateWithCount(
        string $toE164,
        string $templateName,
        string $language,
        array $positionValues,
        int $paramCount,
        string $messageType,
        bool $allowEmptyRetry = true
    ): array {
        $bodyParameters = TemplateParameterBuilder::assemble($paramCount, $positionValues);
        $result = $this->postTemplateMessage($toE164, $templateName, $language, $bodyParameters, $messageType);

        if ($result['success']) {
            return $result;
        }

        $json = $result['response'] ?? null;
        $expected = self::parseExpectedParamCount($json);
        if ($expected !== null && $expected !== $paramCount) {
            return $this->sendTemplateWithCount(
                $toE164,
                $templateName,
                $language,
                $positionValues,
                $expected,
                $messageType,
                $allowEmptyRetry
            );
        }

        if ($allowEmptyRetry && self::isMissingTextParameterError($json)) {
            $bodyParameters = TemplateParameterBuilder::applyEmptyPlaceholder(
                TemplateParameterBuilder::assemble($paramCount, $positionValues)
            );

            return $this->postTemplateMessage($toE164, $templateName, $language, $bodyParameters, $messageType);
        }

        return $result;
    }

    /**
     * @param  array<int, string>  $bodyParameters
     */
    protected function postTemplateMessage(
        string $toE164,
        string $templateName,
        string $language,
        array $bodyParameters,
        string $messageType
    ): array {
        $template = [
            'name' => $templateName,
            'language' => ['code' => $language],
        ];

        $bodyParameters = array_values(array_map('strval', $bodyParameters));
        if (count($bodyParameters) > 0) {
            $template['components'] = [
                [
                    'type' => 'body',
                    'parameters' => array_map(
                        fn ($value) => ['type' => 'text', 'text' => (string) $value],
                        $bodyParameters
                    ),
                ],
            ];
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => ltrim($toE164, '+'),
            'type' => 'template',
            'template' => $template,
        ];

        $url = $this->graphUrl($this->settings->phone_number_id.'/messages');

        try {
            $response = Http::withToken($this->settings->access_token)
                ->timeout(25)
                ->post($url, $payload);

            $json = $response->json() ?? [];
            $messageId = $json['messages'][0]['id'] ?? null;
            $success = $response->successful() && $messageId !== null;
            $errorMessage = $success ? null : self::messageFromResponse($json, 'WhatsApp API request failed.');

            $this->log(
                $messageType,
                null,
                $toE164,
                $templateName,
                ['request' => $payload, 'response' => $json, 'param_count' => count($bodyParameters)],
                $success ? 'sent' : 'failed',
                $errorMessage,
                $messageId
            );

            return [
                'success' => $success,
                'message' => $success ? 'Message sent.' : $errorMessage,
                'message_id' => $messageId,
                'response' => $json,
            ];
        } catch (\Throwable $e) {
            $this->log($messageType, null, $toE164, $templateName, ['request' => $payload], 'failed', $e->getMessage());

            return ['success' => false, 'message' => $e->getMessage(), 'response' => null];
        }
    }

    public function resolveTemplateBodyParamCount(string $templateName, string $language): ?int
    {
        $cacheKey = 'wa_tpl_body_count:'.sha1($templateName.'|'.$language.'|'.($this->settings->business_account_id ?? ''));

        return Cache::remember($cacheKey, 3600, function () use ($templateName, $language) {
            return $this->fetchTemplateBodyParamCount($templateName, $language);
        });
    }

    protected function fetchTemplateBodyParamCount(string $templateName, string $language): ?int
    {
        $wabaId = $this->resolveWhatsAppBusinessAccountId();
        if ($wabaId === null) {
            return null;
        }

        try {
            $response = Http::withToken($this->settings->access_token)
                ->timeout(20)
                ->get($this->graphUrl($wabaId.'/message_templates'), [
                    'name' => $templateName,
                    'fields' => 'name,language,status,components',
                    'limit' => 50,
                ]);

            if (! $response->successful()) {
                return null;
            }

            foreach ($response->json('data') ?? [] as $row) {
                if (($row['name'] ?? '') !== $templateName) {
                    continue;
                }
                if (! $this->languageMatches($row['language'] ?? '', $language)) {
                    continue;
                }

                foreach ($row['components'] ?? [] as $component) {
                    if (($component['type'] ?? '') !== 'BODY') {
                        continue;
                    }

                    $count = $this->countParamsInBodyComponent($component);
                    if ($count > 0) {
                        return $count;
                    }
                }
            }
        } catch (\Throwable) {
            return null;
        }

        return null;
    }

    protected function resolveWhatsAppBusinessAccountId(): ?string
    {
        if (! empty($this->settings->business_account_id)) {
            return (string) $this->settings->business_account_id;
        }

        return null;
    }

    protected function languageMatches(string $templateLanguage, string $requested): bool
    {
        $normalize = static fn (string $code) => strtolower(str_replace('-', '_', trim($code)));
        $a = $normalize($templateLanguage);
        $b = $normalize($requested);

        if ($a === $b) {
            return true;
        }

        return str_starts_with($a, $b) || str_starts_with($b, $a);
    }

    /**
     * @param  array<string, mixed>  $component
     */
    protected function countParamsInBodyComponent(array $component): int
    {
        $text = (string) ($component['text'] ?? '');
        if (preg_match_all('/\{\{(\d+)\}\}/', $text, $matches) && ! empty($matches[1])) {
            return max(array_map('intval', $matches[1]));
        }

        $exampleRow = $component['example']['body_text'][0] ?? null;
        if (is_array($exampleRow)) {
            return count($exampleRow);
        }

        return 0;
    }

    /**
     * @param  array<string, mixed>|null  $json
     */
    public static function parseExpectedParamCount(?array $json): ?int
    {
        if (! is_array($json)) {
            return null;
        }

        $haystack = ($json['error']['message'] ?? '').' '.($json['error']['error_data']['details'] ?? '');
        if (preg_match('/expected number of params \((\d+)\)/i', $haystack, $m)) {
            return (int) $m[1];
        }

        return null;
    }

    /**
     * @param  array<string, mixed>|null  $json
     */
    public static function isMissingTextParameterError(?array $json): bool
    {
        if (! is_array($json)) {
            return false;
        }

        $code = (int) ($json['error']['code'] ?? 0);
        $message = (string) ($json['error']['message'] ?? '');

        return $code === 131008 || str_contains(strtolower($message), 'missing text value');
    }

    /**
     * @param  array<string, mixed>|null  $json
     */
    public static function messageFromResponse(?array $json, string $fallback = 'Request failed.'): string
    {
        if (! is_array($json)) {
            return $fallback;
        }

        $message = (string) ($json['error']['message'] ?? $fallback);
        $details = $json['error']['error_data']['details'] ?? null;
        if (is_string($details) && $details !== '') {
            $message .= ' — '.$details;
        }

        return $message;
    }

    protected function graphUrl(string $path): string
    {
        $version = $this->settings->graph_api_version ?: 'v25.0';

        return 'https://graph.facebook.com/'.trim($version, '/').'/'.ltrim($path, '/');
    }

    protected function log(
        string $messageType,
        ?string $userId,
        ?string $mobile,
        ?string $templateName,
        array $payload,
        string $status,
        ?string $error = null,
        ?string $providerMessageId = null
    ): void {
        WhatsappLog::create([
            'message_type' => $messageType,
            'user_id' => $userId,
            'mobile_number' => $mobile,
            'template_name' => $templateName,
            'request_payload' => $payload['request'] ?? $payload,
            'response_payload' => $payload['response'] ?? $payload,
            'status' => $status,
            'error_message' => $error,
            'provider_message_id' => $providerMessageId,
            'sent_at' => now(),
        ]);
    }
}
