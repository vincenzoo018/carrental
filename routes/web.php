<?php

use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// User Routes
Route::prefix('user')->group(function () {
    Route::get('/home', function () {
        return view('user.home');
    })->name('user.home');

    Route::get('/cars', function () {
        return view('user.cars');
    })->name('user.cars');

    Route::get('/bookings', function () {
        return view('user.bookings');
    })->name('user.bookings');

    Route::get('/reservations', function () {
        return view('user.reservation');
    })->name('user.reservations');

    Route::get('/profile', function () {
        return view('user.profile');
    })->name('user.profile');

    Route::get('/payments', function () {
        return view('user.payments');
    })->name('user.payments');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/cars', function () {
        return view('admin.cars');
    })->name('admin.cars');

    Route::get('/customers', function () {
        return view('admin.customers');
    })->name('admin.customers');

    Route::get('/bookings', function () {
        return view('admin.bookings');
    })->name('admin.bookings');

    Route::get('/reservations', function () {
        return view('admin.reservations');
    })->name('admin.reservations');

    Route::get('/payments', function () {
        return view('admin.payments');
    })->name('admin.payments');

    Route::get('/maintenance', function () {
        return view('admin.maintenance');
    })->name('admin.maintenance');

    Route::get('/reports', function () {
        return view('admin.reports');
    })->name('admin.reports');
});
