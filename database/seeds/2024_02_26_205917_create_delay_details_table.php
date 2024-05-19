<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelayDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delay_details', function (Blueprint $table) {
            $table->Increments('id');
            // --------------------------------------------------------------

            $table->unsignedInteger('delay_id');
            $table->foreign('delay_id')->references('id')->on('delays');
            // --------------------------------------------------------------

            $table->unsignedInteger('delay_sanction_id');
            $table->foreign('delay_sanction_id')->references('id')->on('delay_sanctions');
           
        
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
        Schema::dropIfExists('delay_details');
    }
}
