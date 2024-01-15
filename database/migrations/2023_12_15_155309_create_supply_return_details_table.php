<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyReturnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_return_details', function (Blueprint $table) {
            $table->increments('id');
           


            $table->unsignedInteger('supply_return_id')->unsigned();
            $table->foreign('supply_return_id')->references('id')->on('supply_returns');
 

            $table->integer('store_product_id')->unsigned();
            $table->foreign('store_product_id')->references('id')->on('store_products');
            
            // $table->integer('product_id')->unsigned();
            // $table->foreign('product_id')->references('id')->on('products');

            // $table->unsignedInteger('store_id')->unsigned();
            // $table->foreign('store_id')->references('id')->on('stores');


            // $table->unsignedInteger('status_id')->unsigned();
            // $table->foreign('status_id')->references('id')->on('statuses');

            // $table->string('desc')->nullable();


            $table->unsignedInteger('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units');

        
            $table->integer('qty')->nullable();

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
        Schema::dropIfExists('supply_return_details');
    }
}
