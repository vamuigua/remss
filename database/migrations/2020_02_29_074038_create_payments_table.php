<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('tenant_id')->nullable();
            $table->integer('invoice_id')->nullable()->unsigned();
            $table->string('payment_type')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_no')->nullable()->unique();
            $table->decimal('prev_balance')->nullable();
            $table->decimal('amount_paid')->nullable();
            $table->decimal('balance')->nullable();
            $table->string('comments')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payments');
    }
}
