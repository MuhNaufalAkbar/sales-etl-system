<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\RawSale;
use App\Models\ImportBatch;
use App\Models\ValidationError;
use App\Models\SalesTransformed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Jobs\GenerateOutputJob;

class TransformSalesJob implements ShouldQueue
{
    use Queueable;

    public int $batchId;

    public function __construct(int $batchId)
    {
        $this->batchId = $batchId;
    }

    public function handle(): void
    {
        $batch = ImportBatch::findOrFail($this->batchId);

        $batch->update([
            'status' => 'transforming',
            'progress' => 50,
        ]);

        $rows = RawSale::where(
            'import_batch_id',
            $batch->id
        )->get();

        $totalRows = $rows->count();
        $processedRows = 0;

        SalesTransformed::where(
            'import_batch_id',
            $batch->id
        )->delete();

        foreach ($rows as $row) {

            $product = Product::where(
                'sku',
                trim($row->product_code)
            )->first();

            if (!$product) {

                ValidationError::create([
                    'import_batch_id' => $batch->id,
                    'error_type' => 'SKU_NOT_FOUND',
                    'error_message' => 'SKU tidak ditemukan: '.$row->product_code,
                    'raw_data' => json_encode($row),
                ]);

                continue;
            }

            $hpp = $product->hpp;

            $profit =
                $row->total_price -
                ($hpp * $row->quantity);

            SalesTransformed::create([
                'import_batch_id' => $batch->id,

                'order_date' => $row->order_date,
                'order_number' => $row->order_number,
                'awb' => $row->awb,

                'platform' => $row->source_type,
                'advertiser' => $row->advertiser,

                'sku' => $product->sku,
                'product_name' => $product->product_name,

                'quantity' => $row->quantity,

                'omzet' => $row->total_price,
                'hpp' => $hpp,
                'profit' => $profit,

                'payment_method' => $row->payment_method,

                'store_name' => $row->store_name,
                'transaction_type' => $row->transaction_type,
                'expedition' => $row->expedition,

                'warehouse' => $row->warehouse,
                'status_order' => $row->status_order,
                'store_name' => $row->store_name,
                'transaction_type' => $row->transaction_type,
                'expedition' => $row->expedition,
                'store_name' => $row->store_name,
                'transaction_type' => $row->transaction_type,
                'expedition' => $row->expedition,
            ]);

            $processedRows++;
        }

        $batch->update([
            'status' => 'completed',
            'progress' => 100,
            'total_rows' => $totalRows,
            'processed_rows' => $processedRows,
            'finished_at' => now(),
        ]);

        GenerateOutputJob::dispatch(
            $this->batchId
        );
    }
}