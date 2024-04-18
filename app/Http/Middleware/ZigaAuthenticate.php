<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ZigaAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->expectsJson()) {
            // Check if the user is authenticated with the admin guard
            if ($request->routeIs('admin/*') && !Auth::guard('admin')->check()) {
                return redirect("/admin/login"); // Redirect to the admin login page
            } else {
                return redirect("/login"); // Redirect to the default login page
            }
        }

        return response()->json([
            'message' => "Unauthenticated",
            'error' => true
        ], 401);
    }
}
