<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddDefaultPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            // Insert some stuff
            DB::table('subscription_plans')->insert(
                [
                    'name' => "Basic Plan",
                    'amount' => 5,
                    'duration' => 1,
                    'durationType' => 'month',
                    'annualstartPrice' => 0,
                    'annualendPrice' => 2500,
                    'created_at' => now()->format ('Y-m-d'),
                    'updated_at' => now()->format ('Y-m-d')
                ]
            );

            DB::table('subscription_plans')->insert(
                [
                    'name' => "Professional Plan",
                    'amount' => 9.99,
                    'duration' => 1,
                    'durationType' => 'month',
                    'annualstartPrice' => 2500,
                    'annualendPrice' => 12850,
                    'created_at' => now()->format ('Y-m-d'),
                    'updated_at' => now()->format ('Y-m-d')
                ]
            );

            DB::table('subscription_plans')->insert(
                [
                    'name' => "Unlimited Plan",
                    'amount' => 50,
                    'duration' => 1,
                    'durationType' => 'month',
                    'annualstartPrice' => null,
                    'annualendPrice' => null,
                    'created_at' => now()->format ('Y-m-d'),
                    'updated_at' => now()->format ('Y-m-d')
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
        Schema::table('subscription_plans', function (Blueprint $table) {
            //
        });
    }
}
