<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::name('customer.')->group(function () {
    Route::match(['HEAD'], '/', function () {
        return response()->noContent();
    })->name('home');

    Route::get('/{tenant:slug}', function ($tenant) {
        return view('welcome', ['tenant' => $tenant]);
    })->name('tenant.show');
});
