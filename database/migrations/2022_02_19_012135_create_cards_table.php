<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('c_id')->nullable();
            $table->string('account_id');
            $table->string('type');
            $table->string('task_id')->nullable();
            $table->string('task_url')->nullable();
            $table->string('pan')->nullable();
            $table->string('expiry')->nullable();
            $table->string('mtg_token')->nullable();
            $table->string('reference')->nullable();
            $table->enum('c_status', ['ACTIVE', 'SUSPENDED', 'BLOCKED', 'DEACTIVATED', 'SUBMITTED'])->default(NULL); 
            $table->boolean('status')->default(true)->nullable();           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
