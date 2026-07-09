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
        //
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
}