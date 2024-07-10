<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_details', function (Blueprint $table) {
            $table->Increments('id');

            $table->unsignedInteger('transfer_id');
            $table->foreign('transfer_id')->references('id')->on('transfers');

            
            $table->unsignedInteger('store_product_id');
            $table->foreign('store_product_id')->references('id')->on('store_products');

            // $table->unsignedInteger('product_id');
            // $table->foreign('product_id')->references('id')->on('products');

            // $table->unsignedInteger('store_id')->unsigned()->nullable();
            // $table->foreign('store_id')->references('id')->on('stores');

           
            // $table->unsignedInteger('status_id')->unsigned()->nullable();
            // $table->foreign('status_id')->references('id')->on('statuses');

            // $table->string('desc')->nullable();

            // $table->unsignedInteger('unit_id')->unsigned()->nullable();
            // $table->foreign('unit_id')->references('id')->on('units');


       
            // $table->string('status')->nullable();

            // $table->string('product_name')->nullable();

            $table->text('into_store')->nullable();
            $table->text('from_store')->nullable();
            // $table->text('into_shelve')->nullable();

            $table->integer('qty');
          
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
        Schema::dropIfExists('transfer_details');
    }
}
