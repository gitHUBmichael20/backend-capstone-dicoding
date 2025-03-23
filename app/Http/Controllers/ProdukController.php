<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ProdukController extends Controller
{
    // Mengambil semua produk (untuk API)
    public function index()
    {
        $produk = Produk::all();
        return response()->json($produk);
    }

    // Menampilkan detail produk di view
    public function detailProduk($id)
    {
        $produk = Produk::findOrFail($id);
        $relatedProducts = Produk::where('kategori', $produk->kategori)
            ->where('produk_id', '!=', $id)
            ->take(4)
            ->get(); // Ambil 4 produk terkait dari kategori yang sama
        return view('detail_produk', [
            'produk' => $produk,
            'relatedProducts' => $relatedProducts
        ]);
    }

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

    // Mengambil detail produk berdasarkan ID (untuk API)
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return response()->json($produk);
    }
}