<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->unsignedInteger('daily_id')->nullable();
            $table->foreign('daily_id')->references('id')->on('dailies')->onDelete('cascade');

            $table->text('customer_name')->nullable();
            $table->date('date')->nullable();
            // $table->text('total');
            $table->decimal('discount')->nullable();
            $table->decimal('tax_amount')->nullable();
            $table->string('status')->default('pending');

            $table->string('sub_total')->nullable();
       
            $table->integer('grand_total');
            
            // $table->integer('quantity')->nullable();
            // $table->integer('qty_return')->default(0);
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
        Schema::dropIfExists('sales');
    }
}
