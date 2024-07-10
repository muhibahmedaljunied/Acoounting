<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->Increments('id');
            // --------------------------------------------------------------

            $table->unsignedInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff');
            // --------------------------------------------------------------

            $table->unsignedInteger('leave_type_id');
            $table->foreign('leave_type_id')->references('id')->on('leave_types');
            // --------------------------------------------------------------
            $table->unsignedInteger('part_id');
            $table->foreign('part_id')->references('id')->on('parts');
            // --------------------------------------------------------------

            $table->string('note')->nullable();
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
        Schema::dropIfExists('leaves');
    }
}
