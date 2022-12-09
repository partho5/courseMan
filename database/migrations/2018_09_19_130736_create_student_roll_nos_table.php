<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentRollNosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_roll_nos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('institute_id');
            $table->integer('roll_numeric');
            $table->string('roll_full_form');
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
        Schema::dropIfExists('student_roll_nos');
    }
}
