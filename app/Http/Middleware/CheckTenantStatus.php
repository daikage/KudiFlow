<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTenantStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        // Super admins bypass
        if ($request->user() && ($request->user()->super_admin ?? false)) {
            return $next($request);
        }

        $tenantId = app('tenant_id');
        $tenant = Tenant::find($tenantId);

        // Allow access to billing/support/logout even when paused/expired
        $isBillingRoute = $request->routeIs('ui.settings.billing') || $request->routeIs('ui.billing.upgrade');
        $isSupportRoute = $request->routeIs('support.index');
        $isLogout       = $request->routeIs('logout');

        if ($tenant && $tenant->isPaused()) {
            if ($isBillingRoute || $isSupportRoute || $isLogout) {
                return $next($request);
            }

            return response()->view('errors.tenant-paused', [
                'reason' => $tenant->pause_reason,
                'paused_at' => $tenant->paused_at,
            ], 403);
        }

        // Subscription enforcement
        $sub = Subscription::where('tenant_id', $tenantId)->latest('id')->first();
        $active = $sub?->isActive() ?? false;

        if (! $active) {
            // If not active, allow billing/support/logout to proceed for upgrade/help
            if ($isBillingRoute || $isSupportRoute || $isLogout) {
                return $next($request);
            }

            $reason = $sub
                ? ($sub->status === 'trial' ? 'Trial has ended.' : 'Subscription expired.')
                : 'No active subscription.';

            // Pause tenant and show paused page
            if ($tenant) {
                $tenant->pause($reason);
            }

            return response()->view('errors.tenant-paused', [
                'reason' => $tenant?->pause_reason ?? $reason,
                'paused_at' => $tenant?->paused_at,
            ], 403);
        }

        return $next($request);
    }
}
