<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_parts', function (Blueprint $table) {

            $table->Increments('id');
         
    
            // ----------------------------------------------------------------------
            $table->string('name')->nullable();
            $table->time('from_time')->nullable();
            $table->time('into_time')->nullable();
        
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
        Schema::dropIfExists('extra_parts');
    }
}
