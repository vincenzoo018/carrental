<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReportController;

/* Home Route */

Route::get('/', [HomeController::class, 'index'])->name('home');

/* Vehicle Routes */
Route::prefix('vehicles')->group(function () {
    Route::get('/', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/{id}', [VehicleController::class, 'show'])->name('vehicles.show');
});

/* Customer Routes */
Route::prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::get('/{id}', [CustomerController::class, 'show'])->name('customers.show');
});

/* Rental Routes */
Route::prefix('rentals')->group(function () {
    Route::get('/', [RentalController::class, 'index'])->name('rentals.index');
    Route::get('/create', [RentalController::class, 'create'])->name('rentals.create');
    Route::get('/{id}', [RentalController::class, 'show'])->name('rentals.show');
});

/* Payment Routes */
Route::prefix('payments')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/create', [PaymentController::class, 'create'])->name('payments.create');
});

/* Maintenance Routes */
Route::prefix('maintenance')->group(function () {
    Route::get('/', [MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('/create', [MaintenanceController::class, 'create'])->name('maintenance.create');
});

/* Report Routes */
Route::prefix('reports')->group(function () {
    Route::get('/rentals', [ReportController::class, 'rentals'])->name('reports.rentals');
    Route::get('/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
});
