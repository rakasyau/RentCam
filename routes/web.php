<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// --- GUEST ROUTES ---
Route::get('/', [GuestController::class, 'index'])->name('home');
Route::post('/cart/add/{id}', [GuestController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [GuestController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/remove/{id}', [GuestController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/booking/store', [GuestController::class, 'storeBooking'])->name('booking.store');
Route::get('/bantuan', [GuestController::class, 'help'])->name('help');

// --- ADMIN AUTH ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- ADMIN DASHBOARD (Protected) ---
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Kamera Management
    Route::resource('cameras', \App\Http\Controllers\Admin\CameraController::class);
    
    // Booking Approval
    Route::post('/booking/{id}/approve', [DashboardController::class, 'approveBooking'])->name('booking.approve');
    Route::post('/booking/{id}/reject', [DashboardController::class, 'rejectBooking'])->name('booking.reject');

    // Tambahan Route untuk pengembalian barang
    Route::post('/booking/{id}/complete', [DashboardController::class, 'completeBooking'])->name('booking.complete');

    // Route untuk cetak invoice (PDF)
    Route::get('/booking/invoice/{id}', [GuestController::class, 'printInvoice'])->name('booking.invoice');

});



// Route::middleware(['auth'])->prefix('admin')->group(function () {
//     // ... route dashboard dan resource camera ...

//     // Route Booking Actions
//     Route::post('/booking/{id}/approve', [DashboardController::class, 'approveBooking'])->name('booking.approve');
//     Route::post('/booking/{id}/reject', [DashboardController::class, 'rejectBooking'])->name('booking.reject');
    
//     // Tambahan Route untuk pengembalian barang
//     Route::post('/booking/{id}/complete', [DashboardController::class, 'completeBooking'])->name('booking.complete');
// });

// Route::middleware('auth')->prefix('admin')->group(function () {
//     // ... route dashboard yang tadi ...
    
//     // Resource route ini otomatis bikin route untuk index, create, store, edit, update, destroy
//     Route::resource('cameras', \App\Http\Controllers\Admin\CameraController::class); 
// });