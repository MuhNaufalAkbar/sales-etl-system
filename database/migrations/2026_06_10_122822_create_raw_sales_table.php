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
        Schema::create('raw_sales', function (Blueprint $table) {

    $table->id();

    $table->foreignId('import_batch_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->string('source_type');

    $table->date('order_date')
          ->nullable();

    $table->string('order_number')
          ->nullable();

    $table->string('awb')
          ->nullable();

    $table->string('advertiser')
          ->nullable();

    $table->string('product_code')
          ->nullable();

    $table->integer('quantity')
          ->default(0);

    $table->decimal('unit_price', 15, 2)
          ->default(0);

    $table->decimal('total_price', 15, 2)
          ->default(0);

    $table->string('payment_method')
          ->nullable();

    $table->string('warehouse')
          ->nullable();

    $table->string('status_order')
          ->nullable();

    $table->json('raw_payload')
          ->nullable();

    $table->timestamps();

    $table->index('order_number');
    $table->index('product_code');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_sales');
    }
};
