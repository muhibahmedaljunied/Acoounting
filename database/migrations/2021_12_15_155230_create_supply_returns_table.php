<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_returns', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('supply_id')->unsigned()->nullable();
            $table->foreign('supply_id')->references('id')->on('supplies')->onDelete('cascade');

            $table->unsignedInteger('daily_id')->nullable();
            $table->foreign('daily_id')->references('id')->on('dailies')->onDelete('cascade');


           
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
        Schema::dropIfExists('supply_returns');
    }
}
