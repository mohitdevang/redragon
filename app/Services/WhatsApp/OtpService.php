<?php

namespace App\Services\WhatsApp;

use App\Models\Country;
use App\Models\OtpVerification;
use App\Models\WhatsappSetting;
use App\Support\CountryDial;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class OtpService
{
    public function __construct(
        protected WhatsappSetting $settings = new WhatsappSetting
    ) {
        $this->settings = WhatsappSetting::current();
    }

    public function buildE164(?Country $country, string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone);
        $dial = CountryDial::digits($country?->dial_code);

        if ($dial !== '' && str_starts_with($digits, $dial)) {
            return '+'.$digits;
        }

        return '+'.$dial.$digits;
    }

    public function send(string $purpose, string $phoneE164, ?int $countryId = null, ?string $userUniqueId = null, ?string $ip = null): array
    {
        $rateKey = 'otp-send:'.sha1($purpose.':'.$phoneE164);
        if (RateLimiter::tooManyAttempts($rateKey, 5)) {
            return ['success' => false, 'message' => 'Too many OTP requests. Please wait and try again.'];
        }
        RateLimiter::hit($rateKey, $this->settings->otp_resend_cooldown_seconds ?? 60);

        $otp = $this->settings->isSandbox()
            ? (string) $this->settings->sandbox_default_otp
            : (string) random_int(100000, 999999);

        $expiresAt = now()->addMinutes((int) ($this->settings->otp_expiry_minutes ?? 5));

        OtpVerification::query()
            ->where('phone_e164', $phoneE164)
            ->where('purpose', $purpose)
            ->whereNull('verified_at')
            ->delete();

        $record = OtpVerification::create([
            'purpose' => $purpose,
            'phone_e164' => $phoneE164,
            'country_id' => $countryId,
            'user_unique_id' => $userUniqueId,
            'otp_hash' => Hash::make($otp),
            'attempts' => 0,
            'expires_at' => $expiresAt,
            'ip_address' => $ip,
        ]);

        $minutes = (int) ($this->settings->otp_expiry_minutes ?? 5);
        $positionValues = $this->buildTemplatePositionValues($otp, $minutes);

        $sendResult = ['success' => true, 'message' => 'OTP generated (sandbox).'];

        if ($this->settings->enabled && ! empty($this->settings->otp_template_name)) {
            $client = MetaCloudClient::fromSettings();
            $sendResult = $client->sendTemplate(
                $phoneE164,
                $this->settings->otp_template_name,
                $this->settings->otp_template_language ?? 'en_US',
                $positionValues,
                $purpose === OtpVerification::PURPOSE_REGISTRATION ? 'registration_otp' : 'address_otp'
            );
        } elseif ($this->settings->enabled && empty($this->settings->otp_template_name)) {
            $sendResult = ['success' => false, 'message' => 'OTP template name is not configured in WhatsApp settings.'];
        }

        $apiSuccess = (bool) ($sendResult['success'] ?? false);
        $apiMessage = trim((string) ($sendResult['message'] ?? ''));

        $response = [
            'success' => $apiSuccess,
            'message' => $apiMessage !== ''
                ? $apiMessage
                : ($apiSuccess ? 'OTP sent.' : 'Failed to send OTP.'),
            'expires_at' => $expiresAt->toIso8601String(),
        ];

        if ($this->settings->isSandbox()) {
            $response['sandbox'] = true;
            $response['otp'] = $otp;
        }

        if (! ($sendResult['success'] ?? false) && ! $this->settings->isSandbox()) {
            $record->delete();

            return $response;
        }

        return $response;
    }

    public function verify(string $purpose, string $phoneE164, string $otp, ?string $ip = null): array
    {
        $rateKey = 'otp-verify:'.sha1($purpose.':'.$phoneE164);
        if (RateLimiter::tooManyAttempts($rateKey, 10)) {
            return ['success' => false, 'message' => 'Too many verification attempts.'];
        }
        RateLimiter::hit($rateKey, 300);

        $record = OtpVerification::query()
            ->where('phone_e164', $phoneE164)
            ->where('purpose', $purpose)
            ->whereNull('verified_at')
            ->orderByDesc('id')
            ->first();

        if (! $record) {
            return ['success' => false, 'message' => 'OTP not found. Please request a new code.'];
        }

        if ($record->expires_at->isPast()) {
            return ['success' => false, 'message' => 'OTP has expired.'];
        }

        if ($record->attempts >= (int) ($this->settings->otp_max_attempts ?? 5)) {
            return ['success' => false, 'message' => 'Maximum OTP attempts exceeded.'];
        }

        $record->increment('attempts');

        if (! Hash::check($otp, $record->otp_hash)) {
            return ['success' => false, 'message' => 'Invalid OTP.'];
        }

        $token = Str::random(64);
        $record->update([
            'verified_at' => now(),
            'verification_token' => $token,
            'ip_address' => $ip ?? $record->ip_address,
        ]);

        return [
            'success' => true,
            'message' => 'OTP verified.',
            'verification_token' => $token,
        ];
    }

    public function assertRegistrationToken(string $phoneE164, string $token): bool
    {
        return OtpVerification::query()
            ->where('purpose', OtpVerification::PURPOSE_REGISTRATION)
            ->where('phone_e164', $phoneE164)
            ->where('verification_token', $token)
            ->whereNotNull('verified_at')
            ->where('verified_at', '>=', now()->subMinutes(30))
            ->exists();
    }

    public function assertAddressToken(string $userUniqueId, string $token): bool
    {
        if ($userUniqueId === '' || $token === '') {
            return false;
        }

        return OtpVerification::query()
            ->where('purpose', OtpVerification::PURPOSE_ADDRESS_UPDATE)
            ->where('user_unique_id', $userUniqueId)
            ->where('verification_token', $token)
            ->whereNull('consumed_at')
            ->whereNotNull('verified_at')
            ->where('verified_at', '>=', now()->subMinutes(30))
            ->exists();
    }

    public function consumeAddressToken(string $userUniqueId, string $token): void
    {
        OtpVerification::query()
            ->where('purpose', OtpVerification::PURPOSE_ADDRESS_UPDATE)
            ->where('user_unique_id', $userUniqueId)
            ->where('verification_token', $token)
            ->update([
                'consumed_at' => now(),
                'verification_token' => null,
            ]);
    }

    /**
     * OTP template positions: {{1}} = code, {{2}} = expiry minutes. Other positions are filled only if the template needs them.
     *
     * @return array<int, string>
     */
    public function buildTemplatePositionValues(string $otp, int $minutes): array
    {
        return [
            1 => $otp,
            2 => (string) $minutes,
        ];
    }
}
