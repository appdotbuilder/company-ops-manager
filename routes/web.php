<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\FinanceController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Main dashboard
Route::get('/', [DashboardController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
    
    // Employee Management
    Route::resource('employees', EmployeeController::class);
    
    // Warehouse Management
    Route::resource('warehouse', WarehouseController::class);
    
    // Finance Management
    Route::resource('finance', FinanceController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
