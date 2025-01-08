<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('transactions', function (Blueprint $table) {
        $table->dropColumn(['value']);
        $table->decimal('amount', 15, 2)->after('type'); // Change 'value' to 'amount'
    });
}

public function down()
{
    Schema::table('transactions', function (Blueprint $table) {
        // Reverse the changes (add back the removed columns and drop the new ones)
        $table->dropColumn(['type', 'value']);
        $table->decimal('income', 15, 2)->nullable();
        $table->decimal('outcome', 15, 2)->nullable();
        $table->decimal('amount', 15, 2)->nullable();
    });
}

};
