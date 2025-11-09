<?php

return [
    [
        'key'   => 'ebayconnector',
        'name'  => 'eBay Connector',
        'route' => 'ebayconnector.admin.configuration.index',
        'sort'  => 7,
    ],
    [
        'key'   => 'ebayconnector.configuration',
        'name'  => 'Configuration',
        'route' => 'ebayconnector.admin.configuration.index',
        'sort'  => 1,
    ],
    [
        'key'   => 'ebayconnector.products',
        'name'  => 'Product Sync',
        'route' => 'ebayconnector.admin.products.index',
        'sort'  => 2,
    ],
    [
        'key'   => 'ebayconnector.orders',
        'name'  => 'Order Sync',
        'route' => 'ebayconnector.admin.orders.index',
        'sort'  => 3,
    ],
    [
        'key'   => 'ebayconnector.logs',
        'name'  => 'Sync Logs',
        'route' => 'ebayconnector.admin.logs.index',
        'sort'  => 4,
    ],
];
