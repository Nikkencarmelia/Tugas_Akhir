<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kategori',
        'id_satuan',
        'id_supplier',
        'nama_produk',
        'status_tampil',
        'deskripsi',
        'gambar',
    ];

    public function batch()
    {
        return $this->hasMany(Batch::class, 'id_produk');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan');
    }
}
