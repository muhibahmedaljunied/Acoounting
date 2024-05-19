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
            $table->float('total_allowance')->default(0);
            $table->float('total_discount')->default(0);
            $table->float('total_extra')->default(0);
            $table->float('total_advance')->default(0);
            $table->float('total_sanction')->default(0);

            $table->float('total_delay_sanction')->default(0);
            $table->float('total_leave_sanction')->default(0);
            $table->float('total_absence_sanction')->default(0);
            $table->float('total_extra_sanction')->default(0);

            $table->string('status');
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
