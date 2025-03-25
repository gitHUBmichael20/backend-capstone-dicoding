<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{

    // ambil semua data pengguna
    public function index(Request $request)
    {
        // Increase memory limit temporarily
        ini_set('memory_limit', '512M');
        set_time_limit(300); // 5 minutes max execution time

        try {
            // Use a raw query to minimize memory overhead
            $query = DB::table('pengguna')
                ->select(
                    'pengguna_id',
                    'nama_pengguna',
                    'alamat',
                    'nomor_telepon',
                    'email',
                    'created_at',
                    'updated_at'
                );

            // Optional filtering if needed
            if ($request->has('filter')) {
                // Add any specific filtering logic if required
            }

            // Retrieve data
            $pengguna = $query->get();

            return response()->json([
                'success' => true,
                'total_records' => $pengguna->count(),
                'data' => $pengguna
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
