<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Schema::connection('mysql2')->create('some_table', function($table)
        Schema::create('groups', function (Blueprint $table) {



            $table->Increments('id');
            $table->string('name');
            $table->unsignedInteger('group_type_id')->nullable();
            $table->foreign('group_type_id')->references('id')->on('group_types');
            $table->unsignedInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('groups');
    }
}
