<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'stok' => 'required|integer|min:0',
            'biaya_sewa' => 'required|numeric',
            'gambar_produk' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar_produk')) {
            $image = $request->file('gambar_produk');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('storage/produk/' . $filename);

            // Kompres dan simpan gambar
            Image::make($image)->resize(300, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path, 80); // Kualitas 80%

            $validated['gambar_produk'] = 'storage/produk/' . $filename;
        }

        $produk = Produk::create($validated);

        return response()->json(['message' => 'Produk berhasil ditambahkan', 'data' => $produk], 201);
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

    public function addToCart(Request $request){
    $validated = $request->validate([
        'id_pengguna' => 'required|integer|exists:pengguna,pengguna_id',
        'id_produk' => 'required|integer|exists:produk,produk_id',
        'durasi_sewa' => 'required|integer|min:1',
    ]);

    try {
        Keranjang::create([
            'pengguna_id' => $validated['id_pengguna'],
            'produk_id' => $validated['id_produk'],
            'jumlah' => $validated['durasi_sewa'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan ke keranjang',
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menambahkan produk ke keranjang. ' . $e->getMessage()
        ], 500);
    }
}

}
