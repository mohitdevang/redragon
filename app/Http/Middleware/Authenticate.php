<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Where to send guests when a route requires authentication.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        if ($request->routeIs('admin.*') || $request->is('admin', 'admin/*', '*/admin', '*/admin/*')) {
            return route('admin.login');
        }

        return route('userlogin');
    }
}
