<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            $request = request();
            if ($request) {
                $root = rtrim($request->getSchemeAndHttpHost().$request->getBasePath(), '/');
                if ($root !== '') {
                    URL::forceRootUrl($root);
                }
            }
        }

         $setting = Setting::firstOrFail();
        View::share ('setting', $setting);
        require_once app_path('Helper/helpers.php');
    }
}
