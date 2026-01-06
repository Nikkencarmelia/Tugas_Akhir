<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasKurir extends Model
{
    use HasFactory;

    protected $table = 'tugas_kurir';

    protected $fillable = [
        'id_pemesanan',
        'id_kurir',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }

    public function kurir()
    {
        return $this->belongsTo(User::class, 'id_kurir');
    }
}
