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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('clientName');
            $table->unsignedBigInteger('clientProvinsi');
            $table->unsignedBigInteger('clientKota');
            $table->unsignedBigInteger('clientKecamatan');
            $table->unsignedBigInteger('clientKelurahan');
            $table->unsignedBigInteger('clientAddress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};