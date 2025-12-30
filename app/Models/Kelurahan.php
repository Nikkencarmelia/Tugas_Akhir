<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kecamatan',
        'nama_kelurahan',
    ];

    public function kecamatan(){
    return $this->belongsTo(Kecamatan::class,'id_kecamatan');
    }

    public function kodePos(){
        return $this->hasMany(KodePos::class,'id_kelurahan');
    }

}
