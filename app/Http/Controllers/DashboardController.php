<?php

namespace App\Http\Controllers;

use App\Models\ImportBatch;
use App\Models\SalesTransformed;
use App\Models\RawSale;
use App\Models\ValidationError;
use App\Models\OutputFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Jobs\NotificationJob;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [

            'totalOmzet' =>
                SalesTransformed::sum('omzet'),

            'totalProfit' =>
                SalesTransformed::sum('profit'),

            'totalOrders' =>
                SalesTransformed::count(),

            'totalQty' =>
                SalesTransformed::sum('quantity'),

            'batches' => ImportBatch::orderBy('id', 'asc')->get()

        ]);
    }
    public function progress($id)
{
    $batch = ImportBatch::findOrFail($id);

    return response()->json([
        'progress' => $batch->progress,
        'status' => $batch->status
    ]);
}
public function rollback($batchId)
{
    DB::beginTransaction();

    try {
        $batch = ImportBatch::findOrFail($batchId);

        
        RawSale::where('import_batch_id', $batchId)->delete();
        SalesTransformed::where('import_batch_id', $batchId)->delete();

        
        ValidationError::where('import_batch_id', $batchId)->delete();

        
        foreach ($batch->files as $file) {
            Storage::delete($file->path);
            Storage::delete('private/'.$file->path);
            $file->delete();
        }

        // remove output file records and delete files
        foreach (OutputFile::where('import_batch_id', $batchId)->get() as $of) {
            Storage::delete($of->path);
            Storage::delete('private/'.$of->path);
            $of->delete();
        }

        
        Storage::delete('exports/MARKETING_'.$batchId.'.xlsx');
        Storage::delete('private/exports/MARKETING_'.$batchId.'.xlsx');
        Storage::delete('exports/FINANCE_'.$batchId.'.xlsx');
        Storage::delete('private/exports/FINANCE_'.$batchId.'.xlsx');

        
        $batch->delete();

        DB::commit();

        
        NotificationJob::dispatch($batchId);

        return back()->with(
            'success',
            "Batch {$batchId} berhasil dirollback."
        );

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with(
            'error',
            $e->getMessage()
        );
    }
}
}