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
        'deskripsi',
        'stok'
    ];

    public function detailPeminjamans()
    {
        return $this->hasMany(DetailPeminjaman::class, 'produk_id');
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'produk_id');
    }
}
