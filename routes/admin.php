<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'can:accessAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::view('/dashboard', 'dashboard')->name('dashboard');
        Route::view('/users', 'dashboard')->name('users');
    });
