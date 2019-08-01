<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConvenientcarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convenientcars', function (Blueprint $table) {
            $table->bigInteger('cars_id')->unsigned();
            $table->bigInteger('convenients_id')->unsigned();
        });

        Schema::table('convenientcars', function ($table) {
            $table->foreign('cars_id')->references('id')->on('cars');
            $table->foreign('convenients_id')->references('id')->on('convenients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropForeign(['cars_id', 'convenients_id']);
        Schema::dropIfExists('convenients');
    }
}
