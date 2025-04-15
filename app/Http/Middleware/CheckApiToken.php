<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class CheckApiToken
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah ada session aktif dan user_id tidak null
        $sessionId = $request->session()->getId();
        $session = DB::table('sessions')->where('id', $sessionId)->first();

        if (! $session || ! $session->user_id) {
            Auth::guard('web')->logout();
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->is('login') || $request->is('signup') || $request->is('/')) {
                return $next($request);
            }

            return redirect()->route('login')->with('failed', 'Sesi tidak valid, silakan login kembali.');
        }

        // Cek token API di session
        $token = session('api_token');

        if ($token) {
            $accessToken = PersonalAccessToken::findToken($token);

            if ($accessToken && $accessToken->tokenable) {
                Auth::setUser($accessToken->tokenable);
                if ($request->is('login') || $request->is('/')) {
                    return redirect()->route('landing');
                }

                return $next($request);
            }
        }

        // Jika tidak ada token dan bukan halaman login/signup, redirect ke login
        if (! $request->is('login') && ! $request->is('signup') && ! $request->is('/')) {
            // Jangan buat session baru di sini
            return redirect()->route('login')->with('failed', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
