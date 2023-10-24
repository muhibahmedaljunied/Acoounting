<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('period_times', function (Blueprint $table) {
            $table->Increments('id');
      
 
            $table->unsignedInteger('period_id')->nullable();
            $table->foreign('period_id')->references('id')->on('periods');

            $table->time('from_time')->default(0);

            $table->time('into_time')->default(0);

            $table->integer('duration')->default(0);

        
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
        Schema::dropIfExists('period_times');
    }
}
