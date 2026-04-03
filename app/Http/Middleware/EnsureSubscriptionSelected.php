<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSubscriptionSelected
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Only enforce for authenticated, non-super-admin users inside the app area
        if (!$user || ($user->super_admin ?? false)) {
            return $next($request);
        }

        // Only enforce on UI area, and skip the subscription pages themselves
        if (! $request->is('ui/*') || $request->is('ui/subscriptions*')) {
            return $next($request);
        }

        // First-time rule: If tenant has NO subscription at all, force selection
        $tenantId = (int) $user->tenant_id;
        $hasAnySubscription = Subscription::where('tenant_id', $tenantId)->exists();

        if (! $hasAnySubscription) {
            return redirect()->route('subscriptions.choose');
        }

        return $next($request);
    }
}

