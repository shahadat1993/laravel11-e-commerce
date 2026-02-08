<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // চেক করবে সে কি ADM টাইপ ইউজার অথবা তার কি কোনো অ্যাডমিন লেভেলের রোল আছে?
            if ($user->uType === 'ADM' || $user->hasAnyRole(['Super Admin', 'Manager', 'Admin'])) {
                return $next($request);
            }
        }

        // অ্যাডমিন এক্সেস না থাকলে হোমপেজে পাঠিয়ে দেওয়া ভালো, লগইন পেজে পাঠালে অনেক সময় লুপ তৈরি হয়
        return redirect('/')->with('error', 'You do not have admin access.');
    }
}
