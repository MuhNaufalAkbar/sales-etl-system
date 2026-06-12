<?php

namespace App\Imports;

use App\Models\RawSale;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Log;

class SalesDailyImport implements ToCollection
{
    protected int $batchId;

    public function __construct(int $batchId)
    {
        $this->batchId = $batchId;
    }

    public function collection(Collection $rows)
    {
        // Skip header
        $rows->shift();

        foreach ($rows as $index => $row) {

            // Skip row kosong
            if ($row->filter()->isEmpty()) {
                continue;
            }

            try {

                /**
                 * Handle tanggal Excel maupun String
                 */
                $dateValue = $row[1] ?? null;

                if (empty($dateValue)) {
                    $orderDate = null;
                } elseif (is_numeric($dateValue)) {
                    $orderDate = Date::excelToDateTimeObject($dateValue)
                        ->format('Y-m-d');
                } else {
                    $orderDate = Carbon::parse($dateValue)
                        ->format('Y-m-d');
                }

                RawSale::create([
                    'import_batch_id' => $this->batchId,
                    'source_type'     => 'sales_daily',

                    'order_date'      => $orderDate,
                    'advertiser'      => $row[6] ?? null,
                    'order_number'    => $row[8] ?? null,
                    'awb'             => $row[9] ?? null,

                    'product_code'    => $row[17] ?? null,

                    'quantity'        => (int) ($row[18] ?? 0),
                    'unit_price'      => (float) ($row[19] ?? 0),
                    'total_price'     => (float) ($row[20] ?? 0),

                    'payment_method'  => $row[4] ?? null,
                    'store_name'      => $row[5] ?? null,
                    'transaction_type'=> $row[7] ?? null,
                    'expedition'      => $row[21] ?? null,

                    'warehouse'       => $row[22] ?? null,
                    'status_order'    => $row[23] ?? null,

                    'raw_payload'     => json_encode(
                        $row->toArray(),
                        JSON_UNESCAPED_UNICODE
                    ),
                ]);

            } catch (\Throwable $e) {

                Log::error('SalesDaily Import Error', [
                    'batch_id'   => $this->batchId,
                    'row_number' => $index + 2,
                    'row_data'   => $row->toArray(),
                    'message'    => $e->getMessage(),
                ]);

                throw $e;
            }
        }
    }
}