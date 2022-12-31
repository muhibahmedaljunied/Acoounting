<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->Increments('id');

            $table->unsignedInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff');

            $table->float('net_salary');
            $table->float('total_allowance')->nullable();
            $table->float('total_discount')->nullable();
            $table->float('total_extra')->nullable();
            $table->float('total_advance')->nullable();
            // $table->float('total_hours');
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
        Schema::dropIfExists('payrolls');
    }
}
