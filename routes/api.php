<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']); // Bisa hapus kalau hanya web
Route::post('/login', [AuthController::class, 'login']); // Bisa hapus kalau hanya web
Route::get('/produk', [ProdukController::class, 'index']);
Route::post('/produk', [ProdukController::class, 'store']);
Route::get('/produk/{id}', [ProdukController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'apiUser']);
    Route::post('/admin/logout', [AuthController::class, 'adminLogout']);
    // Route::post('/logout', [AuthController::class, 'logout']);
});
