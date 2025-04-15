<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ProdukController extends Controller
{
    // Mengambil semua produk (untuk API)
    public function index(Request $request)
    {
        $query = Produk::query();
    
        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori !== '') {
            $query->where('kategori', $request->kategori);
        }
    
        // Filter berdasarkan harga
        if ($request->has('harga_min') && $request->harga_min !== '') {
            $query->where('biaya_sewa', '>=', $request->harga_min);
        }
        if ($request->has('harga_max') && $request->harga_max !== '') {
            $query->where('biaya_sewa', '<=', $request->harga_max);
        }
    
        // Filter pencarian berdasarkan nama produk
        if ($request->has('search') && $request->search !== '') {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }
    
        // Sorting
        if ($request->has('sort') && $request->sort !== '') {
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
                case 'terpopuler':
                default:
                    $query->orderBy('created_at', 'desc'); // Default sorting
            }
        }
    
        $produk = $query->get();
    
        // Tambahkan gambar_url ke setiap produk
        $produk->map(function ($item) {
            $item->gambar_url = $item->gambar_produk ? asset($item->gambar_produk) : asset('storage/produk/no_image.png');
            return $item;
        });
    
        return response()->json($produk);
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
        
        $produk->gambar_url = asset('storage/produk/' . $produk->gambar_produk);
        
        return response()->json([
            'produk_id' => $produk->produk_id,
            'nama_produk' => $produk->nama_produk,
            'kategori' => $produk->kategori,
            'deskripsi' => $produk->deskripsi,
            'stok' => $produk->stok,
            'biaya_sewa' => $produk->biaya_sewa,
            'gambar_url' => $produk->gambar_url,
        ]);
    }

    public function addToCart(Request $request)
    {
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
    public function decreaseStocks($produkId) {
        $produk = Produk::find($produkId);
        if ($produk) {
            $produk->stok--;
            if ($produk->stok < 0) {
                return response()->json(['error' => 'Stok tidak mencukupi']);
            }
            $produk->save();
        }
    }

}
