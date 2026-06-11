<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{
    protected $fillable = [
        'import_batch_id',
        'file_type',
        'original_name',
        'stored_name',
        'path',
        'total_rows',
    ];

    public function batch()
    {
        return $this->belongsTo(ImportBatch::class, 'import_batch_id');
    }
}