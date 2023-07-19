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
        Schema::create('profil_usaha_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profil_usaha_id');
            $table->integer('order');
            $table->string('path');
            $table->timestamps();

            $table->foreign('profil_usaha_id')->references('id')->on('profil_usahas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_usaha_images');
    }
};
