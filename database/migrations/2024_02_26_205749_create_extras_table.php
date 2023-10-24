<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extras', function (Blueprint $table) {

            $table->Increments('id');
            $table->unsignedInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff');
            // --------------------------------------------------------------
            $table->unsignedInteger('extra_type_id');
            $table->foreign('extra_type_id')->references('id')->on('extra_types');
            // ----------------------------------------------------------------------
            // $table->unsignedInteger('extra_sanction_id');
            // $table->foreign('extra_sanction_id')->references('id')->on('extra_sanctions');
            // ----------------------------------------------------------------------

            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->float('number_hours')->nullable();

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
        Schema::dropIfExists('extras');
    }
}
