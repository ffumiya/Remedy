<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function (User $user) {
            return $user->role == config('role.admin.value');
        });

        Gate::define('doctor', function (User $user) {
            return $user->role >= config('role.doctor.value');
        });
    }
}
