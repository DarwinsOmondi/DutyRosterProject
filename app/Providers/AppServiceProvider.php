<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureManager;
use App\Http\Middleware\EnsureJanitor;
use App\Http\Middleware\RoleMiddleware; // Import the RoleMiddleware

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register any services here
    }

    public function boot()
    {
        // Register the manager and janitor middleware
        Route::aliasMiddleware('manager', EnsureManager::class);
        Route::aliasMiddleware('janitor', EnsureJanitor::class);
        
        // Register the custom role-based middleware
        Route::aliasMiddleware('role', RoleMiddleware::class);
    }
}
