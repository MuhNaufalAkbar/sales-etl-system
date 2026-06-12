<?php

namespace App\Imports;

use App\Models\RawSale;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SalesDailyImport implements ToCollection
{
    protected int $batchId;

    public function __construct(int $batchId)
    {
        $this->batchId = $batchId;
    }

    public function collection(Collection $rows)
    {
        $rows->shift();

        foreach ($rows as $row) {

    if ($row->filter()->isEmpty()) {
        continue;
    }

    RawSale::create([
        'import_batch_id' => $this->batchId,
        'source_type' => 'sales_daily',

        'order_date' => Date::excelToDateTimeObject($row[1])
                    ->format('Y-m-d'),
        'advertiser' => $row[6] ?? null,
        'order_number' => $row[8] ?? null,
        'awb' => $row[9] ?? null,

        'product_code' => $row[17] ?? null,

        'quantity' => (int) ($row[18] ?? 0),
        'unit_price' => (float) ($row[19] ?? 0),
        'total_price' => (float) ($row[20] ?? 0),

        'payment_method' => $row[4] ?? null,
        'store_name' => $row[5] ?? null,
        'transaction_type' => $row[7] ?? null,
        'expedition' => $row[21] ?? null,

        'warehouse' => $row[22] ?? null,
        'status_order' => $row[23] ?? null,

        'raw_payload' => json_encode($row->toArray()),
    ]);
}
    }
}