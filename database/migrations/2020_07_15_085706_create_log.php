<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log', function (Blueprint $table) {
            $table->id();
            $table->double('temp');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('device_id')->index();
            $table->foreign('user_id')->references('id')->on('employees');
            $table->foreign('device_id')->references('id')->on('device');
            $table->text('address');
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
        Schema::dropIfExists('log');
    }
}
