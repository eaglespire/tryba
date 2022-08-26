<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('store_id');
            $table->uuid('user_id');
            $table->uuid('customer_id');
            $table->uuid('service_id');
            $table->uuid('address_id')->nullable();
            $table->string('payment_method');
            $table->date('d_date');
            $table->time('d_time');
            $table->string('duration');
            $table->string('coupon')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('amount');
            $table->string('total');
            $table->string('ref_id');
            $table->string('line_1')->nullable();
            $table->string('line_2')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('tax')->nullable();
            $table->string('currency');
            $table->integer('status')->default(0);
            $table->timestamps();
        });
        Schema::table('booking_services', function (Blueprint $table) {
            $table->uuid('store_id')->change();
        });   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
