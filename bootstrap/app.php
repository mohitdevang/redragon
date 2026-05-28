<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\EnsureCleanJsonResponse;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
 ->withMiddleware(function (Middleware $middleware) {
        $middleware->prependToGroup('web', EnsureCleanJsonResponse::class);
        $middleware->alias([
            'prevent-back-history' => PreventBackHistory::class,
              'auth' => Authenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('redragon:community-bonus')->dailyAt('01:00')->withoutOverlapping();
        $schedule->command('app:income-cron')->dailyAt('01:10')->withoutOverlapping();
    })
    ->create();
