<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportBatch extends Model
{
    protected $fillable = [
        'status',
        'progress',
        'total_rows',
        'processed_rows',
        'error_message',
        'started_at',
        'finished_at',
    ];

    public function files()
    {
        return $this->hasMany(UploadedFile::class);
    }
}