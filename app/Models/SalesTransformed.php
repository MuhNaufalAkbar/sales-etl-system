<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesTransformed extends Model
{
    protected $table = 'sales_transformed';

    protected $fillable = [
        'import_batch_id',
        'order_date',
        'order_number',
        'awb',
        'platform',
        'advertiser',
        'sku',
        'product_name',
        'quantity',
        'omzet',
        'hpp',
        'profit',

        'payment_method',
        'warehouse',
        'status_order',
        'store_name',
        'transaction_type',
        'expedition',
    ];
}