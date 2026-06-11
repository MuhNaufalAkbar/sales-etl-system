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
        Schema::create('sales_transformed', function (Blueprint $table) {

    $table->id();

    $table->foreignId('import_batch_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->date('order_date')->nullable();

    $table->string('order_number');

    $table->string('awb')->nullable();

    $table->string('platform')->nullable();

    $table->string('advertiser')->nullable();

    $table->string('sku');

    $table->string('product_name');

    $table->integer('quantity');

    $table->decimal('omzet', 15, 2);

    $table->decimal('hpp', 15, 2);

    $table->decimal('profit', 15, 2);

    $table->timestamps();

    $table->string('store_name')->nullable();
$table->string('transaction_type')->nullable();
$table->string('expedition')->nullable();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_transformed');
    }
};