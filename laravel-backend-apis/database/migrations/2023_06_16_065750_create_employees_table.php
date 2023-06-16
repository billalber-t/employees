<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // f_nam,  l_name, other_name, dob, joining_date, next_of_kin, next_of_kin_contact, education_level,
        // email, mobile_contact, home_contact
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('f_name');
            $table->string('l_name');
            $table->string('other_name');
            $table->date('dob');
            $table->date('joining_date');
            $table->string('email');
            $table->string('mobile_contact');
            $table->string('home_contact');
            $table->string('next_of_kin');
            $table->string('next_of_kin_contact');
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
        Schema::dropIfExists('employees');
    }
}
