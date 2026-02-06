<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 🔹 FUTURE: role/permission system থাকলে
        if (method_exists($user, 'hasRole')) {
            if ($user->hasRole('admin') || $user->hasRole('super-admin')) {
                return $next($request);
            }
        }

        // 🔹 CURRENT SYSTEM fallback (so nothing breaks)
        if ($user->uType === 'ADM') {
            return $next($request);
        }

        abort(403, 'Unauthorized access');
    }
}
