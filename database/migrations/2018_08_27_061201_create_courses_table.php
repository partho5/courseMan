<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('institute_id');
            $table->string('course_name');
            $table->string('course_code');
            $table->integer('total_class');
            $table->integer('min_percent_of_attendance')->default(0);
            $table->integer('marks_in_attendance')->default(5);
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
