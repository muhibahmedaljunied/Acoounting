<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacations', function (Blueprint $table) {
            $table->Increments('id');

            $table->unsignedInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff');

            $table->unsignedInteger('vacation_type_id');
            $table->foreign('vacation_type_id')->references('id')->on('vacation_types');

            $table->string('status')->nullable();
            
            $table->integer('total_days');
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('vacations');
    }
}
