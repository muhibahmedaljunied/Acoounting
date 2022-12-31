<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('purchase_id');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');

            $table->unsignedInteger('store_product_id');
            $table->foreign('store_product_id')->references('id')->on('store_products');

            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->unsignedInteger('store_id')->unsigned()->nullable();
            $table->foreign('store_id')->references('id')->on('stores');

            // $table->unsignedInteger('shelve_id')->unsigned()->nullable();
            // $table->foreign('shelve_id')->references('id')->on('shelves');

            $table->unsignedInteger('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('statuses');


            $table->string('desc')->nullable();
            
            $table->string('product_name')->nullable();
            $table->string('qty');
            $table->string('price');
            $table->integer('qty_return')->default(0);
            
            // $table->unsignedInteger('unit_id');
            // $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');

            $table->string('total');

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
        Schema::dropIfExists('purchase_details');
    }
}
