<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyActionsColumnInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the 'actions' column if it exists
            $table->dropColumn('actions');
        });

        Schema::table('users', function (Blueprint $table) {
            // Add 'actions' back as a string column
            $table->string('actions', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Rollback: Drop the string 'actions' column
            $table->dropColumn('actions');

            // Optionally, recreate 'actions' as a JSON column if you want to revert the change
            $table->json('actions')->nullable();
        });
    }
}
