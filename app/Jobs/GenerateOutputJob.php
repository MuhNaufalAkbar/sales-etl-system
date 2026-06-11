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
    Excel::store(
        new MarketingExport($this->batchId),
        'exports/MARKETING_'.$this->batchId.'.xlsx'
    );

    Excel::store(
        new FinanceExport($this->batchId),
        'exports/FINANCE_'.$this->batchId.'.xlsx'
    );
}
}