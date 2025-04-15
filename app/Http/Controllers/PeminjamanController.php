<?php

namespace App\Http\Controllers;
use App\Models\DetailPeminjaman;
use App\Models\Keranjang;
use App\Models\Peminjaman;
use App\Models\Produk;
use App\Http\Controllers\ProdukController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    //
    public function store(Request $request) {
        // dd($request->all());
        $data = $request->input('data');
        // // dd($data);
        // Log::info("Data yang diterima:", $request->all());
        // if (!$request->has('data') || !is_array($request->input('data'))) {
        //     return response()->json(['error' => 'Data tidak valid!'], 400);
        // } else {
        //     return response()->json(['success' => 'data valid']);
        // }

        try {
            DB::beginTransaction();
            foreach ($data as $item) {
                $peminjaman = Peminjaman::create([
                    'pengguna_id' => $item['pengguna_id'],
                    'tanggal_pinjam' => $item['tanggal_peminjaman'],
                    'tanggal_kembali' => $item['tanggal_pengembalian'],
                    'status' => $item['status']
                ]);
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->peminjaman_id,
                    'produk_id' => $item['produk_id'],
                    'jumlah' => $item['jumlah'],
                ]);
                $produkControlller = new ProdukController();
                $produkControlller->decrementStocks($item['produk_id']);
                $keranjangController = new KeranjangController();
                $keranjangController->deleteAll($item['pengguna_id']);
            }
            DB::commit();
            return response()->json(['message' => 'Berhasil membuat peminjaman!']);

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika ada error
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }

        // return response()->json($data);
    }
}
