<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffWorkSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_work_systems', function (Blueprint $table) {

            $table->Increments('id');

            $table->unsignedInteger('staff_id')->nullable();
            $table->foreign('staff_id')->references('id')->on('staff');

            $table->unsignedInteger('work_system_id')->nullable();
            $table->foreign('work_system_id')->references('id')->on('work_systems');

     
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
        Schema::dropIfExists('staff_work_systems');
    }
}
