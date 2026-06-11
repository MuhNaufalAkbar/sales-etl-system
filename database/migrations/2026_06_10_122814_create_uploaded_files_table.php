<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('uploaded_files', function (Blueprint $table) {
    $table->id();

    $table->foreignId('import_batch_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->enum('file_type', [
        'sales_daily',
        'sales_mp',
        'sales_produk'
    ]);

    $table->enum('status', [
    'uploaded',
    'imported',
    'validated',
    'failed'
    ])->default('uploaded');

    $table->string('original_name');

    $table->string('stored_name');

    $table->string('path');

    $table->integer('total_rows')
          ->default(0);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploaded_files');
    }
};
