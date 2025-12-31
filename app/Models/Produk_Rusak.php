<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk_Rusak extends Model
{
    use HasFactory;

    protected $table = 'produk_rusaks';

    protected $fillable = [
        'id_produk',
        'id_batch',
        'tgl_rusak',
        'jumlah_rusak',
        'tingkat_rusak',
        'keterangan',
        'gambar',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'id_batch');
    }

}
