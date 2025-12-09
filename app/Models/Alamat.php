<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kecamatan',
        'id_kelurahan',
        'id_kode_pos',
        'nama_penerima',
        'no_telpon',
        'alamat_lengkap',
    ];

    public function kecamatan(){

    }

    public function kelurahan(){

    }

    public function kode_pos(){

    }
}
