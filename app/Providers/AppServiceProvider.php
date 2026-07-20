<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });

        Blade::anonymousComponentPath(resource_path('views/admin/layouts'), 'admin');

        RedirectIfAuthenticated::redirectUsing(function () {
            if (Route::has('dashboard') && auth()->check() && auth()->user()->isAdmin()) {
                return route('dashboard');
            }

            return route('properties.index');
        });
    }
}
