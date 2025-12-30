<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'jenis_kendaraan',
        'status_antar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
