<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('surname');
            $table->string('other_names');
            $table->string('gender');
            $table->string('national_id')->unique();
            $table->string('phone_no');
            $table->string('email')->unique();
            $table->string('image')->nullable();;
            $table->integer('user_id')->unsigned()->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admins');
    }
}
