<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    //
    public function index() {
        $produk = Produk::all();
        return response()->json($produk);
    }

    public function detailProduk($id) {
        $data = Produk::find($id);
        return view('detail_produk', ['produk' => $data]);
    }
}
