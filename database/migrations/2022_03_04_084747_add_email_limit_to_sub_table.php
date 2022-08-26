<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailLimitToSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub', function (Blueprint $table) {
            $table->integer('email_limit')->default(0);
            $table->integer('sms_limit')->default(0);
            $table->integer('affect_active_subscribers')->default(0);
        });        
        Schema::table('users', function (Blueprint $table) {
            $table->integer('email_limit')->default(0);
            $table->integer('sms_limit')->default(0);
            $table->integer('used_email')->default(0);
            $table->integer('used_sms')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub', function (Blueprint $table) {
            $table->dropColumn('email_limit');
            $table->dropColumn('affect_active_subscribers');
            $table->dropColumn('sms_limit');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email_limit');
            $table->dropColumn('sms_limit');
            $table->dropColumn('used_email');
            $table->dropColumn('used_sms');
        });
    }
}
