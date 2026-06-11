<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutputFile extends Model
{
    protected $fillable = [
        'import_batch_id',
        'file_name',
        'path',
    ];
}