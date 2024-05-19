<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('cash_details', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('cash_id');
            $table->foreign('cash_id')->references('id')->on('cashes')->onDelete('cascade');

          
            $table->unsignedInteger('store_product_id');
            $table->foreign('store_product_id')->references('id')->on('store_products');

            $table->unsignedInteger('unit_id')->unsigned()->nullable();
            $table->foreign('unit_id')->references('id')->on('units');
    
            $table->integer('qty');
            $table->float('price');
            $table->float('total');
            $table->integer('qty_return')->default(0);
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
        Schema::dropIfExists('cash_details');
    }
}
