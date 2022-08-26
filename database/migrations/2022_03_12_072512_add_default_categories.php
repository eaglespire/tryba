<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddDefaultCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expense_categories', function (Blueprint $table) {
             // Insert some stuff
            DB::table('expense_categories')->insert(
                [
                    'uuid' => 0,
                    'name' => "Charity",
                    'description' => "GigPot",
                ]
            );
            DB::table('expense_categories')->insert(
                [
                    'uuid' => 0,
                    'name' => "Sales",
                    'description' => "Ecommerce",
                ]
            );
            DB::table('expense_categories')->insert(
                [
                    'uuid' => 0,
                    'name' => "Payment",
                    'description' => "Invoice and Payment links",
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
        Schema::table('expense_categories', function (Blueprint $table) {
            //
        });
    }
}
