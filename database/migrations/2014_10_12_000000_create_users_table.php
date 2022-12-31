<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('role_id')->default('3');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->string('name');

            $table->string('phone')->default('776165784')->nullable();

            $table->string('email')->unique()->nullable();

            $table->timestamp('email_verified_at');

            $table->string('address')->default('taiz')->nullable();

            $table->string('password');

            $table->string('status')->default('1')->nullable();
            
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
