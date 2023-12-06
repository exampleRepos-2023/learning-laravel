<?php

namespace App\Providers;

use App\View\Composers\ActivityComposer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        // Blade::component('components.badge', 'badge');
        view()->composer(['posts.index', 'posts.show'], ActivityComposer::class);
    }
}
