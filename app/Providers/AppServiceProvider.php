<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Vite;

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
        // Disable Vite in production to avoid manifest errors when assets aren't built
        if (app()->environment('production') && !file_exists(public_path('build/manifest.json'))) {
            Vite::useScriptTagsForCspNonce();
            Vite::useCspNonce('nonce-value');
            Vite::macro('asset', function ($asset) {
                return asset($asset);
            });
        }
    }
}
