<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOthersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_others', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('name');
            // $table->unsignedInteger('category_id');
            // $table->foreign('category_id')->references('id')->on('categories');

            $table->string('image')->nullable();
            $table->float('price_sale')->nullable();
            $table->float('price_burchase')->nullable();
            $table->date('end_date')->nullable();
            $table->date('end_notify')->nullable();
            $table->string('notes')->nullable();

        
   
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
        Schema::dropIfExists('product_others');
    }
}
