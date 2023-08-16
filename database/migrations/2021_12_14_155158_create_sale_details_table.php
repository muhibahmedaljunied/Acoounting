<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('sale_details', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('sale_id');
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');

          
            $table->unsignedInteger('store_product_id');
            $table->foreign('store_product_id')->references('id')->on('store_products');

            // $table->unsignedInteger('product_id');
            // $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // $table->unsignedInteger('store_id')->unsigned()->nullable();
            // $table->foreign('store_id')->references('id')->on('stores');

            // $table->unsignedInteger('status_id')->unsigned()->nullable();
            // $table->foreign('status_id')->references('id')->on('statuses');

            // $table->string('desc')->nullable();

            $table->unsignedInteger('unit_id')->unsigned()->nullable();
            $table->foreign('unit_id')->references('id')->on('units');

        
            
            $table->text('product_name')->nullable();
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
        Schema::dropIfExists('sale_details');
    }
}
