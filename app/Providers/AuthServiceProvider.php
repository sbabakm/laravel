<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Permission;
use App\Models\User;
use App\Policies\OrderPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Order::class => OrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Gate::define('edit-user', function ($user, $currentuser) {
//            return $user->id == $currentuser->id;
//        });

        foreach (Permission::all() as $permission) {
            Gate::define($permission->name, function($user) use ($permission){
                return $user->hasPermission($permission);
            });

        }
    }
}
