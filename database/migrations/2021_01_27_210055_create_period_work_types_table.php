<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodWorkTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('period_work_types', function (Blueprint $table) {
            $table->Increments('id');
      
           
            // $table->string('name')->nullable();

            $table->unsignedInteger('work_type_id')->nullable();
            $table->foreign('work_type_id')->references('id')->on('work_types');

            $table->unsignedInteger('period_id')->nullable();
            $table->foreign('period_id')->references('id')->on('periods');

            $table->json('day_id');
            // $table->time('from_break')->nullable();
            // $table->time('into_break')->nullable();



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
        Schema::dropIfExists('period_work_types');
    }
}
