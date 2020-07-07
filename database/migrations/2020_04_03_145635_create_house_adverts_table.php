<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHouseAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_adverts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('house')->nullable();
            $table->string('location')->nullable();
            $table->text('images')->nullable();
            $table->text('details')->nullable();
            $table->text('description')->nullable();
            $table->string('rent')->nullable();
            $table->string('booking_status')->nullable();
            $table->string('file')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('house_adverts');
    }
}
