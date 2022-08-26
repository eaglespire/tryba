<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_configurations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('websiteID');
            $table->boolean('serviceType')->default(0);
            $table->boolean('whereServiceRendered')->default(0);
            $table->bigInteger('county')->nullable();
            $table->string('city')->nullable();
            $table->string('line')->nullable();
            $table->string('postCode')->nullable();
            $table->integer('dailyLimit')->default(20);
            $table->boolean('collectReview')->default(1);
            $table->longText('businessHours')->nullable();
            $table->date('startDateNoBookings')->nullable();
            $table->date('endDateNoBookings')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('booking_configurations');
    }
}
