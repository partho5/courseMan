<?php

namespace App\Http\Controllers\Basic;

use App\Batch;
use App\Course;
use App\CourseTakenByStudents;
use App\Institute;
use App\Role;
use App\StudentAttendance;
use App\UserCurrentInstitute;
use App\UserProfile;
use App\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use App\Lib\Library;
use PhpParser\Node\Expr\Cast\Object_;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $Lib, $cookieLifetime = 6000000000000;

    function __construct()
    {
        $this->Lib = new Library();
    }

    public function index()
    {
        $userRole = Cookie::get('user_role'); // 'user_role' cookie is set RegisterController.php
        $desiredRole = Cookie::get('desired_role');

        //return view('student/basic/index');

//        Cookie::queue('desired_role', null, $this->cookieLifetime);
//        Cookie::queue('user_role', null, $this->cookieLifetime);
//        return;


        if(Auth::check()){
            $userRole = (new UserRole())->getRole(null, Auth::id());
            if($userRole){
                if($userRole == (new UserRole())->roleNames()->STUDENT){
                    $instituteInfo = (new Institute())->instituteInfo(Auth::id());
                    if(count($instituteInfo) > 0){
                        //user is joined in any department
                        $courses = CourseTakenByStudents::where('user_id', Auth::id())->get();
                        if(count($courses) > 0){
                            return redirect('/course/'.$courses[0]->course_id);
                        }else{
                            $takenCourses = CourseTakenByStudents::with(['courseInfo'])->where('user_id', Auth::id())->get();
                            $currentInstituteId = (new Institute())->currentInstituteId(Auth::id());
                            $allCourses = (new Course())->getAllCourses($currentInstituteId);
                            $notices = (new \App\Notice())->getNotices($currentInstituteId);
                            return view('student/basic/index', compact('takenCourses', 'allCourses', 'notices'));
                        }
                    }else{
                        //user not joined any department
                        return view('student/basic/join_department');
                    }
                }elseif($userRole == (new UserRole())->roleNames()->TEACHER){
                    //redirect according to role
                    $instituteInfo = (new Institute())->instituteInfo(Auth::id());
                    //$batches = Batch::where('institute_id', $instituteInfo->id)->get();
                    $courses = Course::where('created_by', Auth::id())->get();

                    $totalClassHeld = [];
                    foreach ($courses as $course){
                         $atten = StudentAttendance::where('course_id', $course->id)
                            ->select('attendance_date')
                            ->groupBy('attendance_date')
                            ->get()
                            ->count();
                         $totalClassHeld[$course->id] = $atten;
                    }

                    $userProfile = UserProfile::where('user_id', Auth::id())->select('pp_url')->get();
                    $profilePicUrl = count($userProfile) == 1 ? $userProfile[0]->pp_url :  '/images/user-icon.jpeg';

                    return view('teacher/basic/index',
                        compact(
                            'instituteInfo', 'courses', 'totalClassHeld', 'profilePicUrl'
                        ));
                }
            }else{
                //user not joined any department
                if($desiredRole == (new UserRole())->roleNames()->TEACHER){
                    return view('teacher/basic/join_or_config');
                }elseif($desiredRole == (new UserRole())->roleNames()->STUDENT){
                    return view('student/basic/join_department');
                }
            }
        }else{
            if($userRole){
                //user is not logged in but registered. So directly show login page
                return redirect('/login');
            }else{
                //user is new comer
                $desiredRole = Input::get('desired_role');
                $desiredRole = $desiredRole ? : Cookie::get('desired_role');
                if($desiredRole){
                    //clicked 'I am a student' / 'I am a teacher'
                    Cookie::queue('desired_role', $desiredRole, $this->cookieLifetime);
                    return redirect('/register');
                }else{
                    //first visit, and never clicked 'I am student' / 'I am teacher'
                    return view('common/introduction');
                }
            }
        }
    }



    public function configureSoftware(){
        return view('teacher/basic/initial_configuration');
    }

    public function configureStep1(Request $request){
        $univ = $request->input('univ_name');
        $dept = $request->input('dept_name');
        Session::put(['univ_name'=> $univ, 'dept_name'=>$dept]);

        return redirect('/configure?step=2');
    }

    public function configureStep2(Request $request){
        $numOfBatches = $request->input('num_of_batches');
        $batchNames = $request->input('batch_name');
        //dd($batchNames);
        $studentsPerBatch = $request->input('students_per_batch');
        Session::put(['num_of_batches'=> $numOfBatches, 'batch_name'=>$batchNames, 'students_per_batch'=>$studentsPerBatch]);

        return redirect('/configure?step=3');
    }

    public function configureStep3(Request $request){
        $request['univ_name'] = Session::get('univ_name');
        $request['dept_name'] = Session::get('dept_name');
        $request['num_of_batches'] = Session::get('num_of_batches');
        $request['batch_name'] = Session::get('batch_name');
        $request['students_per_batch'] = Session::get('students_per_batch');
        $request['created_by'] = Auth::id();
        $request['join_token'] = $this->generateInstituteJoinToken(10);

        unset($request['_token']);
        $batches = $request['batch_name']; //keep a copy before unset
        unset($request['batch_name']);

        $institute = Institute::create($request->all());

        $rows = [];
        foreach ($batches as $batch){
            if(! is_null($batch)){
                array_push($rows, [
                    'institute_id'      => $institute->id,
                    'batch_name'        => $batch
                ]);
            }
        }
        Batch::insert($rows);

        $role = (new UserRole());
        $role->setRole($institute->id, Auth::id(), $role->roleNames()->TEACHER, Cookie::get('desired_role'));
        (new UserCurrentInstitute())->setCurrentInstituteId(Auth::id(), $institute->id);

        Cookie::queue('user_role', (new UserRole())->roleNames()->TEACHER, $this->cookieLifetime);
        return redirect('/');
    }



    private function generateInstituteJoinToken($length){
        $token = $this->Lib->generateRandomToken($length);
        while( $this->Lib->columnExist( 'institutes', 'join_token', $token) ){
            echo "$token exist";
            $token = $this->Lib->generateRandomToken($length);
        }
        return $token;
    }



    public function joinDepartment(Request $request){
        $institute = Institute::where('join_token', $request->input('join_token'))->get();
        if(count($institute) > 0){
            $role = (new UserRole())->getRole($institute[0]->id, Auth::id());
            if(is_null($role)){
                //role is null, means role doesn't exist, so assign role
                UserRole::create([
                    'institute_id'      => $institute[0]->id,
                    'user_id'           => Auth::id(),
                    'role_id'           => ((new UserRole())->roleNames()->STUDENT),
                    'desired_role_id'   => Cookie::get('desired_role'),
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now()
                ]);
                UserCurrentInstitute::create([
                    'user_id'           => Auth::id(),
                    'institute_id'      => $institute[0]->id,
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now()
                ]);
                Cookie::queue('user_role', (new UserRole())->roleNames()->STUDENT, $this->cookieLifetime);
            }
            return redirect('/');
        }else{
            return redirect()->back()->with('msg', 'Wrong authentication code !');
        }
    }














    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
