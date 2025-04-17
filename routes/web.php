<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\Admin\CarController;
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

    Route::get('/reservation', function () {
        return view('admin.reservation');
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


// Registration Routes (updated)
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    // Registration Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
});
// User car routes
Route::prefix('user')->group(function () {
    Route::get('/cars', [CarController::class, 'index'])->name('user.cars');
    Route::get('/cars/filter/{type}', [CarController::class, 'filter'])->name('user.cars.filter');
    Route::get('/cars/{car}', [CarController::class, 'show'])->name('user.cars.show');
});

// Admin car routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('cars', CarController::class)->except(['index', 'show']);
    Route::get('/cars', [CarController::class, 'index'])->name('admin.cars');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Car management routes
    Route::resource('cars', \App\Http\Controllers\Admin\CarController::class)->except(['show']);
    Route::get('/cars', [\App\Http\Controllers\Admin\CarController::class, 'index'])->name('admin.cars');
});


// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Car routes
    Route::resource('cars', CarController::class)->names([
        'index' => 'admin.cars.index',
        'create' => 'admin.cars.create',
        'store' => 'admin.cars.store',
        'show' => 'admin.cars.show',
        'edit' => 'admin.cars.edit',
        'update' => 'admin.cars.update',
        'destroy' => 'admin.cars.destroy'
    ]);

    // ... other admin routes ...
});
