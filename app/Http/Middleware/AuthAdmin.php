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
        // যদি login করা থাকে
        if (Auth::check()) {
            // যদি admin হয়
            if (Auth::user()->uType === 'ADM') {
                return $next($request);
            }

            // login আছে কিন্তু admin না
            abort(403, 'Unauthorized access');
        }

        // login নেই
        return redirect()->route('login');
    }
}
