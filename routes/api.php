<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PenggunaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/produk/{id}', [ProdukController::class, 'detailProduk']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::prefix('admin')->group(function () {
    
    // http://localhost:8000/api/admin/produk
    Route::get('/produk', [ProdukController::class, 'index']); // ambil semua data produk
    
    // http://localhost:8000/api/admin/peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index']); // ambil semua data peminjaman

    // http://localhost:8000/api/admin/pengguna
    Route::get('/pengguna', [PenggunaController::class, 'index']); // ambil semua data pengguna


});
