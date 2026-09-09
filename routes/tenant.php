<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'can:accessTenant'])
    ->prefix('{tenant:slug}')
    ->scopeBindings()
    ->name('tenant.')
    ->group(function () {
        Route::view('/dashboard', 'dashboard')->name('dashboard');
        Route::view('/orders', 'dashboard')->name('orders');
    });
