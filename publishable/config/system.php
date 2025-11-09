<?php

return [
    [
        'key'  => 'sales.carriers.ebayconnector',
        'name' => 'eBay Connector',
        'sort' => 0,
        'fields' => [
            [
                'name'          => 'active',
                'title'         => 'ebayconnector::app.configuration.enabled',
                'type'          => 'boolean',
                'validation'    => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'environment',
                'title'         => 'ebayconnector::app.configuration.environment',
                'type'          => 'select',
                'options'       => [
                    [
                        'title' => 'Sandbox',
                        'value' => 'sandbox',
                    ],
                    [
                        'title' => 'Production',
                        'value' => 'production',
                    ],
                ],
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'api_key',
                'title'         => 'ebayconnector::app.configuration.api_key',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'api_secret',
                'title'         => 'ebayconnector::app.configuration.api_secret',
                'type'          => 'password',
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'dev_id',
                'title'         => 'ebayconnector::app.configuration.dev_id',
                'type'          => 'text',
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'cert_id',
                'title'         => 'ebayconnector::app.configuration.cert_id',
                'type'          => 'text',
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'oauth_redirect_uri',
                'title'         => 'ebayconnector::app.configuration.oauth_redirect_uri',
                'type'          => 'text',
                'channel_based' => true,
                'locale_based'  => false,
            ],
        ],
    ],
    [
        'key'  => 'sales.carriers.ebayconnector.sync',
        'name' => 'ebayconnector::app.configuration.sync_settings',
        'sort' => 1,
        'fields' => [
            [
                'name'          => 'auto_sync_products',
                'title'         => 'ebayconnector::app.configuration.auto_sync_products',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'auto_sync_orders',
                'title'         => 'ebayconnector::app.configuration.auto_sync_orders',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'sync_interval',
                'title'         => 'ebayconnector::app.configuration.sync_interval',
                'type'          => 'text',
                'validation'    => 'numeric|min:1',
                'channel_based' => true,
                'locale_based'  => false,
            ],
        ],
    ],
    [
        'key'  => 'sales.carriers.ebayconnector.product_sync',
        'name' => 'ebayconnector::app.configuration.product_sync_settings',
        'sort' => 2,
        'fields' => [
            [
                'name'          => 'sync_images',
                'title'         => 'ebayconnector::app.configuration.sync_images',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'sync_inventory',
                'title'         => 'ebayconnector::app.configuration.sync_inventory',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'sync_pricing',
                'title'         => 'ebayconnector::app.configuration.sync_pricing',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'sync_attributes',
                'title'         => 'ebayconnector::app.configuration.sync_attributes',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'default_listing_duration',
                'title'         => 'ebayconnector::app.configuration.default_listing_duration',
                'type'          => 'select',
                'options'       => [
                    [
                        'title' => 'Good Till Cancelled (GTC)',
                        'value' => 'GTC',
                    ],
                    [
                        'title' => '3 Days',
                        'value' => 'Days_3',
                    ],
                    [
                        'title' => '5 Days',
                        'value' => 'Days_5',
                    ],
                    [
                        'title' => '7 Days',
                        'value' => 'Days_7',
                    ],
                    [
                        'title' => '10 Days',
                        'value' => 'Days_10',
                    ],
                    [
                        'title' => '30 Days',
                        'value' => 'Days_30',
                    ],
                ],
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'default_dispatch_time',
                'title'         => 'ebayconnector::app.configuration.default_dispatch_time',
                'type'          => 'text',
                'validation'    => 'numeric|min:1',
                'channel_based' => true,
                'locale_based'  => false,
            ],
        ],
    ],
    [
        'key'  => 'sales.carriers.ebayconnector.order_sync',
        'name' => 'ebayconnector::app.configuration.order_sync_settings',
        'sort' => 3,
        'fields' => [
            [
                'name'          => 'sync_status',
                'title'         => 'ebayconnector::app.configuration.sync_status',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'sync_tracking',
                'title'         => 'ebayconnector::app.configuration.sync_tracking',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'create_customers',
                'title'         => 'ebayconnector::app.configuration.create_customers',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'default_order_status',
                'title'         => 'ebayconnector::app.configuration.default_order_status',
                'type'          => 'select',
                'options'       => [
                    [
                        'title' => 'Pending',
                        'value' => 'pending',
                    ],
                    [
                        'title' => 'Processing',
                        'value' => 'processing',
                    ],
                    [
                        'title' => 'Completed',
                        'value' => 'completed',
                    ],
                ],
                'channel_based' => true,
                'locale_based'  => false,
            ],
        ],
    ],
    [
        'key'  => 'sales.carriers.ebayconnector.logging',
        'name' => 'ebayconnector::app.configuration.logging_settings',
        'sort' => 4,
        'fields' => [
            [
                'name'          => 'enabled',
                'title'         => 'ebayconnector::app.configuration.logging_enabled',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ],
            [
                'name'          => 'retention_days',
                'title'         => 'ebayconnector::app.configuration.retention_days',
                'type'          => 'text',
                'validation'    => 'numeric|min:1',
                'channel_based' => true,
                'locale_based'  => false,
            ],
        ],
    ],
];
