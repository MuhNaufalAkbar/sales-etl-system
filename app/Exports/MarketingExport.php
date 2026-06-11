<?php

namespace App\Exports;

use App\Models\SalesTransformed;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MarketingExport implements FromCollection, WithHeadings
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

    date('Y', strtotime($row->order_date)),
    date('F', strtotime($row->order_date)),

    $row->order_date,
    $row->order_date,

    $row->order_number,
    $row->awb,

    '', // Memo

    $row->warehouse, // Region

    $row->expedition, // Ekspedisi

    $row->advertiser,

    $row->platform,

    $row->store_name, // Nama Toko

    '', // Admin

    $row->product_name,

    $row->quantity,

    $row->omzet,

    $row->hpp,

    '', // Kode Promo

    $row->omzet,

    $row->payment_method,

    $row->sku,
];
        });
    }

    public function headings(): array
    {
        return [

            'Tahun',
            'Bulan',

            'Tanggal Closing',
            'Tanggal Pesanan',

            'No. Invoice',
            'No. Resi',

            'Memo',

            'Region',

            'Ekspedisi',

            'Advertiser',

            'Platform',

            'Nama Toko',

            'Admin',

            'Produk',

            'Jumlah',

            'Omzet',

            'HPP',

            'Kode Promo',

            'Total Bayar',

            'Metode Pembayaran',

            'SKU',
        ];
    }
}