<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_google',
        'nama_lengkap',
        'role',
        'email',
        'no_telepon',
        'password',
        'status_online',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function kurir()
    {
        return $this->hasOne(Kurir::class, 'id_user');
    }

    public function alamats()
    {
        return $this->hasMany(Alamat::class, 'id_user');
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'id_user');
    }
}
