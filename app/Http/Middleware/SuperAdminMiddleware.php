<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user || ! ($user->super_admin ?? false)) {
            abort(403, 'Only Super Admins can access this area.');
        }
        return $next($request);
    }
}
