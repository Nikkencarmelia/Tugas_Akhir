<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kode_pos extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kecamatan',
        'id_kelurahan',
        'kode_pos',
    ];

    public function kecamatan(){

    }

    public function kelurahan(){

    }
}
