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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transactionProvince');
            $table->unsignedBigInteger('transactionCity');
            $table->unsignedBigInteger('transactionDistrict');
            $table->string('transactionAddress');
            $table->unsignedBigInteger('productId');
            $table->unsignedBigInteger('clientId');
            $table->unsignedBigInteger('adminId');
            $table->string('transactionStatus');
            $table->timestamps();
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
