<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales_transformed', function (Blueprint $table) {

            $table->string('store_name')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('expedition')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('sales_transformed', function (Blueprint $table) {

            $table->dropColumn([
                'store_name',
                'transaction_type',
                'expedition'
            ]);

        });
    }
};