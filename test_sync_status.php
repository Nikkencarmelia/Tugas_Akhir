<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Kurir syncStatus method...\n\n";

$kurir = App\Models\Kurir::first();

if (!$kurir) {
    echo "No courier found in database.\n";
    exit;
}

echo "Courier: " . $kurir->user->nama_lengkap . "\n";
echo "Online Status: " . $kurir->user->status_online . "\n";
echo "Status Antar (Before): " . $kurir->status_antar . "\n";

$activeDeliveries = App\Models\Pemesanan::where('id_kurir', $kurir->id_user)
    ->whereIn('status_pesanan', ['dikirim', 'sedang_diantar'])
    ->count();

echo "Active Deliveries: " . $activeDeliveries . "\n\n";

echo "Calling syncStatus()...\n";
$kurir->syncStatus();
$kurir->refresh();

echo "Status Antar (After): " . $kurir->status_antar . "\n\n";

echo "Expected Status: ";
if ($activeDeliveries > 0) {
    echo "sedang_antar\n";
} elseif ($kurir->user->status_online === 'aktif') {
    echo "siap\n";
} else {
    echo "-\n";
}
