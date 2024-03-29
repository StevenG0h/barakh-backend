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
        Schema::create('spending_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_usaha_id');
            $table->unsignedBigInteger('transaction_id');
            $table->string('SpendingName');
            $table->string('SpendingDescription');
            $table->string('SpendingValue');
            $table->timestamps();

            $table->foreign('unit_usaha_id')->references('id')->on('unit_usahas');
            $table->foreign('transaction_id')->references('id')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spendingtransactions');
    }
};
