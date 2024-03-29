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
            $table->enum('transactionType',['PENGELUARAN','PEMASUKANLAIN','PENJUALAN']);
            $table->enum('transactionStatus',['TERVERIFIKASI','BELUMTERVERIFIKASI','DITUNDA','PENGIRIMAN','SELESAI'])->default('BELUMTERVERIFIKASI');
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
