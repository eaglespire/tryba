<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeEmailAndPhoneNumberNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_money', function (Blueprint $table) {
            $table->string("email")->nullable()->change();
            $table->string("phone_number")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_money', function (Blueprint $table) {
            $table->string("email")->change();
            $table->string("phone_number")->change();
        });
    }
}
