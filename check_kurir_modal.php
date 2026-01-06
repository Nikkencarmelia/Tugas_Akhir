<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking Kurir data for cariKurir modal...\n\n";

// Check all users with role kurir
$allKurirs = App\Models\User::where('role', 'kurir')->get();
echo "Total users with role 'kurir': " . $allKurirs->count() . "\n\n";

foreach ($allKurirs as $user) {
    echo "User ID: " . $user->id . "\n";
    echo "Name: " . $user->nama_lengkap . "\n";
    echo "Status Online: " . $user->status_online . "\n";
    
    $kurirRecord = App\Models\Kurir::where('id_user', $user->id)->first();
    if ($kurirRecord) {
        echo "Kurir Record: EXISTS\n";
        echo "  - jenis_kendaraan: " . ($kurirRecord->jenis_kendaraan ?? 'NULL') . "\n";
        echo "  - status_antar: " . ($kurirRecord->status_antar ?? 'NULL') . "\n";
    } else {
        echo "Kurir Record: NOT FOUND\n";
    }
    echo "---\n\n";
}

// Check kurirs that would appear in modal (with jenis_kendaraan)
echo "\n=== Kurirs that should appear in modal ===\n";
$kurirs = App\Models\User::where('role', 'kurir')
    ->whereHas('kurir', function($query) {
        $query->whereNotNull('jenis_kendaraan');
    })->with('kurir')->get();

echo "Count: " . $kurirs->count() . "\n\n";

foreach ($kurirs as $kurir) {
    echo "- " . $kurir->nama_lengkap . " (" . $kurir->kurir->jenis_kendaraan . ")\n";
}
