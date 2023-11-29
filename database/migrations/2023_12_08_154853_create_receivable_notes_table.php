<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivableNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('receivable_notes', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('sale_id');
            $table->foreign('sale_id')->references('id')->on('sales');

            $table->unsignedInteger('daily_id');
            $table->foreign('daily_id')->references('id')->on('dailies');

            // $table->string('paid')->default(0);
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
        Schema::dropIfExists('receivable_notes');
    }
}
