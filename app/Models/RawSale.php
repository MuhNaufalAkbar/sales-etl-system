<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawSale extends Model
{
    protected $fillable = [

    'import_batch_id',
    'source_type',

    'order_date',
    'advertiser',
    'order_number',
    'awb',

    'product_code',

    'quantity',
    'unit_price',
    'total_price',

    'payment_method',

    'store_name',
    'transaction_type',
    'expedition',

    'warehouse',
    'status_order',

    'raw_payload',
];
}