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
        Schema::table('sales_transactions',function(Blueprint $table){
            $table->unsignedBigInteger('provinsi_id')->nullable()->default(null);
            $table->unsignedBigInteger('kota_id')->nullable()->default(null);
            $table->unsignedBigInteger('kecamatan_id')->nullable()->default(null);

            $table->foreign('provinsi_id')->references('id')->on('provinsis');
            $table->foreign('kota_id')->references('id')->on('kotas');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
