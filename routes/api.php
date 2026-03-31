<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HealthController;
// New controllers
use App\Http\Controllers\Api\Inventory\ProductController;
use App\Http\Controllers\Api\Inventory\CategoryController;
use App\Http\Controllers\Api\Sales\SaleController;
use App\Http\Controllers\Api\Expenses\ExpenseController;
use App\Http\Controllers\Api\Dashboard\DashboardController;
use App\Http\Controllers\Api\Users\StaffController;
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Admin\SubscriptionController;

// ... existing code ...
Route::get('/health', [HealthController::class, 'index']);

// API v1 scaffold for Stitch screens
Route::prefix('v1')->group(function () {
    // Inventory
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);

    // Sales
    Route::apiResource('sales', SaleController::class)->only(['index', 'store', 'show']);

    // Expenses
    Route::apiResource('expenses', ExpenseController::class);

    // Dashboard (Profit/Totals)
    Route::get('dashboard/summary', [DashboardController::class, 'summary']);

    // Staff (multi-user)
    Route::apiResource('staff', StaffController::class);

    // Admin (Super Admin + Subscription management)
    Route::prefix('admin')->group(function () {
        Route::get('overview', [AdminController::class, 'overview']);
        Route::apiResource('subscriptions', SubscriptionController::class)->only(['index', 'store', 'update', 'destroy']);
    });
});
