<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_systems', function (Blueprint $table) {
            $table->Increments('id');
      
           
            $table->string('name')->nullable();

            $table->unsignedInteger('work_type_id')->nullable();
            $table->foreign('work_type_id')->references('id')->on('work_types');

            $table->unsignedInteger('period_id')->nullable();
            $table->foreign('period_id')->references('id')->on('periods');
           

            $table->unsignedInteger('break_id')->nullable();
            $table->foreign('break_id')->references('id')->on('breaks');
           

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
        Schema::dropIfExists('work_systems');
    }
}
