<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdduserIDtoBlockedAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocked_accounts', function (Blueprint $table) {
            $table->string('user_id');
            $table->dropColumn('reason');
            $table->string('reason')->nullable()->change();
            $table->string('private_note')->nullable()->change();
            $table->string('isMoneyinAccount')->nullable()->change();
            $table->string('account_number')->nullable()->change();
            $table->string('sort_code')->nullable()->change();
            $table->string('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocked_accounts', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('slug');
            $table->string('reason');
        });
    }
}
