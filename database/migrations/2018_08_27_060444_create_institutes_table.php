<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('univ_name');
            $table->string('dept_name');
            $table->integer('num_of_batches');
            $table->integer('students_per_batch');
            $table->integer('min_percent_of_attendance');
            $table->integer('marks_in_attendance');
            $table->integer('created_by');
            $table->string('join_token');
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
        Schema::dropIfExists('institutes');
    }
}
