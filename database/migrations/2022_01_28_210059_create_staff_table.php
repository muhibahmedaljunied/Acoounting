<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->Increments('id');

            $table->string('name');
            $table->string('register')->nullable();

           

            // $table->unsignedInteger('work_type_id');
            // $table->foreign('work_type_id')->references('id')->on('work_types');



            $table->integer('phone');
            $table->string('email');
            $table->integer('salary')->default(0);
            $table->integer('personal_card');
            $table->date('date');
            $table->integer('staff_status');
            $table->integer('gender');
            $table->integer('social_status');
            $table->date('barth_date');
            $table->unsignedInteger('qualification_id');
            $table->foreign('qualification_id')->references('id')->on('qualifications');

            // $table->unsignedInteger('salary_id');
            // $table->foreign('salary_id')->references('id')->on('salarys');

            $table->unsignedInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches');

            $table->unsignedInteger('department_id');
            $table->foreign('department_id')->references('id')->on('administrative_structures');

            $table->unsignedInteger('job_id');
            $table->foreign('job_id')->references('id')->on('administrative_structures');

            $table->unsignedInteger('staff_type_id');
            $table->foreign('staff_type_id')->references('id')->on('staff_types');

            $table->unsignedInteger('religion_id');
            $table->foreign('religion_id')->references('id')->on('staff_religions');

  

            $table->unsignedInteger('nationality_id');
            $table->foreign('nationality_id')->references('id')->on('nationalities');

          
            
     
        
   
         
    
           


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
        Schema::dropIfExists('staff');
    }
}
