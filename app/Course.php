<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    protected $guarded = [];

    public function coursesTakenByStudents(){
        return $this->hasMany(CourseTakenByStudents::class);
    }

    public function institutes(){
        return $this->belongsTo(Institute::class);
    }

    public function getAllCourses($currentInstituteId){
        $courses = Course::where('institute_id', $currentInstituteId)->get();
        foreach ($courses as $course){
            $course['alreadyTaken'] = $this->alreadyTaken($course->id, Auth::id()) ? 1 : 0;
        }
        return $courses;
    }

    public function alreadyTaken($courseId, $userId){
        $row = CourseTakenByStudents::where('course_id', $courseId)->where('user_id', $userId)->get();
        return count($row) > 0;
    }

    public function joinCourse($courseId, $userId){
        CourseTakenByStudents::create([
            'course_id'     => $courseId,
            'user_id'       => $userId,
            'created_at'    => Carbon::now(), 'updated_at'  => Carbon::now(),
        ]);
    }

    public function leaveCourse($courseId, $userId){
        CourseTakenByStudents::where('course_id', $courseId)->where('user_id', $userId)->delete();
    }
}
