<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'produk_id' => 'required|integer|exists:produk,produk_id',
            'durasi' => 'required|integer|min:1',
            'jumlah_barang' => 'required|integer|min:1',
        ]);

        $produk = Produk::find($validated['produk_id']);
        if ($validated['jumlah_barang'] > $produk->stok) {
            return response()->json(['message' => 'Jumlah barang melebihi stok'], 400);
        }

        $keranjang = Keranjang::create([
            'pengguna_id' => Auth::id(), // Ambil ID pengguna dari autentikasi
            'produk_id' => $validated['produk_id'],
            'durasi' => $validated['durasi'],
            'jumlah_barang' => $validated['jumlah_barang'],
        ]);

        $keranjang->load('produk');
        $keranjang->nama_produk = $keranjang->produk->nama_produk;
        $keranjang->biaya_sewa = $keranjang->produk->biaya_sewa;

        return response()->json(['message' => 'Berhasil ditambahkan ke keranjang', 'data' => $keranjang], 201);
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
