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
        Schema::create('sales_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelurahan_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('transaction_id');
            $table->string('transactionAddress');
            $table->integer('productPrice');
            $table->integer('productCount');
            $table->string('transactionStatus');
            $table->timestamps();

            $table->foreign('kelurahan_id')->references('id')->on('kelurahans');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->foreign('transaction_id')->references('id')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_transactions');
    }
};
