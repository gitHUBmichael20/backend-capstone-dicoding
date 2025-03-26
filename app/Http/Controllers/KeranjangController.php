<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    //
    public function index($idUser) {
        $keranjang = Keranjang::where('keranjang.pengguna_id', $idUser)
            ->join('produk', 'keranjang.produk_id', '=', 'produk.produk_id')
            ->select('keranjang.*', 'produk.nama_produk', 'produk.biaya_sewa')
            ->get();

        return response()->json($keranjang);
    }

    public function delete($idKeranjang) {
        $keranjang = Keranjang::findOrFail($idKeranjang);
        $keranjang->delete();

        return response()->json([
            'message' => 'Produk berhasil dihapus dari keranjang'
        ]);
    }

    public function deleteAll($idUser) {
        $keranjang = Keranjang::where('pengguna_id', $idUser);

        // Jika tidak ada data, kirim response 404
        if (!$keranjang->exists()) {
            return response()->json([
                'message' => 'Keranjang sudah kosong atau tidak ditemukan'
            ], 404);
        }

        // Hapus data jika ada
        $keranjang->delete();

        return response()->json([
            'message' => 'Keranjang berhasil dikosongkan'
        ]);
    }

}
