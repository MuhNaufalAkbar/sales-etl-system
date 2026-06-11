<?php

namespace App\Http\Controllers;

use App\Models\ImportBatch;
use App\Models\SalesTransformed;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

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
public function rollback($batch)
{
    DB::beginTransaction();

    try {

        DB::table('sales')
            ->where('batch_id', $batch)
            ->delete();

        DB::table('sales_marketing')
            ->where('batch_id', $batch)
            ->delete();

        DB::table('sales_finance')
            ->where('batch_id', $batch)
            ->delete();

        DB::table('validation_errors')
            ->where('batch_id', $batch)
            ->delete();

        DB::commit();

        return back()->with(
            'success',
            "Batch {$batch} berhasil dirollback."
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