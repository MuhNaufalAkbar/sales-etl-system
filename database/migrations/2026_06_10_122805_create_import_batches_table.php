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
        Schema::create('import_batches', function (Blueprint $table) {
    $table->id();

    $table->enum('status', [
        'uploaded',
        'validating',
        'processing',
        'transforming',
        'generating',
        'completed',
        'failed'
    ])->default('uploaded');

    $table->unsignedTinyInteger('progress')
          ->default(0);

    $table->integer('total_rows')
          ->default(0);

    $table->integer('processed_rows')
          ->default(0);

    $table->text('error_message')
          ->nullable();

    $table->timestamp('started_at')
          ->nullable();

    $table->timestamp('finished_at')
          ->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_batches');
    }
};
