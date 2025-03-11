<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    //
    public function index() {
        $data = Produk::all();
        return $data;
    }

    public function detailProduk($id) {
        $data = Produk::find($id);
        return $data;
    }
}
