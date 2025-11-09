<?php

namespace KevinBHarris\EbayConnector\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use KevinBHarris\EbayConnector\Models\EbayConfiguration;
use KevinBHarris\EbayConnector\Services\EbayApiClient;

class ConfigurationController extends Controller
{
    /**
     * Display configuration page.
     */
    public function index()
    {
        $configurations = EbayConfiguration::all()->pluck('value', 'key');

        return view('ebayconnector::admin.configuration.index', compact('configurations'));
    }

    /**
     * Store configuration.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'api_key' => 'required|string',
            'api_secret' => 'required|string',
            'environment' => 'required|in:sandbox,production',
        ]);

        $configData = [
            'api_key' => $request->api_key,
            'api_secret' => $request->api_secret,
            'environment' => $request->environment,
            'dev_id' => $request->dev_id,
            'cert_id' => $request->cert_id,
            'enabled' => $request->boolean('enabled'),
            'auto_sync_products' => $request->boolean('auto_sync_products'),
            'auto_sync_orders' => $request->boolean('auto_sync_orders'),
            'sync_interval' => $request->sync_interval ?? 15,
        ];

        foreach ($configData as $key => $value) {
            EbayConfiguration::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => is_bool($value) ? 'boolean' : 'string']
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Configuration saved successfully',
        ]);
    }

    /**
     * Test eBay API connection.
     */
    public function testConnection(Request $request): JsonResponse
    {
        $apiClient = new EbayApiClient(
            $request->api_key,
            $request->api_secret,
            $request->environment
        );

        $connected = $apiClient->testConnection();

        return response()->json([
            'success' => $connected,
            'message' => $connected 
                ? 'Connection successful!' 
                : 'Connection failed. Please check your credentials.',
        ]);
    }
}
