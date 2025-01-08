<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTransactionsTable extends Migration
{
    public function up()
    {
        // Drop the existing transactions table if it exists
        Schema::dropIfExists('transactions');

        // Create a new transactions table with the required columns
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->decimal('amount', 10, 2); // Amount column
            $table->string('type_of_trans'); // Type of transaction
            $table->string('type'); // Type (income/expense)
            $table->string('details')->nullable(); // Details column
            $table->string('client_name'); // Client name column
            $table->string('client_phone'); // Client phone column
            $table->date('date'); // Date column
            $table->uuid('company_id'); 
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions'); // Drop the table on rollback
    }
}
