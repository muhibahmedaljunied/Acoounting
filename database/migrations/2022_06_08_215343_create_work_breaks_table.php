<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkBreaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_breaks', function (Blueprint $table) {
            $table->Increments('id');
      
          
            $table->unsignedInteger('work_system_id');
            $table->foreign('work_system_id')->references('id')->on('work_systems');


            $table->unsignedInteger('break_id');
            $table->foreign('break_id')->references('id')->on('breaks');



        
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
        Schema::dropIfExists('work_breaks');
    }
}
