<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        // Filter Kategori
        if ($request->has('kategori') && $request->kategori) {
            \Log::info('Filter kategori diterapkan: '.$request->kategori); // Debugging
            $query->where('kategori', $request->kategori);
        }

        // Filter Harga
        if ($request->has('harga_min') && $request->harga_min) {
            $query->where('biaya_sewa', '>=', $request->harga_min);
        }
        if ($request->has('harga_max') && $request->harga_max) {
            $query->where('biaya_sewa', '<=', $request->harga_max);
        }

        // Filter Ketersediaan
        if ($request->has('tersedia') && $request->tersedia) {
            $query->where('stok', '>', 0);
        }

        // Filter Pengiriman Gratis (jika ada kolomnya)
        if ($request->has('pengiriman_gratis') && $request->pengiriman_gratis) {
            $query->where('pengiriman_gratis', 1);
        }

        // Filter Promo (jika ada kolomnya)
        if ($request->has('promo') && $request->promo) {
            $query->where('promo', 1);
        }

        // Filter Rating (jika ada kolomnya)
        if ($request->has('rating') && $request->rating) {
            $query->where('rating', '>=', $request->rating);
        }

        // Sorting
        $sort = $request->query('sort', 'popular');
        if ($sort === 'price-low-high') {
            $query->orderBy('biaya_sewa', 'asc');
        } elseif ($sort === 'price-high-low') {
            $query->orderBy('biaya_sewa', 'desc');
        } elseif ($sort === 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort === 'rating') {
            $query->orderBy('rating', 'desc');
        }

        // Ambil data
        $produk = $query->get();
        \Log::info('Jumlah produk ditemukan: '.$produk->count()); // Debugging

        return response()->json($produk);
    }

    public function show($produk_id)
    {
        // Ambil produk berdasarkan produk_id
        $produk = Produk::findOrFail($produk_id);
    
        // Ambil produk terkait berdasarkan kategori (kecuali produk yang sedang dilihat)
        $relatedProducts = Produk::where('kategori', $produk->kategori)
                                ->where('produk_id', '!=', $produk->produk_id)
                                ->take(4) // Ambil 4 produk terkait
                                ->get();
    
        return view('detail_produk', compact('produk', 'relatedProducts'));
    }
}
