<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk_Rusak extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_produk',
        'id_batch',
        'tgl_rusak',
        'jumlah_rusak',
        'tingkat_rusak',
        'keterangan',
        'gambar',
    ];

    public function produk(){

    }

    public function batch(){

    }

}
