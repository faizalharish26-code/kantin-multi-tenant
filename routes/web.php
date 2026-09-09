<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])
    ->name('dashboard')
    ->get('/dashboard', function () {
        return view('dashboard');
    });

require __DIR__.'/customer.php';
require __DIR__.'/tenant.php';
require __DIR__.'/admin.php';
require __DIR__.'/settings.php';
