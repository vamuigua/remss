<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('tenant_id')->nullable();
            $table->string('house_no')->nullable();
            $table->text('features')->nullable();
            $table->string('rent')->nullable();
            $table->string('status')->nullable();
            $table->string('water_meter_no')->nullable();
            $table->string('electricity_meter_no')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('houses');
    }
}
