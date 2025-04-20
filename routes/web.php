<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

// Authentication Routes
Route::get('/', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthenticationController::class, 'login']);
Route::get('/register', [AuthenticationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

// Terms and Conditions Route (Ensure this route exists for 'terms' link)
Route::get('/terms', function () {
    return view('terms'); // Create a 'terms.blade.php' view file
})->name('terms');

// User Routes (Protected Routes)
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/home', [UserController::class, 'home'])->name('user.home');
    Route::get('/cars', [UserController::class, 'cars'])->name('user.cars');
    Route::get('/bookings', [UserController::class, 'bookings'])->name('user.bookings');
    Route::get('/reservations', [UserController::class, 'reservations'])->name('user.reservations');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/payments', [UserController::class, 'payments'])->name('user.payments');
});

// Admin Routes (Protected Routes, with role check)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/cars', [AdminController::class, 'cars'])->name('admin.cars');
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('admin.reservations');
    Route::get('/payments', [AdminController::class, 'payments'])->name('admin.payments');
    Route::get('/maintenance', [AdminController::class, 'maintenance'])->name('admin.maintenance');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
});
