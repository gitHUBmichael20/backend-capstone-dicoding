<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', [AuthController::class, 'apiUser'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/produk', [ProdukController::class, 'index']);
Route::post('/produk', [ProdukController::class, 'store']);
Route::get('/produk/{id}', [ProdukController::class, 'show']);
Route::post('/add_produk', [ProdukController::class, 'addToCart']);
Route::get('/keranjang/{idUser}', [KeranjangController::class, 'index']);
Route::delete('/keranjang/item/{idKeranjang}', [KeranjangController::class, 'delete']);
Route::delete('/keranjang/all_item/{idUser}', [KeranjangController::class, 'deleteAll']);
Route::post('/peminjaman', [PeminjamanController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/admin/logout', [AuthController::class, 'adminLogout']);
});

Route::prefix('admin')->group(function () {
    // Products
    Route::get('/produk', [ProdukController::class, 'index']);
    Route::post('/produk', [ProdukController::class, 'store']);
    Route::get('/produk/{id}', [ProdukController::class, 'show']);
    Route::put('/produk/{id}', [ProdukController::class, 'update']);
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy']);
    
    // Users
    Route::get('/pengguna', [PenggunaController::class, 'index']);
    Route::post('/pengguna', [PenggunaController::class, 'store']);
    Route::get('/pengguna/{id}', [PenggunaController::class, 'show']);
    Route::put('/pengguna/{id}', [PenggunaController::class, 'update']);
    Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy']);
    
    // Loans
    Route::get('/peminjaman', [PeminjamanController::class, 'index']);
});