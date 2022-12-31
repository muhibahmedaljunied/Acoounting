<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->Increments('id');

            
            $table->unsignedInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff');

            $table->integer('quantity');

            $table->integer('number_premium');
            $table->integer('premium')->nullable();
           
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
        Schema::dropIfExists('loans');
    }
}
