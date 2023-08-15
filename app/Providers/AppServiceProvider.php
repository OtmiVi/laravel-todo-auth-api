<?php

namespace App\Providers;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthControllerInterface;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TaskControllerInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaskControllerInterface::class, TaskController::class);
        $this->app->bind(AuthControllerInterface::class, AuthController::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
