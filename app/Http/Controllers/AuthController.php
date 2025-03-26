<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        // Coba autentikasi sebagai user (guard 'web')
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            $pengguna = Auth::guard('web')->user();
            $token = $pengguna->createToken('auth_token')->plainTextToken;
            session(['api_token' => $token]);

            if ($request->expectsJson()) {
                return response()->json([
                    'token' => $token,
                    'message' => 'Login successful',
                    'user' => [
                        'id' => $pengguna->id,
                        'email' => $pengguna->email,
                        'nomor_telepon' => $pengguna->nomor_telepon,
                    ],
                ], 200);
            }

            return redirect()->route('landing')->with('success', 'Login berhasil!');
        }

        // Jika gagal sebagai user, coba autentikasi sebagai admin (guard 'admin')
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            $admin = Auth::guard('admin')->user();
            $token = $admin->createToken('auth_token')->plainTextToken;
            session(['api_token' => $token]);

            if ($request->expectsJson()) {
                return response()->json([
                    'token' => $token,
                    'message' => 'Login successful as admin',
                    'admin' => [
                        'admin_id' => $admin->admin_id,
                        'email' => $admin->email,
                        'nama_admin' => $admin->nama_admin,
                    ],
                ], 200);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai admin!');
        }

        // Jika keduanya gagal
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Email atau Password salah'], 401);
        }

        $failedMessage = 'Email atau Password salah';

        return redirect()->route('login')->with('failed', $failedMessage);
    }

    public function logout(Request $request)
    {
        \Log::info('Logout function called for user');

        $user = Auth::guard('web')->user();
        $sessionId = $request->session()->getId();
        \Log::info('Session ID before logout: '.$sessionId);

        if ($user) {
            // Hapus token API
            $user->tokens()->delete();
            \Log::info('User tokens deleted for user ID: '.$user->id);

            // Logout user
            Auth::guard('web')->logout();
            \Log::info('User logged out');
        } else {
            \Log::info('No authenticated user found');
        }

        // Hapus entri session dari tabel sessions
        $deleted = DB::table('sessions')->where('id', $sessionId)->delete();
        \Log::info('Session deletion result: '.$deleted.' rows deleted for session ID: '.$sessionId);

        // Hapus session
        $request->session()->invalidate();
        \Log::info('Session invalidated');

        $request->session()->regenerateToken();
        \Log::info('Session token regenerated');

        if ($request->expectsJson()) {
            \Log::info('Returning JSON response for logout');

            return response()->json(['message' => 'Logout success!'], 200);
        }

        \Log::info('Redirecting to login page');

        return with('success', 'Logout success!');
    }

    public function adminLogout(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if ($admin) {
            $admin->tokens()->delete();
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logout success!'], 200);
        }

        return redirect()->route('login')->with('success', 'Logout success!');
    }

    public function adminDashboard()
    {
        $admin = Auth::guard('admin')->user();
        $totalUsers = Pengguna::count();
        $totalProducts = Produk::count();

        return view('admin.dashboard', compact('admin', 'totalUsers', 'totalProducts'));
    }

    public function manageUsers()
    {
        $admin = Auth::guard('admin')->user();
        $users = Pengguna::paginate(10);

        return view('admin.users', compact('admin', 'users'));
    }

    public function manageProducts()
    {
        $admin = Auth::guard('admin')->user();
        $products = Produk::paginate(10);

        return view('admin.products', compact('admin', 'products'));
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
