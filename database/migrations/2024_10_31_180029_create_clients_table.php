<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // Name column
            $table->string('phone'); // Phone column
            $table->unsignedInteger('purchases_count')->default(0); // Purchases count column
            $table->unsignedBigInteger('total')->default(0); // Total column (big number)
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
