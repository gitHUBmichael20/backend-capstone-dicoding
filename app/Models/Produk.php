<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    //
    protected $table = 'produk';
    protected $primaryKey = 'produk_id';
    protected $fillable = [
        'nama_produk',
        'gambar_produk',
        'deskripsi',
        'stok',
        'biaya_sewa',
        'kategori'
    ];

    public function detailPeminjamans()
    {
        return $this->hasMany(DetailPeminjaman::class, 'produk_id');
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'produk_id');
    }

    public function decrementStocks()
    {
        if ($this->stok <= 0) {
            throw new \Exception('Stok produk sudah habis');
        }

        $this->stok -= 1;
        $this->save();

        return true;
    }
}
