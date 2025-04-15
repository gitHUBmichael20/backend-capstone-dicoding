<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProdukController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PenggunaController;

Route::get('/user', [AuthController::class, 'apiUser'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']); // Bisa hapus kalau hanya web
Route::post('/login', [AuthController::class, 'login']); // Bisa hapus kalau hanya web
Route::get('/produk', [ProdukController::class, 'index']);
Route::post('/produk', [ProdukController::class, 'store']);
Route::get('/produk/{id}', [ProdukController::class, 'show']);
Route::post('/add_produk', [ProdukController::class, 'addToCart']);
Route::get('/keranjang/{idUser}', [KeranjangController::class, 'index']);
Route::delete('/keranjang/item/{idKeranjang}', [KeranjangController::class, 'delete']);
Route::delete('/keranjang/all_item/{idUser}', [KeranjangController::class, 'deleteAll']);
Route::post('/peminjaman', [PeminjamanController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    // Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/admin/logout', [AuthController::class, 'adminLogout']);
});

Route::prefix('admin')->group(function () {
    
    // http://localhost:8000/api/admin/produk
    Route::get('/produk', [ProdukController::class, 'index']); // ambil semua data produk
    
    // http://localhost:8000/api/admin/peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index']); // ambil semua data peminjaman

    // http://localhost:8000/api/admin/pengguna
    Route::get('/pengguna', [PenggunaController::class, 'index']); // ambil semua data pengguna


});
