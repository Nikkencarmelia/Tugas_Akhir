<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Updating all kurir records to have default vehicle if NULL...\n\n";

$updated = App\Models\Kurir::whereNull('jenis_kendaraan')->update(['jenis_kendaraan' => 'motor']);

echo "Updated: " . $updated . " records\n\n";

echo "=== All Kurir Records ===\n";
$allKurirs = App\Models\Kurir::with('user')->get();

foreach ($allKurirs as $kurir) {
    echo "ID: " . $kurir->id . " | User: " . $kurir->user->nama_lengkap . " | Vehicle: " . $kurir->jenis_kendaraan . " | Status: " . $kurir->status_antar . "\n";
}

echo "\n=== Kurirs that will appear in modal ===\n";
$kurirs = App\Models\User::where('role', 'kurir')
    ->whereHas('kurir', function($query) {
        $query->whereNotNull('jenis_kendaraan');
    })->with('kurir')->get();

echo "Count: " . $kurirs->count() . "\n";
foreach ($kurirs as $k) {
    echo "- " . $k->nama_lengkap . " (" . $k->kurir->jenis_kendaraan . ") - Status: " . $k->kurir->status_antar . "\n";
}
