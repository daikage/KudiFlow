<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\UI\DashboardController;
use App\Http\Controllers\UI\ProductController;
use App\Http\Controllers\UI\CategoryController;
use App\Http\Controllers\UI\SalesController;
use App\Http\Controllers\UI\ExpenseController;
use App\Http\Controllers\UI\StaffController;
use App\Http\Controllers\UI\AdminController;
use App\Http\Controllers\UI\SettingsController;
use App\Http\Controllers\UI\SupportController;
use App\Http\Controllers\UI\ProfileController;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UI\SubscriptionOnboardingController;
use App\Http\Controllers\SA\SubscriptionsController;
use App\Http\Controllers\UI\ForecastController;
use App\Http\Controllers\Webhook\PaymentWebhookController;
use App\Http\Controllers\UI\PosController;


// Landing
Route::view('/', 'landing')->name('home');

// Auth: login, register, logout
Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
    Route::get('/register', [\App\Http\Controllers\Auth\AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);
});

Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->middleware('auth')->name('logout');

// Protected app UI (must be logged in + tenant scoped)
// Use auth + tenant middleware at group level
Route::prefix('ui')->middleware(['auth', \App\Http\Middleware\TenantMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\UI\DashboardController::class, 'index'])->name('ui.dashboard');

    // Inventory (use FQCN with parameter to bypass alias resolution issues)
    Route::get('/products', [\App\Http\Controllers\UI\ProductController::class, 'index'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':inventory')
        ->name('ui.products.index');
    Route::get('/products/create', [\App\Http\Controllers\UI\ProductController::class, 'create'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':inventory')
        ->name('ui.products.create');
    Route::post('/products', [\App\Http\Controllers\UI\ProductController::class, 'store'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':inventory')
        ->name('ui.products.store');
    Route::get('/products/{product}', [\App\Http\Controllers\UI\ProductController::class, 'show'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':inventory')
        ->name('ui.products.show');
    Route::get('/products/{product}/edit', [\App\Http\Controllers\UI\ProductController::class, 'edit'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':inventory')
        ->name('ui.products.edit');
    Route::put('/products/{product}', [\App\Http\Controllers\UI\ProductController::class, 'update'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':inventory')
        ->name('ui.products.update');
    Route::delete('/products/{product}', [\App\Http\Controllers\UI\ProductController::class, 'destroy'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':inventory')
        ->name('ui.products.destroy');

    Route::get('/categories', [\App\Http\Controllers\UI\CategoryController::class, 'index'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':inventory')
        ->name('ui.categories.index');
    Route::get('/categories/create', [\App\Http\Controllers\UI\CategoryController::class, 'create'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':inventory')
        ->name('ui.categories.create');
    Route::post('/categories', [\App\Http\Controllers\UI\CategoryController::class, 'store'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':inventory')
        ->name('ui.categories.store');
    Route::get('/categories/{category}', [\App\Http\Controllers\UI\CategoryController::class, 'show'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':inventory')
        ->name('ui.categories.show');
    Route::get('/categories/{category}/edit', [\App\Http\Controllers\UI\CategoryController::class, 'edit'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':inventory')
        ->name('ui.categories.edit');
    Route::put('/categories/{category}', [\App\Http\Controllers\UI\CategoryController::class, 'update'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':inventory')
        ->name('ui.categories.update');
    Route::delete('/categories/{category}', [\App\Http\Controllers\UI\CategoryController::class, 'destroy'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':inventory')
        ->name('ui.categories.destroy');

    // Sales
    Route::get('/sales', [\App\Http\Controllers\UI\SalesController::class, 'index'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':sales')
        ->name('ui.sales.index');
    Route::get('/sales/create', [\App\Http\Controllers\UI\SalesController::class, 'create'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':sales')
        ->name('ui.sales.create');
    Route::post('/sales', [\App\Http\Controllers\UI\SalesController::class, 'store'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':sales')
        ->name('ui.sales.store');
    Route::get('/sales/{sale}', [\App\Http\Controllers\UI\SalesController::class, 'show'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':sales')
        ->name('ui.sales.show');

    // Finance (Expenses)
    Route::get('/expenses', [\App\Http\Controllers\UI\ExpenseController::class, 'index'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':finance')
        ->name('ui.expenses.index');
    Route::get('/expenses/create', [\App\Http\Controllers\UI\ExpenseController::class, 'create'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':finance')
        ->name('ui.expenses.create');
    Route::post('/expenses', [\App\Http\Controllers\UI\ExpenseController::class, 'store'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':finance')
        ->name('ui.expenses.store');
    Route::get('/expenses/{expense}', [\App\Http\Controllers\UI\ExpenseController::class, 'show'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':finance')
        ->name('ui.expenses.show');
    Route::get('/expenses/{expense}/edit', [\App\Http\Controllers\UI\ExpenseController::class, 'edit'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':finance')
        ->name('ui.expenses.edit');
    Route::put('/expenses/{expense}', [\App\Http\Controllers\UI\ExpenseController::class, 'update'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':finance')
        ->name('ui.expenses.update');
    Route::delete('/expenses/{expense}', [\App\Http\Controllers\UI\ExpenseController::class, 'destroy'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':finance')
        ->name('ui.expenses.destroy');

    // People (Staff)
    Route::get('/staff', [\App\Http\Controllers\UI\StaffController::class, 'index'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':people')
        ->name('ui.staff.index');
    Route::get('/staff/create', [\App\Http\Controllers\UI\StaffController::class, 'create'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':people')
        ->name('ui.staff.create');
    Route::post('/staff', [\App\Http\Controllers\UI\StaffController::class, 'store'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':people')
        ->name('ui.staff.store');
    Route::get('/staff/{id}', [\App\Http\Controllers\UI\StaffController::class, 'show'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':people')
        ->name('ui.staff.show');
    Route::get('/staff/{id}/edit', [\App\Http\Controllers\UI\StaffController::class, 'edit'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':people')
        ->name('ui.staff.edit');
    Route::put('/staff/{id}', [\App\Http\Controllers\UI\StaffController::class, 'update'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':people')
        ->name('ui.staff.update');

    // Admin
    Route::get('/admin', [\App\Http\Controllers\UI\AdminController::class, 'index'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':admin')
        ->name('admin.index');

    // Admin: Role permissions editor
    Route::get('/admin/roles', [\App\Http\Controllers\UI\Admin\RolePermissionController::class, 'index'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':admin')
        ->name('admin.roles.index');
    Route::post('/admin/roles', [\App\Http\Controllers\UI\Admin\RolePermissionController::class, 'update'])
        ->middleware(\App\Http\Middleware\PermissionMiddleware::class . ':admin')
        ->name('admin.roles.update');
});

// Super Admin (Platform) routes
Route::prefix('sa')
    ->middleware(['auth', \App\Http\Middleware\TenantMiddleware::class, \App\Http\Middleware\SuperAdminMiddleware::class])
    ->group(function () {
        Route::get('/', [\App\Http\Controllers\SA\SuperAdminController::class, 'index'])->name('sa.index');

        Route::get('/tenants', [\App\Http\Controllers\SA\SuperAdminController::class, 'tenants'])->name('sa.tenants.index');
        Route::post('/tenants', [\App\Http\Controllers\SA\SuperAdminController::class, 'storeTenant'])->name('sa.tenants.store');
        Route::delete('/tenants/{tenant}', [\App\Http\Controllers\SA\SuperAdminController::class, 'destroyTenant'])->name('sa.tenants.destroy');

        Route::get('/tenants/{tenant}/dashboard', [\App\Http\Controllers\SA\SuperAdminController::class, 'tenantDashboard'])
            ->name('sa.tenants.dashboard');

        Route::get('/subscriptions', [\App\Http\Controllers\SA\SubscriptionsController::class, 'index'])->name('sa.subscriptions.index');
    });

// [BACKWARD COMPAT] If some parts of the app call /admin/tenants/{id}, route them here and require superadmin
Route::middleware(['auth', \App\Http\Middleware\TenantMiddleware::class, \App\Http\Middleware\SuperAdminMiddleware::class])->group(function () {
    Route::delete('/admin/tenants/{tenant}', [\App\Http\Controllers\SA\SuperAdminController::class, 'destroyTenant'])->name('admin.tenants.destroy');
});

// (optional) keep old link but redirect to SA to avoid 404s
Route::get('/ui/admin/subscriptions', function () {
    return redirect()->route('sa.subscriptions.index');
})->middleware(['auth'])->name('admin.subscriptions.index');

// Notifications API (auth only)
Route::prefix('notifications')->group(function() {
    Route::get('unread', [\App\Http\Controllers\NotificationController::class, 'unread'])->name('notifications.unread');
    Route::post('read_all', [\App\Http\Controllers\NotificationController::class, 'readAll'])->name('notifications.read_all');
});

// Apply the changes from the code block
Route::middleware(['tenant', 'tenant.status'])->group(function() {
    // All your tenant routes here
});

// Apply the changes from the code block
Route::prefix('admin')->middleware(['auth', 'superadmin'])->group(function() {
    // ... existing routes ...
    Route::get('tenants', [\App\Http\Controllers\SA\SuperAdminController::class, 'tenants'])->name('admin.tenants.index');
    Route::post('tenants/{tenant}/pause', [\App\Http\Controllers\SA\SuperAdminController::class, 'pauseTenant'])->name('admin.tenants.pause');
    Route::post('tenants/{tenant}/resume', [\App\Http\Controllers\SA\SuperAdminController::class, 'resumeTenant'])->name('admin.tenants.resume');
    Route::delete('tenants/{tenant}', [\App\Http\Controllers\SA\SuperAdminController::class, 'destroyTenant'])->name('admin.tenants.destroy');
});

Route::middleware(['auth','tenant','tenant.status'])->prefix('ui')->name('ui.')->group(function () {
    // Settings pages
    Route::get('/settings/general', [SettingsController::class, 'general'])->name('settings.general');
    Route::get('/settings/billing', [SettingsController::class, 'billing'])->name('settings.billing');
    Route::get('/settings/notifications', [SettingsController::class, 'notifications'])->name('settings.notifications');

    // FIX: add missing route for the General settings form action
    Route::post('/settings/general', [SettingsController::class, 'updateGeneral'])->name('settings.general.update');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Support
    Route::get('/support', [SupportController::class, 'index'])->name('support.index');

    // Notifications (used by topbar and modal)
    Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read_all');

    // Ensure Billing page route exists (redirect target after upgrade)
    Route::get('/settings/billing', [SettingsController::class, 'billing'])->name('settings.billing');

    // NEW: Upgrade endpoint used by the billing view’s form (keeps current design intact)
    Route::post('/billing/upgrade', [SettingsController::class, 'upgrade'])->name('billing.upgrade');

    // Forecast (gated by finance module permissions; during trial it's auto-unlocked by your middleware)
    Route::get('/forecast', [ForecastController::class, 'index'])
        ->middleware('perm:finance')
        ->name('forecast.index');

    // Billing callback route added
    Route::get('/billing/callback', [SettingsController::class, 'billingCallback'])->name('billing.callback');

    // POS (Sales) - gated by sales permission, unlocked during trial by middleware
    Route::get('/pos', [PosController::class, 'index'])->middleware('perm:sales')->name('pos.index');
    Route::get('/pos/lookup', [PosController::class, 'lookup'])->middleware('perm:sales')->name('pos.lookup');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->middleware('perm:sales')->name('pos.checkout');
});

Route::middleware(['auth'])->prefix('ui/subscriptions')->name('subscriptions.')->group(function () {
    Route::get('choose', [SubscriptionOnboardingController::class, 'choose'])->name('choose');
    Route::post('start-trial', [SubscriptionOnboardingController::class, 'startTrial'])->name('start_trial');
    Route::post('choose-plan', [SubscriptionOnboardingController::class, 'choosePlan'])->name('choose_plan');
});

Route::middleware(['auth','sa'])->prefix('sa')->name('sa.')->group(function () {
    // Subscriptions (Plan catalog) management
    Route::get('/subscriptions', [SubscriptionsController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/plans/create', [SubscriptionsController::class, 'create'])->name('subscriptions.create');
    Route::post('/subscriptions/plans', [SubscriptionsController::class, 'store'])->name('subscriptions.store');
    Route::get('/subscriptions/plans/{plan}/edit', [SubscriptionsController::class, 'edit'])->name('subscriptions.edit');
    Route::put('/subscriptions/plans/{plan}', [SubscriptionsController::class, 'update'])->name('subscriptions.update');
    Route::delete('/subscriptions/plans/{plan}', [SubscriptionsController::class, 'destroy'])->name('subscriptions.destroy');
});

// Alias expected by the sidebar: route('support.index') without the "ui." prefix
Route::middleware(['auth','tenant','tenant.status'])
    ->get('/support', [SupportController::class, 'index'])
    ->name('support.index');

// POS routes (Sales permission)
Route::middleware(['auth', 'tenant', 'tenant.status', 'perm:sales'])
    ->prefix('ui/pos')
    ->name('ui.pos.')
    ->group(function () {
        Route::get('/', [PosController::class, 'index'])->name('index');
        Route::post('/scan', [PosController::class, 'scan'])->name('scan');
        Route::post('/add', [PosController::class, 'add'])->name('add');
        Route::post('/update', [PosController::class, 'update'])->name('update');
        Route::post('/remove', [PosController::class, 'remove'])->name('remove');
        Route::post('/checkout', [PosController::class, 'checkout'])->name('checkout');
    });

// Public webhooks (no auth, CSRF exempted)
Route::post('/webhooks/paystack', [PaymentWebhookController::class, 'paystack'])->name('webhooks.paystack');
Route::post('/webhooks/flutterwave', [PaymentWebhookController::class, 'flutterwave'])->name('webhooks.flutterwave');