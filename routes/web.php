<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

// ===========================
// Authentication Routes
// ===========================
Route::get('/', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthenticationController::class, 'login']);
Route::get('/register', [AuthenticationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

// ===========================
// Terms and Conditions
// ===========================
Route::get('/terms', fn () => view('terms'))->name('terms');

// ===========================
// User Routes (Authenticated)
// ===========================
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/home', [UserController::class, 'home'])->name('home');
    Route::get('/cars', [UserController::class, 'cars'])->name('cars');
    Route::get('/bookings', [UserController::class, 'bookings'])->name('bookings');
    Route::get('/services', [UserController::class, 'services'])->name('services');
    Route::get('/reservations', [UserController::class, 'reservations'])->name('reservations');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/payments', [UserController::class, 'payments'])->name('payments');

    // Profile Updates
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('updateProfile');
    Route::put('/profile/photo', [UserController::class, 'changePhoto'])->name('changePhoto');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('updatePassword');
});

// ===========================
// Admin Routes (Authenticated)
// ===========================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard + Static Views
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/customers', fn () => view('admin.customers'))->name('customers');
    Route::get('/bookings', fn () => view('admin.bookings'))->name('bookings');
    Route::get('/reservations', fn () => view('admin.reservations'))->name('reservations');
    Route::get('/payments', fn () => view('admin.payments'))->name('payments');
    Route::get('/maintenance', fn () => view('admin.maintenance'))->name('maintenance');
    Route::get('/reports', fn () => view('admin.reports'))->name('reports');

    // Car Management
    Route::get('/cars', [AdminController::class, 'cars'])->name('cars');
    Route::post('/cars/store', [AdminController::class, 'storeCar'])->name('cars.store');
    Route::put('/cars/{carId}', [AdminController::class, 'updateCar'])->name('cars.update');
    Route::delete('/cars/{carId}', [AdminController::class, 'deleteCar'])->name('cars.delete');

    // Service Management
    Route::get('/services', [AdminController::class, 'services'])->name('services');
    Route::post('/services', [AdminController::class, 'storeService'])->name('services.store');
    Route::put('/services/{serviceId}', [AdminController::class, 'updateService'])->name('services.update');
    Route::delete('/services/{serviceId}', [AdminController::class, 'deleteService'])->name('services.delete');

    // Employee Management
    Route::get('/employees', [AdminController::class, 'employees'])->name('employees');
    Route::post('/employees/store', [AdminController::class, 'storeEmployee'])->name('employees.store');
    Route::put('/employees/update/{employee_id}', [AdminController::class, 'updateEmployee'])->name('employees.update');
    Route::delete('/employees/delete/{employee_id}', [AdminController::class, 'deleteEmployee'])->name('employees.delete');
});
