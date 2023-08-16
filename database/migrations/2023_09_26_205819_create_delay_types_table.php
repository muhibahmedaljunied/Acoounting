<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelayTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delay_types', function (Blueprint $table) {

            $table->Increments('id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            // $table->int('from_time',30);
            // $table->int('into_time',50)->unique()->nullable();

            // $table->string('name',20)->nullable();

            
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
        Schema::dropIfExists('delay_types');
    }
}
