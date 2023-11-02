<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateAbsenceSanctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absence_sanctions', function (Blueprint $table) {
            
            $table->Increments('id');

            // $table->unsignedInteger('staff_id');
            // $table->foreign('staff_id')->references('id')->on('staff');

    
            $table->unsignedInteger('absence_type_id');
            $table->foreign('absence_type_id')->references('id')->on('absence_types');

            $table->unsignedInteger('sanction_discount_id');
            $table->foreign('sanction_discount_id')->references('id')->on('sanction_discounts');

            // $table->unsignedInteger('part_id');
            // $table->foreign('part_id')->references('id')->on('parts');

            $table->integer('discount');

            $table->integer('iteration');
            $table->integer('sanction');

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
        Schema::dropIfExists('absence_sanctions');
    }
}
