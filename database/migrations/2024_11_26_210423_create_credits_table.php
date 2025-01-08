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
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->uuid('company_id');
            $table->decimal('amount', 15, 2);
            $table->string('details')->nullable();
            $table->string('type')->nullable();
            $table->string('contractor_name')->nullable();
            $table->string('contractor_phone')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }
    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};
