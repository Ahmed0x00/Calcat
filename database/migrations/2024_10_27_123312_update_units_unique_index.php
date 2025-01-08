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
        // Drop the existing unique constraint if it exists
        $table->dropUnique('units_code_unique'); // Adjust the name if needed

    });
}

public function down()
{
    Schema::table('units', function (Blueprint $table) {
        // Restore the old unique constraint if needed
        $table->unique('code');
    });
}

};
