<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// UI placeholder routes (optional, for preview)
// Access under: http://your-app.test/ui/...
Route::prefix('ui')->group(function () {
    Route::view('/dashboard', 'dashboard.index');

    // Inventory
    Route::view('/products', 'inventory.products.index');
    Route::view('/products/create', 'inventory.products.create');
    Route::view('/categories', 'inventory.categories.index');
    Route::view('/categories/create', 'inventory.categories.create');

    // Sales
    Route::view('/sales', 'sales.index');
    Route::view('/sales/create', 'sales.create');

    // Expenses
    Route::view('/expenses', 'expenses.index');
    Route::view('/expenses/create', 'expenses.create');

    // Staff
    Route::view('/staff', 'staff.index');
    Route::view('/staff/create', 'staff.create');

    // Admin
    Route::view('/admin', 'admin.overview');
    Route::view('/admin/subscriptions', 'admin.subscriptions.index');
    Route::view('/admin/subscriptions/create', 'admin.subscriptions.create');
});
