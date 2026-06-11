<?php

namespace App\Exports;

use App\Models\SalesTransformed;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesTransformedExport implements FromCollection, WithHeadings
{
    protected int $batchId;

    public function __construct(int $batchId)
    {
        $this->batchId = $batchId;
    }

    public function collection()
    {
        return SalesTransformed::where(
            'import_batch_id',
            $this->batchId
        )->get([
            'order_number',
            'awb',
            'advertiser',
            'sku',
            'product_name',
            'quantity',
            'omzet',
            'hpp',
            'profit',
            'store_name',
            'transaction_type',
            'expedition',
        ]);
    }

    public function headings(): array
    {
        return [
            'Order Number',
            'AWB',
            'Advertiser',
            'SKU',
            'Product Name',
            'Qty',
            'Omzet',
            'HPP',
            'Profit',
            'Store Name',
    'Transaction Type',
    'Expedition',
            
        ];
    }
}