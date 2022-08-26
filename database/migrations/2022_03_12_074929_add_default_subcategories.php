<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddDefaultSubcategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expense_subcategories', function (Blueprint $table) {
            $results = DB::table('expense_categories')->whereuuid(0)->where("name","Charity")->first();
            DB::table('expense_subcategories')->insert(
                [
                    'uuid' => 0,
                    'categoryID' => $results->id,
                    'name' => "GigPot",
                    'description' => "GigPot",
                ]
            );
            $results = DB::table('expense_categories')->whereuuid(0)->where("name","Sales")->first();
            DB::table('expense_subcategories')->insert(
                [
                    'uuid' => 0,
                    'categoryID' => $results->id,
                    'name' => "E-commerce/Bookings",
                    'description' => "Sales of product or services",
                ]
            );
            $results = DB::table('expense_categories')->whereuuid(0)->where("name","Payment")->first();
            DB::table('expense_subcategories')->insert(
                [
                    'uuid' => 0,
                    'categoryID' => $results->id,
                    'name' => "Invoice/Links",
                    'description' => "Payment or invoicing",
                ]
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expense_subcategories', function (Blueprint $table) {
            //
        });
    }
}
