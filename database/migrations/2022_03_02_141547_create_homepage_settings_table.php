<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomepageSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homepage_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('store_id');
            $table->string('slider_status')->nullable();
            $table->string('slider_limit')->nullable();
            $table->string('blog_status')->nullable();
            $table->string('blog_limit')->nullable();
            $table->string('blog_title')->nullable();
            $table->string('blog_body')->nullable();            
            $table->string('review_status')->nullable();
            $table->string('review_limit')->nullable();
            $table->string('review_title')->nullable();
            $table->string('review_body')->nullable();            
            $table->string('services_status')->nullable();
            $table->string('services_limit')->nullable();
            $table->string('services_title')->nullable();
            $table->string('services_body')->nullable();            
            $table->string('team_status')->nullable();
            $table->string('team_limit')->nullable();
            $table->string('team_title')->nullable();
            $table->string('team_body')->nullable();            
            $table->string('statistics_status')->nullable();
            $table->string('statistics_limit')->nullable();
            $table->string('statistics_title')->nullable();
            $table->string('statistics_body')->nullable();
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
        Schema::dropIfExists('homepage_settings');
    }
}
