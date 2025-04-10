<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServiceController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/booking', [BookingController::class, 'index'])->name('booking');
Route::get('/cars', [CarController::class, 'index'])->name('cars');
Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
