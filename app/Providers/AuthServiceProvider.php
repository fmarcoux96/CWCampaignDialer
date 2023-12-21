<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('viewPulse', function (User $user) {
            return $user->role == User::ROLE_SUPERADMIN;
        });

        Gate::define('edit', function (User $user) {
            return $user->role == User::ROLE_SUPERADMIN || $user->role == User::ROLE_ADMIN;
        });

        Gate::define('delete', function (User $user) {
            return $user->role == User::ROLE_SUPERADMIN || $user->role == User::ROLE_ADMIN;
        });
    }
}
