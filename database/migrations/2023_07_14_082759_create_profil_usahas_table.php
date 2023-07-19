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
        Schema::create('profil_usahas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_usaha_id');
            $table->text('profil_usaha_desc');
            $table->timestamps();

            $table->foreign('unit_usaha_id')->references('id')->on('unit_usahas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_usahas');
    }
};
