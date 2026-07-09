<?php

// ================================================================
// FILE: app/Http/Middleware/EnsureUserIsNotSuspended.php
// Register di bootstrap/app.php pada group 'web' atau 'auth'
// ================================================================

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsNotSuspended
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->status === 'suspended') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Akun Anda telah ditangguhkan. Hubungi administrator untuk informasi lebih lanjut.');
        }

        return $next($request);
    }
}