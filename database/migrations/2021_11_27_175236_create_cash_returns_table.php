<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_returns', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('cash_id')->unsigned()->nullable();
            $table->foreign('cash_id')->references('id')->on('cashes');

           
            $table->integer('quantity')->nullable();
            $table->date('date')->nullable();
            $table->string('note')->nullable();


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
        Schema::dropIfExists('cash_returns');
    }
}
