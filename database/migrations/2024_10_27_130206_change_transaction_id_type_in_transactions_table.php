<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTransactionIdTypeInTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Change the type of transaction_id to integer
            $table->integer('transaction_id')->unsigned()->change();
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Revert the change if needed (assuming it was string before)
            $table->string('transaction_id')->change();
        });
    }
}
