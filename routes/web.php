<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // Tambah nama untuk POST
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/landing', function () {
    return view('landing');
})->name('landing');
Route::middleware(['auth:web', 'check.api.token'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
Route::get('/detail_produk/{id}', function () {
    return view('detail_produk');
})->name('detail_produk');
Route::get('/keranjang', function () {
    return view('keranjang');
})->name('keranjang');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard')->middleware('auth:admin');
