<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika belum login, lempar ke login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Jika user memiliki salah satu dari role yang diizinkan, biarkan lewat
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // JANGAN gunakan redirect('/dashboard') di sini karena bisa bikin Infinite Loop!
        // Gunakan abort(403) untuk memunculkan pesan "Akses Ditolak"
        abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk halaman ini.');
    }
}