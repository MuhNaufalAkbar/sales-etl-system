<?php

namespace App\Http\Controllers;

use App\Exports\ValidationErrorExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function downloadMarketing($batch)
    {
        $file = storage_path(
            "app/private/exports/MARKETING_{$batch}.xlsx"
        );

        if (!file_exists($file)) {
            abort(404, 'Marketing file tidak ditemukan');
        }

        return response()->download($file);
    }

    public function downloadFinance($batch)
    {
        $file = storage_path(
            "app/private/exports/FINANCE_{$batch}.xlsx"
        );

        if (!file_exists($file)) {
            abort(404, 'Finance file tidak ditemukan');
        }

        return response()->download($file);
    }

    public function downloadErrorReport($batch)
    {
        return Excel::download(
            new ValidationErrorExport($batch),
            "VALIDATION_ERROR_REPORT_{$batch}.csv"
        );
    }
}