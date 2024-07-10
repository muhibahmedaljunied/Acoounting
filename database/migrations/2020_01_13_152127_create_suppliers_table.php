<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->Increments('id');
         
            $table->unsignedInteger('group_id')->nullable();
            $table->foreign('group_id')->references('id')->on('groups');
         
            $table->string('name',30);
            $table->string('last_name',30);
            $table->string('code',50)->nullable();
            $table->string('company',10)->nullable();
            $table->string('email',50)->unique()->nullable();
            $table->string('phone',20)->nullable();
            $table->longtext('address')->nullable();
            $table->char('status', 1)->default('1')->nullable();    
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
        Schema::dropIfExists('suppliers');
    }
}
