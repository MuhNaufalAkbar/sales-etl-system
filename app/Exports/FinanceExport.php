<?php

namespace App\Exports;

use App\Models\SalesTransformed;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FinanceExport implements FromCollection, WithHeadings
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
        )
        ->get()
        ->map(function ($row) {

            return [

    $row->order_date,
    $row->order_date,

    $row->order_number,
    $row->awb,

    $row->expedition, // Ekspedisi

    $row->transaction_type, // Type Transaksi

    $row->advertiser,
    $row->platform,

    $row->store_name, // Nama Toko

    '', // Admin

    $row->product_name,
    $row->quantity,

    $row->omzet,
    $row->hpp,

    0,

    $row->omzet,

    $row->payment_method,
];
        });
    }

    public function headings(): array
    {
        return [

            'Tanggal Closing',
            'Tanggal Pesanan',
            'No Invoice',
            'No Resi',

            'Ekspedisi',
            'Type Transaksi',

            'Advertiser',
            'Platform',

            'Nama Toko',
            'Admin',

            'Produk Name',
            'Jumlah',

            'Omzet',
            'HPP Sigma',

            'TaxName(%)',

            'Total Bayar',

            'Payment Type',
        ];
    }
}