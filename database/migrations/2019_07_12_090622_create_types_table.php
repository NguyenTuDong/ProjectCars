<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('brands_id')->unsigned();
            $table->string('ten');
            $table->integer('trangthai')->default(0);
        });

        Schema::table('types', function($table){
            $table->foreign('brands_id')->references('id')->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropForeign(['brands_id']);
        Schema::dropIfExists('types');
    }
}
