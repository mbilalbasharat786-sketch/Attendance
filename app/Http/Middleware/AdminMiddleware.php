<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check karo ke user login hai aur uska role 'admin' hai
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Admin hai toh andar jane do
        }

        // Agar admin nahi hai toh wapas bhej do
        return redirect('/dashboard')->with('error', 'Akses Denied! Aap Admin nahi hain.');
    }
}
