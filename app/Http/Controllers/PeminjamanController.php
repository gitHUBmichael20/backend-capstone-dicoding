<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // ambil semua data peminjaman
    public function index()
    {
        // Increase memory limit temporarily
        ini_set('memory_limit', '512M');
        set_time_limit(300); // 5 minutes max execution time

        try {
            // Use a raw query to minimize memory overhead
            $peminjaman = DB::table('peminjaman')
                ->select(
                    'peminjaman_id',
                    'pengguna_id',
                    'tanggal_pinjam',
                    'tanggal_kembali',
                    'status',
                    'created_at',
                    'updated_at'
                )
                ->get();

            return response()->json([
                'success' => true,
                'total_records' => $peminjaman->count(),
                'data' => $peminjaman
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
