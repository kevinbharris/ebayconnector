<?php

namespace KevinBHarris\EbayConnector\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use KevinBHarris\EbayConnector\Models\EbayProductMapping;
use KevinBHarris\EbayConnector\Services\ProductSyncService;
use Webkul\Product\Models\Product;

class ProductSyncController extends Controller
{
    protected ProductSyncService $syncService;

    public function __construct(ProductSyncService $syncService)
    {
        $this->syncService = $syncService;
    }

    /**
     * Display product sync page.
     */
    public function index()
    {
        $products = Product::with('inventories')->paginate(20);
        $mappings = EbayProductMapping::with('product')->get();

        return view('ebayconnector::admin.products.index', compact('products', 'mappings'));
    }

    /**
     * Sync selected products.
     */
    public function sync(Request $request): JsonResponse
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $results = $this->syncService->syncMultipleToEbay($request->product_ids);

        return response()->json([
            'success' => $results['failed'] === 0,
            'message' => "Synced {$results['success']} products successfully",
            'results' => $results,
        ]);
    }

    /**
     * Sync all products.
     */
    public function syncAll(): JsonResponse
    {
        $results = $this->syncService->syncAllToEbay();

        return response()->json([
            'success' => $results['failed'] === 0,
            'message' => "Synced {$results['success']} products successfully",
            'results' => $results,
        ]);
    }

    /**
     * Get product mappings.
     */
    public function mappings()
    {
        $mappings = EbayProductMapping::with('product')
            ->orderBy('last_synced_at', 'desc')
            ->paginate(20);

        return view('ebayconnector::admin.products.mappings', compact('mappings'));
    }
}
