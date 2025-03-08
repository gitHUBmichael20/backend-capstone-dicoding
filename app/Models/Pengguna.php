<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array{
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
