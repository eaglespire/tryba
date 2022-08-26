<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStorefrontTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('storefront', function (Blueprint $table) {
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->text('line_1')->nullable();
            $table->string('postal_code')->nullable();
            $table->integer('service_type')->nullable();
            $table->json('working_time')->nullable();
            $table->json('break_time')->nullable();
            $table->json('vacation_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
