<?php

namespace KevinBHarris\EbayConnector\Console\Commands;

use Illuminate\Console\Command;
use KevinBHarris\EbayConnector\Services\OrderSyncService;

class SyncOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:sync-orders 
                            {--new : Sync new orders from last 24 hours}
                            {--id= : Sync specific order by eBay order ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync orders from eBay to Bagisto';

    /**
     * Execute the console command.
     */
    public function handle(OrderSyncService $syncService): int
    {
        $this->info('Starting order synchronization...');

        if ($this->option('new')) {
            $this->info('Syncing new orders from eBay...');
            $results = $syncService->syncNewOrders();
            
            $this->info("Sync completed!");
            $this->info("Success: {$results['success']}");
            $this->info("Failed: {$results['failed']}");

            if (!empty($results['errors'])) {
                $this->error('Errors:');
                foreach ($results['errors'] as $error) {
                    $this->error("  - {$error}");
                }
            }
        } elseif ($this->option('id')) {
            $orderId = $this->option('id');
            $this->info("Syncing order {$orderId} from eBay...");
            
            if ($syncService->syncOrderById($orderId)) {
                $this->info('Order synced successfully!');
            } else {
                $this->error('Failed to sync order');
                return self::FAILURE;
            }
        } else {
            $this->error('Please specify --new or --id option');
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
