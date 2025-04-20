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

// Terms and Conditions Route
Route::get('/terms', function () {
    return view('terms');
})->name('terms');

// User Routes (Protected)
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/home', [UserController::class, 'home'])->name('user.home');
    Route::get('/cars', [UserController::class, 'cars'])->name('user.cars');
    Route::get('/bookings', [UserController::class, 'bookings'])->name('user.bookings');
    Route::get('/services', [UserController::class, 'services'])->name('user.services');
    Route::get('/reservations', [UserController::class, 'reservations'])->name('user.reservations');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/payments', [UserController::class, 'payments'])->name('user.payments');

    // Profile Update Routes
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::put('/profile/photo', [UserController::class, 'changePhoto'])->name('user.changePhoto');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
});

// Admin Routes (Protected)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Admin Views
    Route::get('/login', fn () => view('admin.login'))->name('admin.login');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/customers', fn () => view('admin.customers'))->name('admin.customers');
    Route::get('/bookings', fn () => view('admin.bookings'))->name('admin.bookings');
    Route::get('/reservations', fn () => view('admin.reservations'))->name('admin.reservations');
    Route::get('/payments', fn () => view('admin.payments'))->name('admin.payments');
    Route::get('/maintenance', fn () => view('admin.maintenance'))->name('admin.maintenance');
    Route::get('/reports', fn () => view('admin.reports'))->name('admin.reports');

    // Car Management via Controller
    Route::get('/cars', [AdminController::class, 'cars'])->name('admin.cars');
    Route::post('/cars/store', [AdminController::class, 'storeCar'])->name('admin.cars.store');
    Route::put('/cars/{carId}', [AdminController::class, 'updateCar'])->name('admin.cars.update');
    Route::delete('/cars/{carId}', [AdminController::class, 'deleteCar'])->name('admin.cars.delete');
});
