<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/trip/{id}', [BookingController::class, 'showTrip'])->name('trip.show');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Customer routes
Route::middleware('auth')->group(function () {
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/checkout/{booking}', [BookingController::class, 'checkout'])->name('booking.checkout');
    Route::post('/payment', [BookingController::class, 'processPayment'])->name('payment.process');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my-bookings');
    Route::get('/booking/{booking}', [BookingController::class, 'showBooking'])->name('booking.show');
    Route::post('/booking/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Routes management
    Route::resource('routes', RouteController::class);
    
    // Trips management
    Route::resource('trips', TripController::class);
    
    // Bookings management
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}', [AdminBookingController::class, 'update'])->name('bookings.update');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/daily', [ReportController::class, 'daily'])->name('reports.daily');
    Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
});
