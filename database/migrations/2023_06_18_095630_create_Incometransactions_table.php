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
        Schema::create('incomeTransactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transactionDistrict');
            $table->unsignedBigInteger('productId');
            $table->unsignedBigInteger('clientId');
            $table->unsignedBigInteger('adminId');
            $table->unsignedBigInteger('transactionId');
            $table->string('transactionAddress');
            $table->integer('transactionAmount');
            $table->string('transactionStatus');

            $table->foreign('transactionDistrict')->references('id')->on('kelurahans');
            $table->foreign('productId')->references('id')->on('products');
            $table->foreign('clientId')->references('id')->on('clients');
            $table->foreign('adminId')->references('id')->on('admins');
            $table->foreign('transactionId')->references('id')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
