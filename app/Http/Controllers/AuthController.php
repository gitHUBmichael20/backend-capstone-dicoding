<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $validated = $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:pengguna',
            'password' => 'required|string|min:8|',
        ]);

        $pengguna = Pengguna::create([
            'nama_pengguna' => $validated['nama_pengguna'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Register berhasil! Silahkan login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|',
        ]);

        if (!Auth::attempt($credentials)){
            // return response()->json([
            //     'message' => 'Email atau Password salah'
            // ], 401);
            $failedMessage = 'Email atau Password salah';
            return redirect('signup')->with('failed', $failedMessage);
        }

        $pengguna = Auth::user();
        $token = $pengguna->createToken('auth_token')->plainTextToken;

        return view('landing');
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout success!']);
    }
}
