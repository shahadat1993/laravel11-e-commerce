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
        // ১. ইউজার লগইন করা আছে কি না চেক
        if (Auth::check()) {
            // ২. ইউজারের টাইপ 'ADM' কি না চেক
            if (Auth::user()->uType === 'ADM') {
                return $next($request);
            }
        }

        // ৩. অ্যাডমিন না হলে এক্সেস ডিনাইড বা লগইন পেজে পাঠান
        return redirect()->route('login')->with('error', 'আপনার অ্যাডমিন এক্সেস নেই।');
    }
}
