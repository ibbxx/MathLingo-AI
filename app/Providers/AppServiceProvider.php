<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use App\View\Components\AdminLayout;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Vercel serverless: redirect writable paths to /tmp
        if ($this->isVercel()) {
            $this->app->useStoragePath('/tmp/storage');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Blade Components
        Blade::component('admin-layout', AdminLayout::class);

        // Force HTTPS in production (Vercel terminates SSL at proxy)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Detect if running on Vercel serverless environment.
     */
    private function isVercel(): bool
    {
        return !empty($_ENV['VERCEL']) || !empty(getenv('VERCEL'));
    }
}