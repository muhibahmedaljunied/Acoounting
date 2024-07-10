<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('group_accounts', function (Blueprint $table) {


            $table->Increments('id');
            $table->morphs('dailyable');
            $table->unsignedInteger('daily_details_id')->nullable();
            $table->foreign('daily_details_id')->references('id')->on('daily_details');
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
        Schema::dropIfExists('group_accounts');
    }
}
