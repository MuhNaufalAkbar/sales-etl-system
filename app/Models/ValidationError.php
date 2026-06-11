<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidationError extends Model
{
    protected $fillable = [
        'import_batch_id',
        'row_number',
        'error_type',
        'error_message',
        'raw_data',
    ];
}