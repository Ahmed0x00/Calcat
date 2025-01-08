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
    Schema::table('resources', function (Blueprint $table) {
        $table->string('name')->after('id'); // Adjust position if needed
    });

    Schema::table('units', function (Blueprint $table) {
        $table->string('site')->nullable()->after('id'); // Adjust position if needed
    });
}

public function down()
{
    Schema::table('resources', function (Blueprint $table) {
        $table->dropColumn('name');
    });

    Schema::table('units', function (Blueprint $table) {
        $table->dropColumn('site');
    });
}

};
