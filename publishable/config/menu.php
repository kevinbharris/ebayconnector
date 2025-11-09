<?php

return [
    [
        'key'        => 'ebayconnector',
        'name'       => 'eBay Connector',
        'route'      => 'ebayconnector.admin.configuration.index',
        'sort'       => 7,
        'icon'       => 'icon-integration',
    ],
    [
        'key'        => 'ebayconnector.configuration',
        'name'       => 'Configuration',
        'route'      => 'ebayconnector.admin.configuration.index',
        'sort'       => 1,
        'icon'       => '',
    ],
    [
        'key'        => 'ebayconnector.products',
        'name'       => 'Product Sync',
        'route'      => 'ebayconnector.admin.products.index',
        'sort'       => 2,
        'icon'       => '',
    ],
    [
        'key'        => 'ebayconnector.orders',
        'name'       => 'Order Sync',
        'route'      => 'ebayconnector.admin.orders.index',
        'sort'       => 3,
        'icon'       => '',
    ],
    [
        'key'        => 'ebayconnector.logs',
        'name'       => 'Sync Logs',
        'route'      => 'ebayconnector.admin.logs.index',
        'sort'       => 4,
        'icon'       => '',
    ],
];
