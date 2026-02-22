<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Bypass maintenance check for admin routes, specific maintenance page, or login
        if ($request->is('admin*') ||
            $request->is('*/maintenance') ||
            $request->is('maintenance') ||
            $request->is('login') ||
            $request->routeIs('maintenance')) {
            return $next($request);
        }

        // 2. Check the maintenance setting
        $isMaintenance = setting('site_maintenance', 'false');

        if ($isMaintenance === 'true' || $isMaintenance === true || $isMaintenance === 1 || $isMaintenance === '1') {
            // 3. Bypass for authenticated admins
            if (auth()->check()) {
                // If user is logged in, we check if they are admin (assuming AdminMiddleware logic or similar)
                // For safety, if they can access admin dashboard, they can bypass maintenance
                return $next($request);
            }

            // 4. Redirect guests to maintenance page
            return redirect()->route('maintenance');
        }

        return $next($request);
    }
}
