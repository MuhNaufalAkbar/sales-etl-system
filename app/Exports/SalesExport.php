<?php

namespace App\Exports;

use App\Models\SalesTransformed;
use Maatwebsite\Excel\Concerns\FromCollection;

class SalesExport implements FromCollection
{
    protected int $batchId;

    public function __construct($batchId)
    {
        $this->batchId = $batchId;
    }

    public function collection()
    {
        return SalesTransformed::where(
            'import_batch_id',
            $this->batchId
        )->get();
    }
}