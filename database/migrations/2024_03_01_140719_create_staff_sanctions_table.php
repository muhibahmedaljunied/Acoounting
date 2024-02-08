<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffSanctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_sanctions', function (Blueprint $table) {
            $table->Increments('id');
            // --------------------------------------------------------------
            $table->unsignedInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff');
            // --------------------------------------------------------------
            // $table->unsignedInteger('attendance_id');
            // $table->foreign('attendance_id')->references('id')->on('attendances');
            // // --------------------------------------------------------------
            $table->morphs('sanctionable');

            $table->date('date');

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
        Schema::dropIfExists('staff_sanctions');
    }
}
