<?php

namespace App\Providers;

use App\Models\UserPermission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        Gate::define('isOwner', function ($user) {
            return $user->userpermissions[0]->role === 'owner'
                ? Response::allow()
                : Response::deny('این بخش فقط در اختیار مالک سامانه است');
        });

        Gate::define('isAdmin', function ($user) {
            return $user->userpermissions[0]->role === 'admin'
                ? Response::allow()
                : Response::deny('شما به این بخش دسترسی ندارید');
        });

        Gate::define('isEditor', function ($user) {
            return $user->userpermissions[0]->role === 'editor'
                ? Response::allow()
                : Response::deny('شما به این بخش دسترسی ندارید');
        });

        Gate::define('isIssuer', function ($user) {
            return $user->userpermissions[0]->role === 'issuer'
                ? Response::allow()
                : Response::deny('شما به این بخش دسترسی ندارید');
        });
    }

}
