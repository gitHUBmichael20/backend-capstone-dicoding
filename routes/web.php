<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm']);
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::get('/login', [AuthController::class, 'showLoginForm'])->middleware('check.api.token')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // Tambah nama untuk POST
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Route::get('/landing', function () {
//     return view('landing');
// })->name('landing');
// Route::get('/landing', function () {
//     return view('landing');
// })->middleware('check.api.token')->name('landing');