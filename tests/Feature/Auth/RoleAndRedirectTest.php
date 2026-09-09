<?php

use App\Models\User;

it('maps each role to its default destination', function () {
    $customer = User::factory()->make(['role' => 'customer']);
    $tenant = User::factory()->make(['role' => 'tenant']);
    $admin = User::factory()->make(['role' => 'admin']);

    expect($customer->defaultRoute())->toBe('/');
    expect($tenant->defaultRoute())->toBe('/tenant/dashboard');
    expect($admin->defaultRoute())->toBe('/admin/dashboard');
});

it('blocks customer users from the admin dashboard', function () {
    $user = User::factory()->create(['role' => 'customer', 'status' => 'active']);

    $this->actingAs($user)
        ->get('/admin/dashboard')
        ->assertForbidden();
});
