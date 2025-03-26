<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::get('/login', [AuthController::class, 'showLoginForm'])->middleware('check.api.token')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // Tambah nama untuk POST
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::prefix('admin')->group(function () {
    Route::middleware(['auth:admin', 'check.api.token'])->group(function () {
        Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/users', [AuthController::class, 'manageUsers'])->name('admin.users');
        Route::post('/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');
        Route::get('/products', [AuthController::class, 'manageProducts'])->name('admin.products');
    });
});

// Route::get('/landing', function () {
//     return view('landing');
// })->name('landing');
Route::get('/landing', function () {
    return view('landing');
})->name('landing');

Route::middleware(['auth:web', 'check.api.token'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Route::get('/detail_produk/{produk_id}', [ProdukController::class, 'show'])->name('detail_produk');
Route::get('/detail_produk', function () {
    return view('detail_produk');
})->name('detail_produk');
Route::get('/keranjang', function () {
    return view('keranjang');
})->name('keranjang');
