<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expences', function (Blueprint $table) {
            $table->Increments('id');
         
            // $table->unsignedInteger('expence_type_id');
            // $table->foreign('expence_type_id')->references('id')->on('expence_types');

            $table->unsignedInteger('daily_id');
            $table->foreign('daily_id')->references('id')->on('dailies');
            
            $table->date('date')->nullable();

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
        Schema::dropIfExists('expences');
    }
}
