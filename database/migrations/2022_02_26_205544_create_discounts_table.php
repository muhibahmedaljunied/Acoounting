<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->Increments('id');

            $table->unsignedInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->string('name')->nullable();
            $table->unsignedInteger('discount_type_id');
            $table->foreign('discount_type_id')->references('id')->on('discount_types');
            $table->date('date');
            $table->integer('quantity');

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
        Schema::dropIfExists('discounts');
    }
}
