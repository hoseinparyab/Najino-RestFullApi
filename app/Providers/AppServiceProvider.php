<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
        $this->app->register(RestfulApiServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Only define permission gates if the permissions table exists
        if (Schema::hasTable('permissions')) {
            try {
                Permission::with('roles')->each(function ($permission) {
                    Gate::define($permission->name, function ($user) use ($permission) {
                        return (bool) $permission->roles->intersect($user->roles)->count();
                    });
                });
            } catch (\Exception $e) {
                // Log the error or handle it silently during migration
            }
        }
    }
}
