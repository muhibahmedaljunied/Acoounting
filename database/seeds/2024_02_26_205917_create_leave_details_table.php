<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_details', function (Blueprint $table) {
            $table->Increments('id');
            // --------------------------------------------------------------

            $table->unsignedInteger('leave_id');
            $table->foreign('leave_id')->references('id')->on('leaves');
            // --------------------------------------------------------------

            $table->unsignedInteger('leave_sanction_id');
            $table->foreign('leave_sanction_id')->references('id')->on('leave_sanctions');

        
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
        Schema::dropIfExists('leave_details');
    }
}
