<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {Schema::create('return_sale_details', function (Blueprint $table) {
        $table->increments('id');
    
        $table->string('desc')->nullable();

        $table->integer('qty')->nullable();

        $table->unsignedInteger('store_product_id');
        $table->foreign('store_product_id')->references('id')->on('store_products');
        

        $table->integer('product_id')->unsigned()->nullable();
        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

        $table->unsignedInteger('store_id')->unsigned()->nullable();
            $table->foreign('store_id')->references('id')->on('stores');

            // $table->unsignedInteger('shelve_id')->unsigned()->nullable();
            // $table->foreign('shelve_id')->references('id')->on('shelves');

            $table->unsignedInteger('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('statuses');



        
        $table->integer('sale_return_id')->unsigned()->nullable();
        $table->foreign('sale_return_id')->references('id')->on('return_sales')->onDelete('cascade');

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
        Schema::dropIfExists('return_sale_details');
    }
}
