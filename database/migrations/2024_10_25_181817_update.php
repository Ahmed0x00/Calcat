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
        // Add company_id (UUID) to existing tables and remove balance from users table
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('company_id')->nullable()->after('id');
            $table->dropColumn('balance');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->uuid('company_id')->nullable()->after('id');
        });

        Schema::table('resources', function (Blueprint $table) {
            $table->uuid('company_id')->nullable()->after('id');
        });

        Schema::table('units', function (Blueprint $table) {
            $table->uuid('company_id')->nullable()->after('id');
        });

        // Create companies table
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid('company_id')->unique(); // This will be used as the company_id
            $table->string('license_key')->unique();
            $table->string('owner_name')->nullable();
            $table->string('email')->nullable();
            $table->decimal('balance', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove company_id from existing tables and restore balance to users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('company_id');
            $table->decimal('balance', 15, 2)->nullable()->after('email');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });

        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });

        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });

        // Drop companies table
        Schema::dropIfExists('companies');
    }
};
