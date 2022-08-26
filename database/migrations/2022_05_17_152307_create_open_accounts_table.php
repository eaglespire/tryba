<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpenAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('open_accounts', function (Blueprint $table) {
            $table->id();
            $table->boolean('newbusiness')->default(false)->nullable();
            $table->boolean('existingbusiness')->default(false)->nullable();
            $table->boolean('offer_service')->default(false)->nullable();
            $table->boolean('sell_online')->default(false)->nullable();
            $table->tinyText('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->mediumText('describe')->nullable();
            $table->boolean('website')->default(false)->nullable();
            $table->decimal('turnover')->nullable();
            $table->tinyText('business_type')->nullable();
            $table->tinyText('business_name')->nullable();
            $table->tinyText('company_registration_number')->nullable();
            $table->tinyText('business_category')->nullable();
            $table->tinyText('postal_or_zipcode')->nullable();
            $table->tinyText('state')->nullable();
            $table->tinyText('address_one')->nullable();
            $table->tinyText('address_two')->nullable();
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
        Schema::dropIfExists('open_accounts');
    }
}
