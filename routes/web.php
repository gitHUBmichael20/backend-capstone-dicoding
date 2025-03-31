<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm']);
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::get('/login', [AuthController::class, 'showLoginForm'])->middleware('check.api.token')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // Tambah nama untuk POST
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/landing', function () {
    return view('landing');
})->name('landing');
Route::get('/landing', function () {
    return view('landing');
})->middleware('check.api.token')->name('landing');
Route::get('/detail_produk', function () {
    return view('detail_produk');
})->name('detail_produk');
Route::get('/keranjang', function () {
    return view('keranjang');
})->name('keranjang');
Route::get('/confirm', function () {
    return view('confirm');
})->name('confirm');
