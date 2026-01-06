<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodePos extends Model
{
    use HasFactory;

    protected $table = 'kode_pos';

    protected $fillable = [
        'id_kelurahan',
        'kode_pos',
    ];

    public function kelurahan(){
        return $this->belongsTo(Kelurahan::class,'id_kelurahan');
    }

}
