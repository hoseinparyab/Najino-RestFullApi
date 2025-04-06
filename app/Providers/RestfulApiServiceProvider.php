<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RestfulApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
       $this->app->bind('apiResponse', function ($app) {
            return new ApiResponseBuilder();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
