<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    //
    protected $table = 'pengguna';
    protected $primaryKey = 'pengguna_id';
    protected $fillable = [
        'nama_pengguna',
        'alamat',
        'nomor_telepon',
        'email',
        'password'
    ];

    public function peminjaman(){
        return $this->hasMany(Peminjaman::class, 'pengguna_id');
    }

    public function keranjang(){
        return $this->hasMany(Keranjang::class, 'pengguna_id');
    }
}
