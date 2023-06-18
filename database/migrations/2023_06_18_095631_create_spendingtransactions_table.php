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
        Schema::create('spendingtransactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usahaId');
            $table->unsignedBigInteger('transactionId');
            $table->string('SpendingName');
            $table->string('SpendingDescription');
            $table->string('SpendingValue');

            $table->foreign('usahaId')->references('id')->on('unit_usahas');
            $table->foreign('transactionId')->references('id')->on('transactions');
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
