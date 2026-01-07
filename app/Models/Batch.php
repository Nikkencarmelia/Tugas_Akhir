<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_produk',
        'kode_batch',
        'tgl_masuk',
        'stok',
        'status_stok',
        'harga_normal',
        'harga_saat_ini',
        'tgl_perubahan_harga',
        'tgl_kadaluwarsa',
        'keterangan_harga',
    ];

    protected $casts = [
        'tgl_masuk' => 'date',
        'tgl_kadaluwarsa' => 'date',
        'tgl_perubahan_harga' => 'datetime',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
