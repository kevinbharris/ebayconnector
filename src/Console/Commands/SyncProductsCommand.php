<?php

namespace KevinBHarris\EbayConnector\Console\Commands;

use Illuminate\Console\Command;
use KevinBHarris\EbayConnector\Services\ProductSyncService;

class SyncProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:sync-products 
                            {--all : Sync all products}
                            {--ids= : Comma-separated list of product IDs to sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync products between Bagisto and eBay';

    /**
     * Execute the console command.
     */
    public function handle(ProductSyncService $syncService): int
    {
        $this->info('Starting product synchronization...');

        if ($this->option('all')) {
            $this->info('Syncing all products to eBay...');
            $results = $syncService->syncAllToEbay();
        } elseif ($this->option('ids')) {
            $productIds = explode(',', $this->option('ids'));
            $this->info('Syncing selected products to eBay...');
            $results = $syncService->syncMultipleToEbay($productIds);
        } else {
            $this->error('Please specify --all or --ids option');
            return self::FAILURE;
        }

        $this->info("Sync completed!");
        $this->info("Success: {$results['success']}");
        $this->info("Failed: {$results['failed']}");

        if (!empty($results['errors'])) {
            $this->error('Errors:');
            foreach ($results['errors'] as $error) {
                $this->error("  - {$error}");
            }
        }

        return self::SUCCESS;
    }
}
