<?php

use App\Models\Tenant;
use App\Models\User;

it('redirects guests away from tenant and admin routes to the login page', function () {
    $tenant = Tenant::factory()->create();

    $this->get(route('tenant.dashboard', ['tenant' => $tenant]))
        ->assertRedirect(route('login'));

    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('login'));
});

it('allows verified users to access the dashboard matching their role', function () {
    $tenant = Tenant::factory()->create();

    $customer = User::factory()->create([
        'role' => 'customer',
        'status' => 'active',
        'email_verified_at' => now(),
    ]);

    $tenantUser = User::factory()->create([
        'role' => 'tenant',
        'status' => 'active',
        'email_verified_at' => now(),
    ]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'status' => 'active',
        'email_verified_at' => now(),
    ]);

    $this->actingAs($customer)
        ->get(route('customer.home'))
        ->assertOk();

    $this->actingAs($tenantUser)
        ->get(route('tenant.dashboard', ['tenant' => $tenant]))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk();
});
