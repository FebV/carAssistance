<?php

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
        Schema::create('cars', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('brand');
            $table->string('model');
            $table->string('car_no');
            $table->string('arch_no');
            $table->string('motor_no');
            $table->integer('distance');
            $table->integer('left_oil');
            $table->string('motor_status');
            $table->string('trans_status');
            $table->string('light_status');
            $table->integer('current_notification')->default(0);
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
        Schema::drop('cars');
    }
}
