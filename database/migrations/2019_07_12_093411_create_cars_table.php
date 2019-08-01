<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ten');
            $table->integer('gia');
            $table->bigInteger('types_id')->unsigned();
            $table->bigInteger('colors_id')->unsigned();
            $table->bigInteger('conditions_id')->unsigned();
            $table->bigInteger('origins_id')->unsigned();
            $table->bigInteger('transmissions_id')->unsigned();
            $table->bigInteger('fuels_id')->unsigned();
            $table->bigInteger('locations_id')->unsigned();
            $table->bigInteger('furnitures_id')->unsigned();
            $table->bigInteger('styles_id')->unsigned();
            $table->bigInteger('users_id')->unsigned();
            $table->integer('namsx')->nullable();
            $table->integer('doixe')->nullable();
            $table->integer('socua')->nullable();
            $table->integer('sochongoi')->nullable();
            $table->string('kichthuoc')->nullable();
            $table->integer('cannang')->nullable();
            $table->integer('dungtich')->nullable();
            $table->string('phanh')->nullable();
            $table->string('giamxoc')->nullable();
            $table->string('lopxe')->nullable();
            $table->longText('mota')->nullable();
            $table->integer('trangthai')->default(0);
            $table->string('hinhanh')->nullable();
            $table->timestamps();
        });

        Schema::table('cars', function ($table) {
            $table->foreign('types_id')->references('id')->on('types');
            $table->foreign('colors_id')->references('id')->on('colors');
            $table->foreign('furnitures_id')->references('id')->on('colors');
            $table->foreign('conditions_id')->references('id')->on('conditions');
            $table->foreign('origins_id')->references('id')->on('origins');
            $table->foreign('transmissions_id')->references('id')->on('transmissions');
            $table->foreign('fuels_id')->references('id')->on('fuels');
            $table->foreign('styles_id')->references('id')->on('styles');
            $table->foreign('locations_id')->references('id')->on('locations');
            $table->foreign('users_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropForeign(['types_id', 'colors_id', 'furnitures_id', 'conditions_id', 'origins_id', 'transmissions_id', 'fuels_id', 'styles_id', 'locations_id', 'users_id']);
        Schema::dropIfExists('cars');
    }
}
