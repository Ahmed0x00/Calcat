<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
{
    DB::statement('ALTER TABLE users ADD COLUMN actions JSON NULL');
}

public function down()
{
    DB::statement('ALTER TABLE users DROP COLUMN actions');
}


};
