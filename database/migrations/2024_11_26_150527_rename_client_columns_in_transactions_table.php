<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameClientColumnsInTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Rename the columns
            $table->renameColumn('client_name', 'name');
            $table->renameColumn('client_phone', 'phone');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Reverse the column renames if rollback is required
            $table->renameColumn('name', 'client_name');
            $table->renameColumn('phone', 'client_phone');
        });
    }
}
