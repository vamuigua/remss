<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWaterReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('water_readings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('house_id')->nullable();
            $table->string('tenant_names')->nullable();
            $table->string('prev_reading')->nullable();
            $table->integer('current_reading')->nullable();
            $table->integer('units_used')->nullable();
            $table->integer('cost_per_unit')->nullable();
            $table->integer('total_charges')->nullable();
            $table->date('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('water_readings');
    }
}
