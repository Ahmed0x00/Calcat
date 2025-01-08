<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            // Change the 'area' column to have a larger range
            $table->decimal('area', 12, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            // Revert the 'area' column back to its previous state
            $table->decimal('area', 10, 2)->change();
        });
    }
};
