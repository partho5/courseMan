<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notice extends Model
{
    protected $guarded = [];

    public function noticeableCourses(){
        return $this->hasMany(NoticeableCourse::class);
    }


    public function getNotices($currentInstituteId){
        $notices = DB::table('notices')
            ->join('noticeable_courses', 'notices.id', '=', 'noticeable_courses.notice_id')
            ->join('courses', 'courses.id', '=', 'noticeable_courses.course_id')
            ->where('noticeable_courses.institute_id', $currentInstituteId)
            ->select('notices.id', 'notices.title', 'notices.details', 'notices.created_at', 'courses.course_name')
            ->orderBy('id', 'desc')
            ->get();
        return $notices;
    }

    public function getSingleCourseNotices($currentInstituteId, $courseId){
        $notices = DB::table('notices')
            ->join('noticeable_courses', 'notices.id', '=', 'noticeable_courses.notice_id')
            ->join('courses', 'courses.id', '=', 'noticeable_courses.course_id')
            ->where('noticeable_courses.institute_id', $currentInstituteId)
            ->where('courses.id', $courseId)
            ->select('notices.id', 'notices.title', 'notices.details', 'notices.created_at', 'courses.course_name')
            ->orderBy('id', 'desc')
            ->get();
        return $notices;
    }




}
