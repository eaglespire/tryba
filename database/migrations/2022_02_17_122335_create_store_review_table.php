<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('store_review', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('store_id');
        //     $table->string('title');
        //     $table->string('occupation')->nullable();
        //     $table->text('review');
        //     $table->string('image');
        //     $table->integer('status')->default(1);
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
        Schema::dropIfExists('store_review');
    }
}
