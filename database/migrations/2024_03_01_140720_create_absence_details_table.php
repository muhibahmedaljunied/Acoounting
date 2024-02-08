<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsenceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absence_details', function (Blueprint $table) {
            $table->Increments('id');
            // --------------------------------------------------------------
            $table->unsignedInteger('absence_id');
            $table->foreign('absence_id')->references('id')->on('absences');

            // --------------------------------------------------------------
            $table->unsignedInteger('absence_sanction_id');
            $table->foreign('absence_sanction_id')->references('id')->on('absence_sanctions');
       

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
        Schema::dropIfExists('absence_details');
    }
}
