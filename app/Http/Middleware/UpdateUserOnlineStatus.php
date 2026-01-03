<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UpdateUserOnlineStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Update status_online jadi aktif
            Auth::user()->update([
                'status_online' => 'aktif'
            ]);

            // Opsional: simpan timestamp last seen (bisa ditambah kolom baru kalau mau lebih presisi)
            // Auth::user()->update(['last_seen_at' => now()]);
        }

        return $next($request);
    }
}
