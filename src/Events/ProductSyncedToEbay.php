<?php

namespace KevinBHarris\EbayConnector\Events;

use Webkul\Product\Models\Product;

class ProductSyncedToEbay
{
    public Product $product;
    public bool $success;
    public ?array $response;

    public function __construct(Product $product, bool $success, ?array $response = null)
    {
        $this->product = $product;
        $this->success = $success;
        $this->response = $response;
    }
}
