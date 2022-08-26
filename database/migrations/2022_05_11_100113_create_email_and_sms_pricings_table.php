<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailAndSmsPricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_and_sms_pricings', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity_email');
            $table->integer('quantity_sms');
            $table->integer('amount_email');
            $table->integer('amount_sms');
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
        Schema::dropIfExists('email_and_sms_pricings');
    }
}
