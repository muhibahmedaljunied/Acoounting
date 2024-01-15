<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            
            $table->Increments('id');

            // $table->unsignedInteger('product_id');
            // $table->foreign('product_id')->references('id')->on('products');

            // $table->unsignedInteger('store_id')->unsigned()->nullable();
            // $table->foreign('store_id')->references('id')->on('stores');

            
            $table->unsignedInteger('store_product_id')->unsigned()->nullable();
            $table->foreign('store_product_id')->references('id')->on('store_products')->onDelete('cascade');


            $table->unsignedInteger('unit_id')->unsigned()->nullable();
            $table->foreign('unit_id')->references('id')->on('units');


            // $table->unsignedInteger('status_id')->unsigned()->nullable();
            // $table->foreign('status_id')->references('id')->on('statuses');

            $table->morphs('stockable');

            $table->string('desc')->nullable();
            $table->integer('quantity')->default(0);


            // $table->integer('number_operation')->nullable(); //canceld
            // $table->string('type_operation');
            $table->date('date');

            

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
        Schema::dropIfExists('stocks');
    }
}
