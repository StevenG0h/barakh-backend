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
        // Schema::table('admins',function(Blueprint $table){
            
        //     $table->unsignedBigInteger('unit_usaha_id')->default(1);
            
        //     $table->foreign('unit_usaha_id')->references('id')->on('unit_usahas');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
