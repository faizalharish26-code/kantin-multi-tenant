<?php

namespace App\Policies;

use App\Models\Tenant;
use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can access tenant routes.
     */
    public function accessTenant(User $user, ?Tenant $tenant = null): bool
    {
        if (! in_array($user->role, ['tenant', 'admin'], true) || ! $user->isActive()) {
            return false;
        }

        return $tenant === null || $tenant->status === 'active';
    }

    /**
     * Determine whether the user can access admin routes.
     */
    public function accessAdmin(User $user): bool
    {
        return $user->role === 'admin' && $user->isActive();
    }
}
