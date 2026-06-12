<?php

namespace App\Jobs;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Exports\MarketingExport;
use App\Exports\FinanceExport;

class GenerateOutputJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $batchId
    ) {}

    public function handle(): void
    {
        // store exports under private/exports to match ExportController expectations
        Excel::store(
            new MarketingExport($this->batchId),
            'private/exports/MARKETING_'.$this->batchId.'.xlsx'
        );

        Excel::store(
            new FinanceExport($this->batchId),
            'private/exports/FINANCE_'.$this->batchId.'.xlsx'
        );

        // optionally record OutputFile entries
        try {
            \App\Models\OutputFile::create([
                'import_batch_id' => $this->batchId,
                'file_name' => 'MARKETING_'.$this->batchId.'.xlsx',
                'path' => 'private/exports/MARKETING_'.$this->batchId.'.xlsx',
            ]);

            \App\Models\OutputFile::create([
                'import_batch_id' => $this->batchId,
                'file_name' => 'FINANCE_'.$this->batchId.'.xlsx',
                'path' => 'private/exports/FINANCE_'.$this->batchId.'.xlsx',
            ]);
        } catch (\Throwable $e) {
            // do not fail the job if recording output metadata fails
        }
    }
}