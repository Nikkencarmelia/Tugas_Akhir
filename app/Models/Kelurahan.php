<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kecamatan',
        'nama_kelurahan',
    ];

    public function kecamatan(){

    }
}
