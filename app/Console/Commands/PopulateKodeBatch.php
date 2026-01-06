<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PopulateKodeBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-kode-batch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate existing batches with kode_batch format: BATCH-ddmmyyyy-kode_produk-xxx';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $batches = \App\Models\Batch::with('produk')->get();
        $this->info('Populating kode_batch for ' . $batches->count() . ' batches...');

        foreach ($batches as $batch) {
            if (!$batch->kode_batch) {
                $todayStr = $batch->created_at->format('dmY');
                $prodCode = $batch->produk->kode_produk ?? 'PRD-UNK';
                
                // Sequence per product
                $sequence = \App\Models\Batch::where('id_produk', $batch->id_produk)
                    ->where('id', '<', $batch->id)
                    ->count() + 1;
                    
                $sequencePadded = str_pad($sequence, 3, '0', STR_PAD_LEFT);
                $batch->kode_batch = "BATCH-{$todayStr}-{$prodCode}-{$sequencePadded}";
                $batch->save();
            }
        }

        $this->info('Done!');
    }
}
