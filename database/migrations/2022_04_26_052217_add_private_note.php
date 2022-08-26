<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrivateNote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compliance_audits', function (Blueprint $table) {
            $table->string('privateNote')->nullable();
            $table->boolean('isSuspended');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compliance_audits', function (Blueprint $table) {
            $table->dropColumn('privateNote');
            $table->dropColumn('isSuspended');
        });
    }
}
