<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pemesanan',
        'id_produk',
        'id_batch',
        'nama_produk',
        'gambar',
        'quantity',
        'satuan',
        'jumlah_satuan',
        'harga_satuan',
        'harga_total'
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'id_batch');
    }
}
