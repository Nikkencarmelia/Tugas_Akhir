<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Batch;
use Illuminate\Support\Facades\DB;

class UpdateStokMasukTerakhirSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Update all existing batches to set stok_masuk_terakhir = stok
        // This assumes that the current stock is the initial stock for existing batches
        DB::table('batches')->update([
            'stok_masuk_terakhir' => DB::raw('stok')
        ]);

        $this->command->info('Successfully updated stok_masuk_terakhir for all existing batches!');
        $this->command->info('Total batches updated: ' . Batch::count());
    }
}
