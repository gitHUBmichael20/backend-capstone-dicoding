<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->has('harga_min') && $request->harga_min != '') {
            $query->where('biaya_sewa', '>=', $request->harga_min);
        }

        if ($request->has('harga_max') && $request->harga_max != '') {
            $query->where('biaya_sewa', '<=', $request->harga_max);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price-low-high':
                    $query->orderBy('biaya_sewa', 'asc');
                    break;
                case 'price-high-low':
                    $query->orderBy('biaya_sewa', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy('nama_produk', 'asc');
                    break;
            }
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'biaya_sewa' => 'required|integer|min:0', // Ubah menjadi integer
            'kategori' => 'required|in:Peralatan Dapur,Peralatan Kebersihan,Perabotan,Elektronik,Dekorasi', // Tambahkan validasi enum
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $data = $request->all();
        if ($request->hasFile('gambar_produk')) {
            $file = $request->file('gambar_produk');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('produk', $fileName, 'public');
            $data['gambar_produk'] = $fileName;
        }
    
        $produk = Produk::create($data);
        return response()->json(['message' => 'Product created successfully', 'data' => $produk], 201);
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return response()->json($produk);
    }

    public function update(Request $request, $id)
    {
        try {
            $produk = Produk::findOrFail($id);
    
            $request->validate([
                'nama_produk' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'stok' => 'required|integer|min:0',
                'biaya_sewa' => 'required|integer|min:0', // Ubah menjadi integer
                'kategori' => 'required|in:Peralatan Dapur,Peralatan Kebersihan,Perabotan,Elektronik,Dekorasi', // Tambahkan validasi enum
                'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);
    
            $data = $request->all();
            if ($request->hasFile('gambar_produk')) {
                if ($produk->gambar_produk && Storage::disk('public')->exists('produk/' . $produk->gambar_produk)) {
                    Storage::disk('public')->delete('produk/' . $produk->gambar_produk);
                }
                $file = $request->file('gambar_produk');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('produk', $fileName, 'public');
                $data['gambar_produk'] = $fileName;
            }
    
            $produk->update($data);
            return response()->json(['message' => 'Product updated successfully', 'data' => $produk]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update product: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        if ($produk->gambar_produk) {
            // Hapus file dari direktori produk
            Storage::disk('public')->delete('produk/' . $produk->gambar_produk);
        }
        $produk->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required|exists:pengguna,pengguna_id',
            'id_produk' => 'required|exists:produk,produk_id',
            'durasi_sewa' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->id_produk);
        if ($produk->stok <= 0) {
            return response()->json(['message' => 'Product out of stock'], 400);
        }

        $keranjang = \App\Models\Keranjang::create([
            'pengguna_id' => $request->id_pengguna,
            'produk_id' => $request->id_produk,
            'jumlah' => $request->durasi_sewa,
        ]);

        return response()->json(['message' => 'Product added to cart', 'data' => $keranjang]);
    }
}