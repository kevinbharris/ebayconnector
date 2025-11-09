<?php

namespace KevinBHarris\EbayConnector\Models;

use Illuminate\Database\Eloquent\Model;

class EbaySyncLog extends Model
{
    protected $table = 'ebay_sync_logs';

    protected $fillable = [
        'type',
        'action',
        'entity_id',
        'entity_type',
        'status',
        'message',
        'request_data',
        'response_data',
        'error_details',
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
        'error_details' => 'array',
    ];
}
