<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['employee_id', 'client_id', 'phone', 'actions']);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable(); // Add back employee_id
            $table->unsignedBigInteger('client_id')->nullable(); // Add back client_id
            $table->string('phone')->nullable(); // Add back phone
            $table->string('actions')->nullable(); // Add back actions
        });
    }
}
