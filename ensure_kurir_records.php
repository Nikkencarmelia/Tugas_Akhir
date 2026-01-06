<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Ensuring all kurir users have kurir records...\n\n";

$kurirUsers = App\Models\User::where('role', 'kurir')->get();

echo "Found " . $kurirUsers->count() . " users with role 'kurir'\n\n";

foreach ($kurirUsers as $user) {
    $kurirRecord = App\Models\Kurir::where('id_user', $user->id)->first();
    
    if (!$kurirRecord) {
        echo "Creating kurir record for: " . $user->nama_lengkap . "\n";
        $kurir = App\Models\Kurir::create([
            'id_user' => $user->id,
            'jenis_kendaraan' => 'motor',
            'status_antar' => '-'
        ]);
        echo "  Created with ID: " . $kurir->id . "\n";
    } else {
        echo "Kurir record exists for: " . $user->nama_lengkap . "\n";
        if ($kurirRecord->jenis_kendaraan === null) {
            $kurirRecord->update(['jenis_kendaraan' => 'motor']);
            echo "  Updated jenis_kendaraan to 'motor'\n";
        }
    }
}

echo "\n=== Final Check ===\n";
$kurirs = App\Models\User::where('role', 'kurir')
    ->whereHas('kurir', function($query) {
        $query->whereNotNull('jenis_kendaraan');
    })->with('kurir')->get();

echo "Kurirs that will appear in modal: " . $kurirs->count() . "\n\n";
foreach ($kurirs as $k) {
    echo "✓ " . $k->nama_lengkap . " | Vehicle: " . $k->kurir->jenis_kendaraan . " | Status Antar: " . $k->kurir->status_antar . " | Online: " . $k->status_online . "\n";
}
