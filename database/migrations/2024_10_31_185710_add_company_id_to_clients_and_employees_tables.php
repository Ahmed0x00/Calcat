<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyIdToClientsAndEmployeesTables extends Migration
{
    public function up()
    {
        // Add company_id to clients table
        Schema::table('clients', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->after('client_id'); // Add company_id column
        });

        // Add company_id to employees table
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->after('employee_id'); // Add company_id column
        });
    }

    public function down()
    {
        // Remove company_id from clients table on rollback
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });

        // Remove company_id from employees table on rollback
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
    }
}
