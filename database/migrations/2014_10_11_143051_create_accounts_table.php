<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Schema::connection('mysql2')->create('some_table', function($table)
        Schema::create('accounts', function (Blueprint $table) {



            $table->Increments('id');
            $table->string('text');
            $table->string('account_name_en')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('accounts');
            $table->integer('rank')->nullable();
            $table->string('account_type')->nullable();
            $table->string('currency')->nullable();
            $table->integer('type_branch')->nullable();
            $table->string('status_account');
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
        Schema::dropIfExists('accounts');
    }
}
