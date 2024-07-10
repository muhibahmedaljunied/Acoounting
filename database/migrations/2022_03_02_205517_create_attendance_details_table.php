<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_details', function (Blueprint $table) {
            $table->Increments('id');
             
            $table->unsignedInteger('attendance_id');
            $table->foreign('attendance_id')->references('id')->on('attendances');
            
         
            $table->unsignedInteger('period_id');
            $table->foreign('period_id')->references('id')->on('periods');

            $table->string('attendance_status');

            $table->time('check_in')->nullable()->default(0);

            $table->time('check_out')->nullable()->default(0);

            $table->integer('duration')->nullable()->default(0);

            $table->integer('delay')->nullable()->default(0);

            $table->integer('leave')->nullable()->default(0);

            $table->integer('extra')->nullable()->default(0);
            $table->integer('extra_after')->nullable()->default(0);


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
        Schema::dropIfExists('attendance_details');
    }
}
