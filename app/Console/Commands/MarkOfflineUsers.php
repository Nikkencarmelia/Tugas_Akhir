<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MarkOfflineUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:mark-offline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark users as offline if inactive for more than 5 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threshold = now()->subMinutes(5); // Ganti 5 jadi 10 kalau mau lebih lama

        $inactiveUserIds = \Illuminate\Support\Facades\DB::table('sessions')
            ->whereNotNull('user_id')
            ->where('last_activity', '<', $threshold->timestamp)
            ->distinct()
            ->pluck('user_id');

        $updated = \App\Models\User::whereIn('id', $inactiveUserIds)
            ->where('status_online', 'aktif')
            ->update(['status_online' => 'tidak_aktif']);

        $this->info("Berhasil update {$updated} user menjadi tidak_aktif.");
    }
}
