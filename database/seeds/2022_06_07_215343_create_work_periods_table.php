<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_periods', function (Blueprint $table) {
            $table->Increments('id');
      
            $table->unsignedInteger('work_system_id');
            $table->foreign('work_system_id')->references('id')->on('work_systems');


            $table->unsignedInteger('period_id');
            $table->foreign('period_id')->references('id')->on('periods');



        
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
        Schema::dropIfExists('work_periods');
    }
}
