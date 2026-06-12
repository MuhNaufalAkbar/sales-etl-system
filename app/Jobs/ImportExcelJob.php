<?php

namespace App\Jobs;

use App\Models\ImportBatch;
use App\Models\UploadedFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Imports\SalesDailyImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\TransformSalesJob;

class ImportExcelJob implements ShouldQueue
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
            'status' => 'processing',
            'started_at' => now(),
            'progress' => 10,
        ]);

        $files = UploadedFile::where(
            'import_batch_id',
            $batch->id
        )->get();

            foreach ($files as $file) {

                // determine storage path: try standard and private locations
                $candidates = [
                    storage_path('app/' . $file->path),
                    storage_path('app/private/' . $file->path),
                ];

                $fullPath = null;

                foreach ($candidates as $p) {
                    if (file_exists($p)) {
                        $fullPath = $p;
                        break;
                    }
                }

                if (!$fullPath) {
                    // mark file as failed and continue
                    $file->update(['status' => 'failed']);
                    $batch->update(['status' => 'failed', 'error_message' => 'File not found: ' . $file->path]);
                    continue;
                }

                if ($file->file_type === 'sales_daily') {

                    Excel::import(
                        new SalesDailyImport($batch->id),
                        $fullPath
                    );

                    $file->update([
                        'status' => 'imported'
                    ]);
                }
            }

        $batch->update([
            'progress' => 40,
        ]);

        TransformSalesJob::dispatch(
            $batch->id
        );
    }
}