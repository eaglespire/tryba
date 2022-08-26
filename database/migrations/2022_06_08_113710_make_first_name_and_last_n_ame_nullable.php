<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeFirstNameAndLastNAmeNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_money', function (Blueprint $table) {
            $table->string("first_name")->nullable()->change();
            $table->string("last_name")->nullable()->change();
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
            $table->string("first_name")->change();
            $table->string("last_name")->change();
        });
    }
}
