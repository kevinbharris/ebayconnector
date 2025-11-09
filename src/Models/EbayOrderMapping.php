<?php

namespace KevinBHarris\EbayConnector\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EbayOrderMapping extends Model
{
    protected $table = 'ebay_order_mappings';

    protected $fillable = [
        'order_id',
        'ebay_order_id',
        'ebay_transaction_id',
        'status',
        'last_synced_at',
        'sync_data',
    ];

    protected $casts = [
        'last_synced_at' => 'datetime',
        'sync_data' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(\Webkul\Sales\Models\Order::class);
    }
}
