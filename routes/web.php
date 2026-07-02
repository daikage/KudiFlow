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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UI\SubscriptionOnboardingController;
use App\Http\Controllers\SA\SubscriptionsController;
use App\Http\Controllers\UI\ForecastController;
use App\Http\Controllers\Webhook\PaymentWebhookController;
use App\Http\Controllers\UI\PosController;


// ──────────────────────────────────────────────
// Landing
// ──────────────────────────────────────────────
Route::view('/', 'landing')->name('home');

// ──────────────────────────────────────────────
// Auth: login, register (guests only)
// ──────────────────────────────────────────────
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

// ──────────────────────────────────────────────
// Subscription onboarding (auth only, no tenant required)
// ──────────────────────────────────────────────
Route::middleware(['auth'])->prefix('ui/subscriptions')->name('subscriptions.')->group(function () {
    Route::get('choose', [SubscriptionOnboardingController::class, 'choose'])->name('choose');
    Route::post('start-trial', [SubscriptionOnboardingController::class, 'startTrial'])->name('start_trial');
    Route::post('choose-plan', [SubscriptionOnboardingController::class, 'choosePlan'])->name('choose_plan');
});

// ──────────────────────────────────────────────
// Protected app UI (auth + tenant + status check)
// ──────────────────────────────────────────────
Route::prefix('ui')->middleware(['auth', 'tenant', 'tenant.status'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('ui.dashboard');

    // ── Inventory ──
    Route::middleware('perm:inventory')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('ui.products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('ui.products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('ui.products.store');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('ui.products.show');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('ui.products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('ui.products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('ui.products.destroy');

        Route::get('/categories', [CategoryController::class, 'index'])->name('ui.categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('ui.categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('ui.categories.store');
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('ui.categories.show');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('ui.categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('ui.categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('ui.categories.destroy');
    });

    // ── Sales ──
    Route::middleware('perm:sales')->group(function () {
        Route::get('/sales', [SalesController::class, 'index'])->name('ui.sales.index');
        Route::get('/sales/create', [SalesController::class, 'create'])->name('ui.sales.create');
        Route::post('/sales', [SalesController::class, 'store'])->name('ui.sales.store');
        Route::get('/sales/{sale}', [SalesController::class, 'show'])->name('ui.sales.show');
    });

    // ── POS (Sales permission) ──
    Route::middleware('perm:sales')->prefix('pos')->name('ui.pos.')->group(function () {
        Route::get('/', [PosController::class, 'index'])->name('index');
        Route::get('/lookup', [PosController::class, 'lookup'])->name('lookup');
        Route::post('/scan', [PosController::class, 'scan'])->name('scan');
        Route::post('/add', [PosController::class, 'add'])->name('add');
        Route::post('/update', [PosController::class, 'update'])->name('update');
        Route::post('/remove', [PosController::class, 'remove'])->name('remove');
        Route::post('/checkout', [PosController::class, 'checkout'])->name('checkout');
    });

    // ── Finance (Expenses) ──
    Route::middleware('perm:finance')->group(function () {
        Route::get('/expenses', [ExpenseController::class, 'index'])->name('ui.expenses.index');
        Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('ui.expenses.create');
        Route::post('/expenses', [ExpenseController::class, 'store'])->name('ui.expenses.store');
        Route::get('/expenses/{expense}', [ExpenseController::class, 'show'])->name('ui.expenses.show');
        Route::get('/expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('ui.expenses.edit');
        Route::put('/expenses/{expense}', [ExpenseController::class, 'update'])->name('ui.expenses.update');
        Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('ui.expenses.destroy');
    });

    // ── Forecast (Finance permission) ──
    Route::get('/forecast', [ForecastController::class, 'index'])
        ->middleware('perm:finance')
        ->name('ui.forecast.index');

    // ── People (Staff) ──
    Route::middleware('perm:people')->group(function () {
        Route::get('/staff', [StaffController::class, 'index'])->name('ui.staff.index');
        Route::get('/staff/create', [StaffController::class, 'create'])->name('ui.staff.create');
        Route::post('/staff', [StaffController::class, 'store'])->name('ui.staff.store');
        Route::get('/staff/{id}', [StaffController::class, 'show'])->name('ui.staff.show');
        Route::get('/staff/{id}/edit', [StaffController::class, 'edit'])->name('ui.staff.edit');
        Route::put('/staff/{id}', [StaffController::class, 'update'])->name('ui.staff.update');
    });

    // ── Admin ──
    Route::middleware('perm:admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/admin/roles', [\App\Http\Controllers\UI\Admin\RolePermissionController::class, 'index'])->name('admin.roles.index');
        Route::post('/admin/roles', [\App\Http\Controllers\UI\Admin\RolePermissionController::class, 'update'])->name('admin.roles.update');
    });

    // ── Settings ──
    Route::get('/settings/general', [SettingsController::class, 'general'])->name('ui.settings.general');
    Route::post('/settings/general', [SettingsController::class, 'updateGeneral'])->name('ui.settings.general.update');
    Route::get('/settings/billing', [SettingsController::class, 'billing'])->name('ui.settings.billing');
    Route::get('/settings/notifications', [SettingsController::class, 'notifications'])->name('ui.settings.notifications');

    // ── Billing ──
    Route::post('/billing/upgrade', [SettingsController::class, 'upgrade'])->name('ui.billing.upgrade');
    Route::get('/billing/callback', [SettingsController::class, 'billingCallback'])->name('ui.billing.callback');

    // ── Profile ──
    Route::get('/profile', [ProfileController::class, 'show'])->name('ui.profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('ui.profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('ui.profile.update');

    // ── Support ──
    Route::get('/support', [SupportController::class, 'index'])->name('ui.support.index');

    // ── Notifications (topbar & modal) ──
    Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('ui.notifications.unread');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('ui.notifications.read_all');
});

// ──────────────────────────────────────────────
// Super Admin (Platform) routes
// ──────────────────────────────────────────────
Route::prefix('sa')->middleware(['auth', 'sa'])->name('sa.')->group(function () {
    Route::get('/', [\App\Http\Controllers\SA\SuperAdminController::class, 'index'])->name('index');

    // Tenant management
    Route::get('/tenants', [\App\Http\Controllers\SA\SuperAdminController::class, 'tenants'])->name('tenants.index');
    Route::post('/tenants', [\App\Http\Controllers\SA\SuperAdminController::class, 'storeTenant'])->name('tenants.store');
    Route::get('/tenants/{tenant}/dashboard', [\App\Http\Controllers\SA\SuperAdminController::class, 'tenantDashboard'])->name('tenants.dashboard');
    Route::post('/tenants/{tenant}/pause', [\App\Http\Controllers\SA\SuperAdminController::class, 'pauseTenant'])->name('tenants.pause');
    Route::post('/tenants/{tenant}/resume', [\App\Http\Controllers\SA\SuperAdminController::class, 'resumeTenant'])->name('tenants.resume');
    Route::delete('/tenants/{tenant}', [\App\Http\Controllers\SA\SuperAdminController::class, 'destroyTenant'])->name('tenants.destroy');

    // Subscription plan catalog management
    Route::get('/subscriptions', [SubscriptionsController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/plans/create', [SubscriptionsController::class, 'create'])->name('subscriptions.create');
    Route::post('/subscriptions/plans', [SubscriptionsController::class, 'store'])->name('subscriptions.store');
    Route::get('/subscriptions/plans/{plan}/edit', [SubscriptionsController::class, 'edit'])->name('subscriptions.edit');
    Route::put('/subscriptions/plans/{plan}', [SubscriptionsController::class, 'update'])->name('subscriptions.update');
    Route::delete('/subscriptions/plans/{plan}', [SubscriptionsController::class, 'destroy'])->name('subscriptions.destroy');
});

// ──────────────────────────────────────────────
// Public webhooks (no auth, CSRF exempted via VerifyCsrfToken)
// ──────────────────────────────────────────────
Route::post('/webhooks/paystack', [PaymentWebhookController::class, 'paystack'])->name('webhooks.paystack');
Route::post('/webhooks/flutterwave', [PaymentWebhookController::class, 'flutterwave'])->name('webhooks.flutterwave');

// ──────────────────────────────────────────────
// Backward-compatible route aliases
// (referenced by blade templates & middleware)
// ──────────────────────────────────────────────
Route::middleware(['auth', 'tenant', 'tenant.status'])
    ->get('/support', [SupportController::class, 'index'])
    ->name('support.index');

Route::middleware(['auth', 'sa'])
    ->delete('/admin/tenants/{tenant}', [\App\Http\Controllers\SA\SuperAdminController::class, 'destroyTenant'])
    ->name('admin.tenants.destroy');

Route::middleware(['auth', 'sa'])
    ->post('/admin/tenants/{tenant}/pause', [\App\Http\Controllers\SA\SuperAdminController::class, 'pauseTenant'])
    ->name('admin.tenants.pause');

Route::middleware(['auth', 'sa'])
    ->post('/admin/tenants/{tenant}/resume', [\App\Http\Controllers\SA\SuperAdminController::class, 'resumeTenant'])
    ->name('admin.tenants.resume');