<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('payment_purchases', function (Blueprint $table) {
            $table->Increments('id');
            // $table->integer('purchase_id');
            $table->unsignedInteger('purchase_id')->unsigned()->nullable();
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');

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
        Schema::dropIfExists('payment_purchases');
    }
}
