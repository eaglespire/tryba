<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUUIDtoCustomMailer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('custom_mail_drivers', function (Blueprint $table) {
            $table->string('user_id');
            $table->boolean('status')->default(0);
            $table->string('mail_driver')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('custom_mail_drivers', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('user_id');
        });
    }
}
