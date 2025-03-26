<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    //
    protected $table = 'keranjang';

    protected $primaryKey = 'keranjang_id';

    protected $fillable = [
        'pengguna_id',
        'produk_id',
        'jumlah',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
