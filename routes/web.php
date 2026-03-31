<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Public auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Logout (auth only)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::redirect('/', '/ui/dashboard'); // optional: set a clean landing

// UI placeholder routes (for preview and client demos)
Route::prefix('ui')->group(function () {
    // Dashboard
    Route::view('/dashboard', 'dashboard.index')->name('ui.dashboard');

   // Inventory / POS (Products)
    Route::view('/products', 'inventory.products.index')->name('ui.products.index');
    Route::view('/products/create', 'inventory.products.create')->name('ui.products.create');
    Route::view('/products/{id}', 'inventory.products.show')->whereNumber('id')->name('ui.products.show');
    Route::view('/products/{id}/edit', 'inventory.products.edit')->whereNumber('id')->name('ui.products.edit');

    // Categories
    Route::view('/categories', 'inventory.categories.index')->name('ui.categories.index');
    Route::view('/categories/create', 'inventory.categories.create')->name('ui.categories.create');
    Route::view('/categories/{id}', 'inventory.categories.show')->whereNumber('id')->name('ui.categories.show');
    Route::view('/categories/{id}/edit', 'inventory.categories.edit')->whereNumber('id')->name('ui.categories.edit');

    // Sales
    Route::view('/sales', 'sales.index')->name('ui.sales.index');
    Route::view('/sales/create', 'sales.create')->name('ui.sales.create');
    Route::view('/sales/{id}', 'sales.show')->whereNumber('id')->name('ui.sales.show');

    // Expenses
    Route::view('/expenses', 'expenses.index')->name('ui.expenses.index');
    Route::view('/expenses/create', 'expenses.create')->name('ui.expenses.create');
    Route::view('/expenses/{id}', 'expenses.show')->whereNumber('id')->name('ui.expenses.show');
    Route::view('/expenses/{id}/edit', 'expenses.edit')->whereNumber('id')->name('ui.expenses.edit');

    // Staff
    Route::view('/staff', 'staff.index')->name('ui.staff.index');
    Route::view('/staff/create', 'staff.create')->name('ui.staff.create');
    Route::view('/staff/{id}', 'staff.show')->whereNumber('id')->name('ui.staff.show');
    Route::view('/staff/{id}/edit', 'staff.edit')->whereNumber('id')->name('ui.staff.edit');

    // Admin
    Route::view('/admin', 'admin.index')->name('admin.index');
    Route::view('/admin/subscriptions', 'admin.subscriptions.index')->name('admin.subscriptions.index');

    // Settings
    Route::view('/settings/general', 'settings.general')->name('settings.general');
    Route::view('/settings/billing', 'settings.billing')->name('settings.billing');
    Route::view('/settings/notifications', 'settings.notifications')->name('settings.notifications');

    // Support
    Route::view('/support', 'support.index')->name('support.index');

    // Profile
    Route::view('/profile', 'profile.show')->name('profile.show');
    Route::view('/profile/edit', 'profile.edit')->name('profile.edit');
});