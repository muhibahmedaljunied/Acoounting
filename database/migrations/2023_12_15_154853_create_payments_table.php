<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('payments', function (Blueprint $table) {
            $table->Increments('id');
            
            // ---------------------------------
            $table->morphs('paymentable');
            // ---------------------------------
            $table->string('payment_info');
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
        Schema::dropIfExists('payments');
    }
}
