<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkSystemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_system_details', function (Blueprint $table) {
           
            
            $table->Increments('id');

            // $table->string('name');

            $table->unsignedInteger('work_system_id')->nullable();
            $table->foreign('work_system_id')->references('id')->on('work_systems');

            $table->unsignedInteger('work_type_id')->nullable();
            $table->foreign('work_type_id')->references('id')->on('work_types');


            $table->unsignedInteger('period_time_id')->nullable();
            $table->foreign('period_time_id')->references('id')->on('period_times');

            $table->json('day_id');

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
        Schema::dropIfExists('work_system_details');
    }
}
