<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrStaffAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('hr_staff_accounts', function (Blueprint $table) {


            $table->Increments('id');
            
            $table->unsignedInteger('hr_account_id')->nullable();
            $table->foreign('hr_account_id')->references('id')->on('hr_accounts');

            $table->unsignedInteger('staff_id')->nullable();
            $table->foreign('staff_id')->references('id')->on('staff');

            $table->unsignedInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');

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
        Schema::dropIfExists('hr_staff_accounts');
    }
}
