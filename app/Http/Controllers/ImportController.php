<?php

namespace App\Http\Controllers;

use App\Jobs\ImportExcelJob;
use App\Models\ImportBatch;
use App\Models\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'files' => 'required|array|size:3',
            'files.*' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {

            $batch = DB::transaction(function () use ($request) {

                $batch = ImportBatch::create([
                    'status' => 'uploaded',
                    'progress' => 0,
                    'total_rows' => 0,
                    'processed_rows' => 0,
                ]);

                $uploadedFiles = $request->file('files');

                $fileTypes = [
                    0 => 'sales_daily',
                    1 => 'sales_mp',
                    2 => 'sales_produk',
                ];

                foreach ($uploadedFiles as $index => $file) {

                    $path = $file->store('imports');

                    UploadedFile::create([
                        'import_batch_id' => $batch->id,
                        'file_type' => $fileTypes[$index],
                        'original_name' => $file->getClientOriginalName(),
                        'stored_name' => basename($path),
                        'path' => $path,
                        'total_rows' => 0,
                    ]);
                }

                return $batch;
            });

            ImportExcelJob::dispatch($batch->id);

            return redirect()
                ->route('dashboard')
                ->with('success', '3 file berhasil diupload dan sedang diproses.')
                ->with('batch_id', $batch->id);

        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}