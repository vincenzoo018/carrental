<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\User\ReservationController;
use App\Http\Controllers\User\PaymentController;
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
    Route::get('/user/bookings', [UserController::class, 'bookings'])->name('user.bookings');

    Route::patch('/user/bookings/{booking}/cancel', [UserController::class, 'cancelBooking'])->name('bookings.cancel');

    // Available Services
    Route::get('/services', [UserController::class, 'services'])->name('services');
    Route::post('/services', [UserController::class, 'services'])->name('services');
    Route::post('/services/book', [UserController::class, 'storeBooking'])->name('services.book');

    // Profile page
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    // User's Payment History
    Route::get('/payments', [UserController::class, 'payments'])->name('payments');

    // Profile Updates
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('updateProfile');
    Route::put('/profile/photo', [UserController::class, 'changePhoto'])->name('changePhoto');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('updatePassword');
});

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('contract/{reservation_id}', [\App\Http\Controllers\User\ContractController::class, 'contract'])->name('contract');
    Route::get('contract/{reservation_id}/pdf', [\App\Http\Controllers\User\ContractController::class, 'contractPdf'])->name('contract.pdf');
    Route::get('receipt/{payment_id}', [\App\Http\Controllers\User\ContractController::class, 'receipt'])->name('receipt');
    Route::get('receipt/{payment_id}/pdf', [\App\Http\Controllers\User\ContractController::class, 'receiptPdf'])->name('receipt.pdf');
});

// ===========================
// Reservation Routes (Authenticated)
// ===========================
Route::middleware(['auth'])->group(function () {
    // Route to display the user's reservations
    Route::get('/reservations', [ReservationController::class, 'index'])->name('user.reservations');

    // Route to show the form for creating a new reservation
    Route::get('/reservations/create/{car}', [ReservationController::class, 'create'])->name('user.reservations.create');

    // Route to store a new reservation
    Route::post('/reservations', [ReservationController::class, 'store'])->name('user.reservations.store');

    // Route to cancel a reservation using PATCH
    Route::patch('/user/reservations/{reservation_id}/cancel', [ReservationController::class, 'cancel'])->name('user.reservations.cancel');
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


Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    // Show all reservations
    Route::get('/reservations', [ConfirmationController::class, 'reservations'])->name('reservations');

    // Store a new reservation (POST method)
    Route::post('/reservations/{reservationId}/cancel', [ConfirmationController::class, 'cancelReservation'])
        ->name('admin.reservation.cancel');
    // Update a reservation (PUT/PATCH method)
    Route::put('/reservations/{reservationId}', [ConfirmationController::class, 'updateReservation'])->name('reservations.update');

    // Delete a reservation (DELETE method)
    Route::delete('/reservations/{reservationId}', [ConfirmationController::class, 'deleteReservation'])->name('reservations.delete');
});


Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {

    // Payments Index
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments');

    // Payment Charge
    Route::post('/payments/charge/{paymentId}', [PaymentController::class, 'charge'])->name('payments.charge');
    Route::get('/payments/charge/{paymentId}', [PaymentController::class, 'charge'])->name('payments.charge');

    // Payment Success
    Route::get('/payments/success/{paymentId}', [PaymentController::class, 'success'])->name('payments.success');

    // Redirect to Payment for Reservation
    Route::get('/reservations/payment/{reservationId}', [PaymentController::class, 'redirectToPayment'])->name('reservations.payment');
});

use App\Http\Controllers\Admin\DamageController;

Route::post('/admin/damages', [DamageController::class, 'store'])->name('admin.damages.store');

use App\Http\Controllers\Admin\MaintenanceController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance');
    Route::post('/maintenances', [MaintenanceController::class, 'store'])->name('maintenances.store'); // Add this line
    Route::delete('/maintenances/{id}', [MaintenanceController::class, 'destroy'])->name('maintenances.destroy'); // Optional: For delete functionality
    Route::post('/admin/maintenances/{maintenance}/mark-repaired', [App\Http\Controllers\Admin\MaintenanceController::class, 'markRepaired'])->name('maintenances.markRepaired');
});

use App\Http\Controllers\Admin\ReportsController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
    Route::get('/reports/generate', [ReportsController::class, 'generate'])->name('reports.generate');
});

use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('admin/payments', [AdminController::class, 'payments'])->name('admin.payments');

Route::post('/admin/reservations/{reservation}/partial-paid', [\App\Http\Controllers\Admin\PaidStatusController::class, 'updatePartialPaidStatus'])
    ->name('admin.reservations.partialPaid');

Route::get('/admin/reservations/{reservation}/payment-status', [\App\Http\Controllers\Admin\PaidStatusController::class, 'getReservationPaymentStatus'])
    ->name('admin.reservations.paymentStatus');

// Admin Bookings
Route::prefix('admin')->name('admin.')->middleware('auth', 'admin')->group(function () {
    Route::get('bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings');
    Route::put('bookings/{booking}', [\App\Http\Controllers\Admin\BookingController::class, 'update'])->name('bookings.update');
});

// User Bookings
Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    Route::get('bookings', [\App\Http\Controllers\User\BookingController::class, 'index'])->name('bookings');
    Route::post('/bookings/charge/{booking}', [\App\Http\Controllers\User\PaymentController::class, 'chargeBooking'])->name('user.bookings.charge');
    Route::post('bookings/charge/{booking}', [\App\Http\Controllers\User\PaymentController::class, 'chargeBooking'])->name('bookings.charge');
    Route::get('/damage-assessment/{reservation}', [\App\Http\Controllers\User\DamageAssessmentController::class, 'show'])->name('damage.assessment');
    Route::post('/damage-assessment/pay/{damage}', [\App\Http\Controllers\User\DamageAssessmentController::class, 'pay'])->name('damage.assessment.pay');
});

use App\Http\Controllers\User\DamageAssessmentController;

Route::post('/damage-assessment/pay/{damageId}', [DamageAssessmentController::class, 'payForDamage'])->name('user.damage.assessment.pay');
Route::post('/damage-assessment/pay/{damage}', [\App\Http\Controllers\User\DamageAssessmentController::class, 'pay'])->name('damage.assessment.pay');
Route::get('/damage-assessment/{reservation}', [DamageAssessmentController::class, 'show'])->name('damage.assessment');

use App\Http\Controllers\User\DamageReceiptController;

Route::get('/damage-assessment/receipt/{damage}', [DamageReceiptController::class, 'generateReceipt'])->name('damage.assessment.receipt');
