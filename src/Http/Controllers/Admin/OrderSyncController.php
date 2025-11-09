<?php

namespace KevinBHarris\EbayConnector\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use KevinBHarris\EbayConnector\Models\EbayOrderMapping;
use KevinBHarris\EbayConnector\Services\OrderSyncService;

class OrderSyncController extends Controller
{
    protected OrderSyncService $syncService;

    public function __construct(OrderSyncService $syncService)
    {
        $this->syncService = $syncService;
    }

    /**
     * Display order sync page.
     */
    public function index()
    {
        $mappings = EbayOrderMapping::with('order')
            ->orderBy('last_synced_at', 'desc')
            ->paginate(20);

        return view('ebayconnector::admin.orders.index', compact('mappings'));
    }

    /**
     * Sync specific order.
     */
    public function sync(Request $request): JsonResponse
    {
        $request->validate([
            'ebay_order_id' => 'required|string',
        ]);

        $success = $this->syncService->syncOrderById($request->ebay_order_id);

        return response()->json([
            'success' => $success,
            'message' => $success 
                ? 'Order synced successfully' 
                : 'Failed to sync order',
        ]);
    }

    /**
     * Sync new orders.
     */
    public function syncNew(): JsonResponse
    {
        $results = $this->syncService->syncNewOrders();

        return response()->json([
            'success' => $results['failed'] === 0,
            'message' => "Synced {$results['success']} orders successfully",
            'results' => $results,
        ]);
    }

    /**
     * Get order mappings.
     */
    public function mappings()
    {
        $mappings = EbayOrderMapping::with('order')
            ->orderBy('last_synced_at', 'desc')
            ->paginate(20);

        return view('ebayconnector::admin.orders.mappings', compact('mappings'));
    }
}
