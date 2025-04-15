<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

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
        Gate::define('create_user', function ($user) {
            return $user->email === 'admin@gmail.com';
        });

        Permission::with('roles')->each(function ($permission) {
            Gate::define($permission->name, function ($user) use ($permission) {
                return !!$permission->roles->intersect($user->roles)->count() ;
            });
        });
    }
}
