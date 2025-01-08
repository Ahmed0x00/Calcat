<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('income', 10, 2)->default(0);  // Store income
            $table->decimal('outcome', 10, 2)->default(0); // Store outcome
            $table->string('from');                        // Transaction from
            $table->string('to');                          // Transaction to
            $table->date('transaction_date');              // Date of transaction
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
