<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

// Authentication Routes
Auth::routes();

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Product Routes (Owner Only)
Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::resource('products', ProductController::class)->except(['show']);
});

// Order Routes (Cashier Only)
Route::middleware(['auth', 'role:cashier'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Sales Report Route (Owner Only)
Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/sales-report', [OrderController::class, 'salesReport'])->name('sales.report');
});

// Fallback Route
Route::fallback(function () {
    return redirect()->route('home');
});