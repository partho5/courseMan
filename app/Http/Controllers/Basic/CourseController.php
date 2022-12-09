<?php

namespace App\Http\Controllers\Basic;

use App\Course;
use App\CourseTakenByStudents;
use App\Institute;
use App\Lib\Library;
use App\StudentAttendance;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $user;

    private $Lib, $userRoleModel, $userRole;

    function __construct()
    {
        $this->Lib = new Library();

        // https://laravel-news.com/controller-construct-session-changes-in-laravel-5-3
        $this->middleware(function ($request, $next) {
            $this->user= Auth::user();

            $currentInstituteId = (new Institute())->currentInstituteId(Auth::id());
            $this->userRoleModel = new UserRole();
            $this->userRole = $this->userRoleModel->getRole($currentInstituteId,Auth::id());

            return $next($request);
        });



    }

    public function index()
    {
        //return view('teacher/course/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if($this->userRole == $this->userRoleModel->roleNames()->TEACHER){
            return view('student/course/create');
        }
        return view('errors/401');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $joinToken = $this->Lib->generateRandomToken(10);
        while( $this->Lib->columnExist('courses', 'join_token', $joinToken) ){
            $joinToken = $this->Lib->generateRandomToken(10);
        }
        $request['institute_id'] = (new Institute())->currentInstituteId(Auth::id());
        $request['join_token'] = $joinToken;
        $request['created_by'] = Auth::id();
        Course::create($request->except('_token'));
        return redirect()->back()->with('msg', 'Course Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($this->userRole == $this->userRoleModel->roleNames()->TEACHER){
            return view('teacher/course/index');
        }
        elseif($this->userRole == $this->userRoleModel->roleNames()->STUDENT){
            $takenCourses = CourseTakenByStudents::with(['courseInfo'])->where('user_id', Auth::id())->get();
            $currentInstituteId = (new Institute())->currentInstituteId(Auth::id());
            $allCourses = (new Course())->getAllCourses($currentInstituteId);
            $notices = (new \App\Notice())->getNotices($currentInstituteId);
            $singleCourseNotices = (new \App\Notice())->getSingleCourseNotices($currentInstituteId, $courseId = $id);
            $currentPageCourse = Course::find($id);


            $totalClassHeld = StudentAttendance::where('course_id', $id)
                ->select('attendance_date')
                ->groupBy('attendance_date')
                ->get()
                ->count();
            $attendedClass = StudentAttendance::where('course_id', $id)
                ->where('user_id', Auth::id())
                ->where('attendance_status', 1)
                ->get()
                ->count();
            $attendancePercent = $attendedClass * 100 / $totalClassHeld;
            $attendancePercent = number_format((float)$attendancePercent, 2, '.', '');

            return view('student/course/index', compact(
                'takenCourses', 'allCourses', 'notices', 'singleCourseNotices', 'currentPageCourse', 'totalClassHeld',
                'attendedClass', 'attendancePercent'
            ));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::find($id);
        //return $course;
        if($this->userRole == $this->userRoleModel->roleNames()->TEACHER){
            return view('teacher/course/edit', compact('course'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Course::find($id)->update($request->all());
        return redirect()->back()->with("msg", "Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Course::find($id)->delete();
        return redirect()->back();
    }


    public function joinOrLeaveCourse(Request $request){
        $course = (new Course());

        if($request->input('actionBtnText') == 'Join'){
            if( $course->alreadyTaken($request->input('courseId'), Auth::id()) ){
                echo 'Already taken';
            }else{
                $course->joinCourse($request->input('courseId'), Auth::id());
                echo 'joined course';
            }
        }elseif($request->input('actionBtnText') == 'Leave Course'){
            $course->leaveCourse($request->input('courseId'), Auth::id());
            echo 'left course';
        }
    }
}
