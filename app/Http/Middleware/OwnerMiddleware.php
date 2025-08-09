<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role == 'pemilik') {
            return $next($request);
        }

        // Jika bukan pemilik, kembalikan ke halaman sebelumnya atau halaman utama
        return back()->with('error', 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}