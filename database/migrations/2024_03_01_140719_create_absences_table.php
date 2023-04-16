<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->Increments('id');
            // --------------------------------------------------------------
            $table->unsignedInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff');

            // --------------------------------------------------------------
            $table->unsignedInteger('absence_type_id');
            $table->foreign('absence_type_id')->references('id')->on('absence_types');
            // --------------------------------------------------------------
            $table->date('date');
            $table->string('note')->nullable();

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
        Schema::dropIfExists('absences');
    }
}
