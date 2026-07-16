<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Hanya meloloskan request kalau user yang login punya role admin.
     * Petugas biasa yang mencoba mengakses route ini mendapat 403.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->role !== 'admin') {
            abort(403, 'Halaman ini hanya bisa diakses oleh admin.');
        }

        return $next($request);
    }
}
