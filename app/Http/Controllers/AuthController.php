<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:pengguna',
            'password' => 'required|string|min:8',
        ]);

        $pengguna = Pengguna::create([
            'nama_pengguna' => $validated['nama_pengguna'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Register berhasil! Silahkan login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        if (!Auth::attempt($credentials)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Email atau Password salah'], 401);
            }
            $failedMessage = 'Email atau Password salah';
            return redirect()->route('login')->with('failed', $failedMessage);
        }
    
        $pengguna = Auth::user();
        $token = $pengguna->createToken('auth_token')->plainTextToken;
        session(['api_token' => $token]);
    
        if ($request->expectsJson()) {
            return response()->json([
                'token' => $token,
                'message' => 'Login successful'
            ], 200);
        }
    
        return redirect()->route('landing');
    }

    public function logout(Request $request)
    {
        try {
            if (!$request->user()) {
                session()->forget('api_token');
                return response()->json(['message' => 'Logout success!']);
            }

            $token = $request->user()->currentAccessToken();
            if ($token) {
                $token->delete();
            }

            session()->forget('api_token');
            return response()->json(['message' => 'Logout success!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to logout'], 500);
        }
    }   

    public function showLoginForm()
    {
        return view('login');
    }

    public function showSignupForm()
    {
        return view('signup');
    }

    public function apiUser(Request $request)
    {
        return response()->json($request->user());
    }
}