<?php

namespace App\Exports;

use App\Models\ValidationError;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ValidationErrorExport implements FromCollection, WithHeadings
{
    protected $batchId;

    public function __construct($batchId)
    {
        $this->batchId = $batchId;
    }

    public function collection()
    {
        return ValidationError::where(
            'import_batch_id',
            $this->batchId
        )
        ->get([
            'error_type',
            'error_message',
            'raw_data',
            'created_at'
        ]);
    }

    public function headings(): array
    {
        return [
            'Error Type',
            'Error Message',
            'Raw Data',
            'Created At'
        ];
    }
}