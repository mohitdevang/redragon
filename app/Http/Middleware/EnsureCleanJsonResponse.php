<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCleanJsonResponse
{
    protected array $jsonPathPatterns = [
        'register/send-otp',
        'register/verify-otp',
        'address/send-otp',
        'address/verify-otp',
        'countries/search',
        'whatsapp-settings/test-connection',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->shouldSanitize($request)) {
            return $next($request);
        }

        $displayErrors = ini_get('display_errors');
        ini_set('display_errors', '0');
        ob_start();

        try {
            $response = $next($request);
        } finally {
            ob_end_clean();
            ini_set('display_errors', $displayErrors);
        }

        return $response;
    }

    protected function shouldSanitize(Request $request): bool
    {
        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return true;
        }

        foreach ($this->jsonPathPatterns as $pattern) {
            if ($request->is('*'.$pattern) || str_contains($request->path(), $pattern)) {
                return true;
            }
        }

        return false;
    }
}
