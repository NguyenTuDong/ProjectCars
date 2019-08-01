<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ten');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('cover')->nullable();
            $table->string('diachi')->nullable();
            $table->string('sdt');
            $table->string('cmnd')->nullable();
            $table->longText('gioithieu')->nullable();
            $table->string('sodkkd')->nullable();
            $table->string('mst')->nullable();
            $table->bigInteger('locations_id')->unsigned();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('users', function ($table) {
            $table->foreign('locations_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropForeign('locations_id');
        Schema::dropIfExists('users');
    }
}
