<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_kecamatan',
        'id_kelurahan',
        'id_kode_pos',
        'nama_penerima',
        'no_telpon',
        'alamat_lengkap',
    ];

    public function kecamatan() {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }

    public function kelurahan() {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
    }

    public function kodePos() {
        return $this->belongsTo(KodePos::class, 'id_kode_pos');
    }

    public function alamats() {
        return $this->hasMany(Alamat::class, 'id_user');
    }

}
