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
        Schema::create('income_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usaha_id');
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('transaction_id');
            $table->integer('transactionAmount');
            $table->string('transactionTitle');
            $table->string('transactionNote');
            $table->timestamps();

            $table->foreign('usaha_id')->references('id')->on('unit_usahas');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->foreign('transaction_id')->references('id')->on('transactions');
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
