<?php

return [
    /*
    |--------------------------------------------------------------------------
    | eBay API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for eBay API integration. These settings can be managed
    | through the admin panel.
    |
    */

    'enabled' => env('EBAY_CONNECTOR_ENABLED', false),

    'environment' => env('EBAY_ENVIRONMENT', 'sandbox'), // 'production' or 'sandbox'

    'api_key' => env('EBAY_API_KEY', ''),

    'api_secret' => env('EBAY_API_SECRET', ''),

    'oauth_redirect_uri' => env('EBAY_OAUTH_REDIRECT_URI', ''),

    'dev_id' => env('EBAY_DEV_ID', ''),

    'cert_id' => env('EBAY_CERT_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Synchronization Settings
    |--------------------------------------------------------------------------
    */

    'auto_sync' => [
        'products' => env('EBAY_AUTO_SYNC_PRODUCTS', false),
        'orders' => env('EBAY_AUTO_SYNC_ORDERS', false),
    ],

    'sync_interval' => env('EBAY_SYNC_INTERVAL', 15), // minutes

    /*
    |--------------------------------------------------------------------------
    | Product Sync Settings
    |--------------------------------------------------------------------------
    */

    'product_sync' => [
        'sync_images' => true,
        'sync_inventory' => true,
        'sync_pricing' => true,
        'sync_attributes' => true,
        'default_listing_duration' => 'GTC', // Good 'Til Cancelled
        'default_dispatch_time' => 3, // days
    ],

    /*
    |--------------------------------------------------------------------------
    | Order Sync Settings
    |--------------------------------------------------------------------------
    */

    'order_sync' => [
        'sync_status' => true,
        'sync_tracking' => true,
        'create_customers' => true,
        'default_order_status' => 'pending',
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    */

    'logging' => [
        'enabled' => true,
        'retention_days' => 30,
    ],

    /*
    |--------------------------------------------------------------------------
    | API Endpoints
    |--------------------------------------------------------------------------
    */

    'api_endpoints' => [
        'production' => 'https://api.ebay.com',
        'sandbox' => 'https://api.sandbox.ebay.com',
    ],

    'oauth_endpoints' => [
        'production' => 'https://api.ebay.com/identity/v1/oauth2/token',
        'sandbox' => 'https://api.sandbox.ebay.com/identity/v1/oauth2/token',
    ],
];
