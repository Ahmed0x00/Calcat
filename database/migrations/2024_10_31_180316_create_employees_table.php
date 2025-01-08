<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // Name column
            $table->string('leader'); // Leader column
            $table->string('phone'); // Phone column
            $table->string('role'); // Role column
            $table->string('email')->unique(); // Email column
            $table->string('department_name'); // Department Name column
            $table->string('password'); // Password column
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
