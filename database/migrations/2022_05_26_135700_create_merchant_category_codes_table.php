<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMerchantCategoryCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_category_codes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('modularLabel');
            $table->string('stripeCodes');
            $table->timestamps();
        });

        $mccs = [
            [ 'name' =>'Accomodation', "modularLabel" => "I" , "stripeCodes" => "7011"],
            [ 'name' =>'Food Services', "modularLabel" => "I" , "stripeCodes" => "5814"],
            [ 'name' =>'Administrative and support services', "modularLabel" => "N" , "stripeCodes" => "7339"],
            [ 'name' =>'Agriculture', "modularLabel" => "A" , "stripeCodes" => "0763"],
            [ 'name' =>'Forestry', "modularLabel" => "A" , "stripeCodes" => "0763"],
            [ 'name' =>'Fishing', "modularLabel" => "A" , "stripeCodes" => "0763"],
            [ 'name' =>'Art & Entertainment', "modularLabel" => "R" , "stripeCodes" => "7333"],
            [ 'name' =>'Recreation', "modularLabel" => "R" , "stripeCodes" => "7999"],
            [ 'name' =>'Construction', "modularLabel" => "F" , "stripeCodes" => "5039"],
            [ 'name' =>'Education', "modularLabel" => "P" , "stripeCodes" => "8299"],
            [ 'name' =>'Electricity, Gas & Steam', "modularLabel" => "D" , "stripeCodes" => "1731"],
            [ 'name' =>'Air conditioning', "modularLabel" => "D" , "stripeCodes" => "7623"],
            [ 'name' =>'Financial Service', "modularLabel" => "K" , "stripeCodes" => "6012"],
            [ 'name' =>'Insurance', "modularLabel" => "K" , "stripeCodes" => "6399"],
            [ 'name' =>'Human health', "modularLabel" => "Q" , "stripeCodes" => "8099"],
            [ 'name' =>'Charitable and Social Service', "modularLabel" => "Q" , "stripeCodes" => "8398"],
            [ 'name' =>'Information and communication', "modularLabel" => "J" , "stripeCodes" => "4814"],
            [ 'name' =>'Manufacturing', "modularLabel" => "C" , "stripeCodes" => ""],//NO stripe code
            [ 'name' =>'Mining and quarrying', "modularLabel" => "B" , "stripeCodes" => ""], //No stripe
            [ 'name' =>'Retail and other services', "modularLabel" => "S" , "stripeCodes" => "5965"],
            [ 'name' =>'Professional, Scientific & Technical services', "modularLabel" => "M" , "stripeCodes" => "8999"],
            [ 'name' =>'Real estate', "modularLabel" => "O" , "stripeCodes" => "6513"],
            [ 'name' =>'Transport Services and Logistics', "modularLabel" => "H" , "stripeCodes" => "4789"],
            [ 'name' =>'Public administration and defence', "modularLabel" => "O" , "stripeCodes" => "9222"],//Government service
            [ 'name' =>'Water supply, sewerage and waste management', "modularLabel" => "E" , "stripeCodes" => ""],//Nocode
            [ 'name' =>'Vehicle Repairs', "modularLabel" => "G" , "stripeCodes" => "5013"],
        ];

        foreach ($mccs as $key => $mcc) {
            // Insert some stuff
            DB::table('merchant_category_codes')->insert(
                [
                    'name' => $mcc['name'],
                    'modularLabel' =>  $mcc['modularLabel'],
                    'stripeCodes' => $mcc['stripeCodes'],
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
        Schema::dropIfExists('merchant_category_codes');
    }
}
