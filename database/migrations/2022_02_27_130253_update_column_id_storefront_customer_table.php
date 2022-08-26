<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnIdStorefrontCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('storefront_customer', function (Blueprint $table) {
            $table->uuid('id')->change();
        });        
        Schema::table('orders', function (Blueprint $table) {
            $table->uuid('customer_id')->change();
            $table->uuid('store_id')->change();
            $table->uuid('ship_id')->change();
            $table->uuid('seller_id')->change();
        });        
        Schema::table('customer_address', function (Blueprint $table) {
            $table->uuid('shipping_id')->change();
        });        
        Schema::table('cart', function (Blueprint $table) {
            $table->id('id')->change();
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
