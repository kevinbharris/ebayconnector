<?php

namespace KevinBHarris\EbayConnector\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EbayProductMapping extends Model
{
    protected $table = 'ebay_product_mappings';

    protected $fillable = [
        'product_id',
        'ebay_item_id',
        'ebay_listing_id',
        'status',
        'last_synced_at',
        'sync_data',
    ];

    protected $casts = [
        'last_synced_at' => 'datetime',
        'sync_data' => 'array',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(\Webkul\Product\Models\Product::class);
    }
}
