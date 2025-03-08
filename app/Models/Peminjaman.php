<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    //
    protected $table = 'peminjaman';
    protected $primaryKey = 'peminjaman_id';
    protected $fillable = [
        'pengguna_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function detailPeminjamans()
    {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id');
    }
}
