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

        // Unauthenticated or Super Admin are not blocked
        if (!$user || ($user->super_admin ?? false)) {
            return $next($request);
        }

        // Only enforce inside UI area and skip the chooser routes themselves
        if (! $request->is('ui/*') || $request->is('ui/subscriptions*')) {
            return $next($request);
        }

        $tenantId = (int) $user->tenant_id;

        // Must have an ACTIVE subscription (trialing or active). If none, force chooser.
        $hasActive = Subscription::active()->where('tenant_id', $tenantId)->exists();

        if (! $hasActive) {
            return redirect()->route('subscriptions.choose');
        }

        return $next($request);
    }
}
