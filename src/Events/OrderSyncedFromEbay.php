<?php

namespace KevinBHarris\EbayConnector\Events;

use Webkul\Sales\Models\Order;

class OrderSyncedFromEbay
{
    public Order $order;
    public bool $success;
    public ?array $ebayOrderData;

    public function __construct(Order $order, bool $success, ?array $ebayOrderData = null)
    {
        $this->order = $order;
        $this->success = $success;
        $this->ebayOrderData = $ebayOrderData;
    }
}
