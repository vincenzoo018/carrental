<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\User\ReservationController;
use App\Http\Controllers\Admin\ConfirmationController;

use App\Http\Middleware\AdminMiddleware;


// ===========================
// Authentication Routes
// ===========================
Route::get('/', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthenticationController::class, 'login']);
Route::get('/register', [AuthenticationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

// Admin Dashboard
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard')->middleware('auth');

// User Home
Route::get('/user/home', function () {
    return view('user.home');
})->name('user.home')->middleware('auth');

// ===========================
// Terms and Conditions Route
// ===========================
Route::get('/terms', fn() => view('terms'))->name('terms');

// ===========================
// User Routes (Authenticated)
// ===========================
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    // Dashboard/Home for the user
    Route::get('/home', [UserController::class, 'home'])->name('home');

    // Cars List (User-specific)
    Route::get('/cars', [UserController::class, 'cars'])->name('cars');
    Route::post('/cars/rent', [UserController::class, 'rentCar'])->name('cars.rent');

    // Booking Listings
    Route::get('/bookings', [UserController::class, 'bookings'])->name('bookings');

    // Available Services
    Route::get('/services', [UserController::class, 'services'])->name('services');

    // Profile page
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    // User's Payment History
    Route::get('/payments', [UserController::class, 'payments'])->name('payments');

    // Profile Updates
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('updateProfile');
    Route::put('/profile/photo', [UserController::class, 'changePhoto'])->name('changePhoto');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('updatePassword');
});

// ===========================
// Reservation Routes (Authenticated)
// ===========================
Route::middleware(['auth'])->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index'])->name('user.reservations');

    Route::get('/reservations/create/{car}', [ReservationController::class, 'create'])->name('user.reservations.create');

    Route::post('/reservations', [ReservationController::class, 'store'])->name('user.reservations.store');
});

// ===========================
// Admin Routes (Authenticated)
// ===========================
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // View all customers
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers');

    // Bookings (Admin)
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');

    // Payments (Admin)
    Route::get('/payments', [AdminController::class, 'payments'])->name('payments');

    // Maintenance View
    Route::get('/maintenance', fn() => view('admin.maintenance'))->name('maintenance');

    // Reports View
    Route::get('/reports', fn() => view('admin.reports'))->name('reports');

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


Route::prefix('admin')->group(function () {
    Route::get('/reservations', [ConfirmationController::class, 'reservations'])->name('admin.reservations');

    Route::post('/reservations/store', [ConfirmationController::class, 'storeReservation'])->name('admin.reservations.store');

    Route::put('/reservations/update/{reservationId}', [ConfirmationController::class, 'updateReservation'])->name('admin.reservations.update');

    Route::delete('/reservations/delete/{reservationId}', [ConfirmationController::class, 'deleteReservation'])->name('admin.reservations.delete');
});
