<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
class CreateExtraSanctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_sanctions', function (Blueprint $table) {

            $table->Increments('id');

            // $table->unsignedInteger('staff_id');
            // $table->foreign('staff_id')->references('id')->on('staff');


            $table->unsignedInteger('extra_type_id');
            $table->foreign('extra_type_id')->references('id')->on('extra_types');



            // $table->unsignedInteger('extra_part_id');
            // $table->foreign('extra_part_id')->references('id')->on('extra_parts');
            $table->unsignedInteger('part_id');
            $table->foreign('part_id')->references('id')->on('parts');

            $table->unsignedInteger('sanction_discount_id');
            $table->foreign('sanction_discount_id')->references('id')->on('sanction_discounts');


            $table->integer('iteration')->nullable();


            $table->integer('sanction')->nullable();

       
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
        Schema::dropIfExists('extra_sanctions');
    }
}
