<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeWorkingHoursBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_configurations', function (Blueprint $table) {
            //DefaultConfigurations
            $defaultHours = [
                'monday' => ['startTime' => 9,'endTime' => 17,'status' => 1],
                'tuesday' => ['startTime' => 9,'endTime' => 17, 'status' => 1],
                'wednesday' => ['startTime' => 9,'endTime' => 17, 'status' => 1],
                'thursday' => ['startTime' => 9,'endTime' => 17, 'status' => 1 ],
                'friday' => ['startTime' => 9,'endTime' => 17, 'status' => 1 ],
                'saturday' => ['startTime' => 9,'endTime' => 17 ,'status' => 1],
                'sunday' => ['startTime' => 11,'endTime' => 17 ,'status' => 1],
            ];

            DB::table('booking_configurations')->update([
                'businessHours' =>  $defaultHours,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_configurations', function (Blueprint $table) {
            //
        });
    }
}
