<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'jenis_kendaraan',
        'status_antar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function syncStatus()
    {
        $hasActiveDeliveries = \App\Models\Pemesanan::where('id_kurir', $this->id_user)
            ->whereIn('status_pesanan', ['dikirim', 'sedang_diantar'])
            ->exists();

        if ($hasActiveDeliveries) {
            $this->update(['status_antar' => 'sedang_antar']);

            return;
        }

        $newStatus = ($this->user->status_online === 'aktif') ? 'siap' : '-';
        if ($this->status_antar !== $newStatus) {
            $this->update(['status_antar' => $newStatus]);
        }
    }
}
