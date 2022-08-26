<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplianceAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compliance_audits', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('url')->unique();
            $table->string('subject');
            $table->longText('reason');
            $table->string('response')->nullable();
            $table->string('file_url')->nullable();
            $table->boolean('responded')->default(false);
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
        Schema::dropIfExists('compliance_audits');
    }
}
