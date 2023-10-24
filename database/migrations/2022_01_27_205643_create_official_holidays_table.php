<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficialHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     public function up()
     {
         Schema::create('official_holidays', function (Blueprint $table) {
            
            $table->Increments('id');

            $table->string('name');

            $table->date('from_date')->nullable();
            $table->date('into_date')->nullable();
            $table->integer('duration')->nullable();

            // $table->int('number_of_days');

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
        Schema::dropIfExists('official_holidays');
    }
}
