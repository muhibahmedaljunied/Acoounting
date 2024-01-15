<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_sales', function (Blueprint $table) {
            $table->Increments('id');
            // $table->integer('sale_id');
            $table->unsignedInteger('sale_id')->unsigned()->nullable();
            $table->foreign('sale_id')->references('id')->on('sales');
            $table->string('payment_info')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('paid')->default(0);
            $table->string('remaining')->default(0);
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
        Schema::dropIfExists('payment_sales');
    }
}
