<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Force HTTPS only when behind a proxy (Cloudflare Tunnel)
        // This allows localhost to work without HTTPS
        if (
            request()->header('X-Forwarded-Proto') === 'https' ||
            str_contains(request()->getHost(), 'trycloudflare.com')
        ) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
