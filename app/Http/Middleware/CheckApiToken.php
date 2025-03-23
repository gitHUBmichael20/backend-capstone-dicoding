<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class CheckApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = session('api_token');
        $sessionData = session()->all();

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

        // if (!$request->is('login') && !$request->is('signup') && !$request->is('/')) {
        //     return redirect('/login')->withErrors(['message' => 'Please login first']);
        // }

        return $next($request);
    }
}