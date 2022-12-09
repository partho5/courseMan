<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseTakenByStudents extends Model
{
    protected $guarded = [];

    public function courseInfo(){
        return $this->belongsTo(Course::class, 'course_id');
    }
}
