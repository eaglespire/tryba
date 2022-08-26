<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('store_team', function (Blueprint $table) {
        //     $table->uuid('id')->primary();
        //     $table->integer('store_id');
        //     $table->string('title');
        //     $table->string('occupation')->nullable();
        //     $table->string('image');
        //     $table->integer('status')->default(1);
        //     $table->text('whatsapp')->nullable();
        //     $table->text('facebook')->nullable();
        //     $table->text('linkedin')->nullable();
        //     $table->text('instagram')->nullable();
        //     $table->text('twitter')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_team');
    }
}
