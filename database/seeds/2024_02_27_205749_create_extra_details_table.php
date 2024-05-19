<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_details', function (Blueprint $table) {

            $table->Increments('id');
            // -------------------------------------------------------------------------------
            $table->unsignedInteger('extra_id');
            $table->foreign('extra_id')->references('id')->on('extras');
            // --------------------------------------------------------------
            $table->unsignedInteger('extra_sanction_id');
            $table->foreign('extra_sanction_id')->references('id')->on('extra_sanctions');
            // ----------------------------------------------------------------------
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
        Schema::dropIfExists('extra_details');
    }
}
