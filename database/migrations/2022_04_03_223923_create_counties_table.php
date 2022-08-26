<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCountiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('country_id');
            $table->timestamps();
        });


        $UkCounty = [
            ["County" => "Bedfordshire"],
            ["County" => "Berkshire"], 
            ["County" => "Bristol"], 
            ["County" => "Buckinghamshire"], 
            ["County" => "Cambridgeshire"], 
            ["County" => "Cheshire"], 
            ["County" => "City of London"], 
            ["County" => "Cornwall"], 
            ["County" => "Cumbria" ], 
            ["County" => "Derbyshire"], 
            ["County" => "Devon"], 
            ["County" => "Dorset"], 
            ["County" => "Durham"], 
            ["County" => "East Riding of Yorkshire"], 
            ["County" => "East Sussex" ], 
            ["County" => "Essex" ], 
            ["County" => "Gloucestershire"], 
            ["County" => "Greater London"], 
            ["County" => "Greater Manchester"], 
            ["County" => "Hampshire"], 
            ["County" => "Herefordshire"], 
            ["County" => "Hertfordshire"], 
            ["County" => "Isle of Wight"], 
            ["County" => "Kent"], 
            ["County" => "Lancashire" ], 
            ["County" => "Leicestershire"], 
            ["County" => "Lincolnshire"], 
            ["County" => "Merseyside"], 
            ["County" => "Norfolk" ], 
            ["County" => "North Yorkshire"], 
            ["County" => "Northamptonshire" ], 
            ["County" => "Northumberland" ], 
            ["County" => "Nottinghamshire"], 
            ["County" => "Oxfordshire"], 
            ["County" => "Rutland"], 
            ["County" => "Shropshire"], 
            ["County" => "Somerset" ], 
            ["County" => "South Yorkshire"], 
            ["County" => "Staffordshire" ], 
            [
            "County" => "Suffolk" 
            ], 
            [
            "County" => "Surrey" 
            ], 
            [
            "County" => "Tyne and Wear" 
            ], 
            [
            "County" => "Warwickshire" 
            ], 
            [
            "County" => "West Midlands" 
            ], 
            [
            "County" => "West Sussex" 
            ], 
            [
            "County" => "West Yorkshire" 
            ], 
            [
            "County" => "Wiltshire" 
            ], 
            [
            "County" => "Worcestershire" 
] 
    ]; 

    foreach ($UkCounty as $key => $county) {
        // Insert some stuff
        DB::table('counties')->insert(
            [
                'name' => $county['County'],
                'country_id' =>232,
                'created_at' => now()->format ('Y-m-d H:i:s'),
                'updated_at' => now()->format ('Y-m-d H:i:s')
            ]
        );
    }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counties');
    }
}
