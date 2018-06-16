<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Article;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
//        \App\Model::class => \App\Policies\ModelPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerPostPolicies();



    }

    /**
     * Register post permission
     */
    public function registerPostPolicies()
    {
        //Register menu permission
        Gate::before(function ($user, $ability) {
            if ($user->inRole('Admin')) {
                return true;
            }
        });

        Gate::define('create-post', function ($user) {
            return $user->hasAccess(['create-post']);
        });
        Gate::define('update-post', function ($user, Article $post) {
            return $user->hasAccess(['update-post']) and $user->id == $post->user_id;
        });
        Gate::define('publish-post', function ($user) {
            return $user->hasAccess(['publish-post']);
        });



    }

    /**
     * Register menu permission
     */
//    public function registerMenuPolicies()
//    {
//
//    }

    /**
     * Register all permission
     */
    public function AllPermission()
    {
        Gate::before(function ($user, $ability) {
           return $user->inRole('Admin');
        });
        //All permissions
    }
}
