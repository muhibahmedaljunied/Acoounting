<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allowances', function (Blueprint $table) {
            $table->Increments('id');

            $table->unsignedInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff');


            $table->unsignedInteger('allowance_type_id');
            $table->foreign('allowance_type_id')->references('id')->on('allowance_types');

            $table->integer('status')->nullable();
            $table->integer('quantity');
            $table->date('date')->nullable();
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
        Schema::dropIfExists('allowances');
    }
}
