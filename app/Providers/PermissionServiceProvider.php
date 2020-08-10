<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Permission;
use Illuminate\Auth\Access\Gate;


class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }


    /**
     * Register services.
     * @return bool
     */
    public function register()
    {

    }
}
