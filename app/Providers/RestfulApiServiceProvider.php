<?php

namespace App\Providers;

use App\RestfulApi\ApiResponseBuilder;
use Illuminate\Support\ServiceProvider;

class RestfulApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('api.response.builder', function ($app) {
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
