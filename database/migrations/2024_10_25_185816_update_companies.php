<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // New migration to add blocked and valid_until columns to companies table
        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('blocked')->default(false)->after('balance');
            $table->date('valid_until')->nullable()->after('blocked');
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
