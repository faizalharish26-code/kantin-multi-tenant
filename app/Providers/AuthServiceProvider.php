<?php

namespace App\Providers;

use App\Models\Tenant;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('accessTenant', function (User $user, ?Tenant $tenant = null): bool {
            if (! in_array($user->role, ['tenant', 'admin'], true) || ! $user->isActive()) {
                return false;
            }

            return $tenant === null || $tenant->status === 'active';
        });

        Gate::define('accessAdmin', function (User $user): bool {
            return $user->role === 'admin' && $user->isActive();
        });
    }
}
