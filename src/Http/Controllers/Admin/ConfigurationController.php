<?php

namespace KevinBHarris\EbayConnector\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use KevinBHarris\EbayConnector\Services\EbayApiClient;

class ConfigurationController extends Controller
{
    /**
     * Display configuration page.
     */
    public function index()
    {
        // Redirect to Bagisto's core configuration page for eBay Connector
        return redirect()->route('admin.configuration.index', ['sales', 'carriers']);
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
