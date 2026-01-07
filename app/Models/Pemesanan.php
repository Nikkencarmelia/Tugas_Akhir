<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_kurir',
        'id_alamat',
        'kode_pesanan',
        'opsi_pengiriman',
        'nama_penerima',
        'no_telepon',
        'alamat_lengkap',
        'nama_kecamatan',
        'nama_kelurahan',
        'kode_pos',
        'kendaraan',
        'subtotal',
        'ongkir',
        'total',
        'status_pesanan',
    ];

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'id_pemesanan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function alamat()
    {
        return $this->belongsTo(Alamat::class, 'id_alamat');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pemesanan');
    }

    public function kurir()
    {
        return $this->belongsTo(User::class, 'id_kurir');
    }
}
