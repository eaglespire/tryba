<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDobToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('dob')->after('email')->nullable();
            $table->string('post_town')->after('postal_code')->nullable();
            $table->string('country_code')->after('post_town')->nullable();
            $table->string('company_reg_number')->after('business_name')->nullable();
            $table->string('industry_code')->after('company_reg_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('dob');
            $table->dropColumn('post_town');
            $table->dropColumn('company_reg_number');
            $table->dropColumn('industry_code');
            $table->dropColumn('country_code');
        });
    }
}
