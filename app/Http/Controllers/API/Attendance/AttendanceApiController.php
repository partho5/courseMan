<?php

namespace App\Http\Controllers\API\Attendance;

use App\Course;
use App\CourseTakenByStudents;
use App\Institute;
use App\StudentAttendance;
use App\StudentRollNo;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class AttendanceApiController extends Controller
{
    public function getBasicData(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        if(Auth::attempt(['email'=>$email, 'password'=>$password])){
            $user = User::where('email', $email)->select('id', 'name', 'created_at')->get()[0];
            $courses = DB::table('institutes as i')
                ->join('courses as c', 'i.id', '=', 'c.institute_id')
                ->select('c.id as course_id', 'c.course_name', 'c.course_code', 'i.id as institute_id',
                    'i.univ_name as institute', 'i.dept_name as dept', 'c.total_class', 'c.min_percent_of_attendance')
                ->get();
            $students = DB::table('course_taken_by_students as t')
                ->join('courses as c', 'c.id', '=', 't.course_id')
                ->join('users as u', 'u.id', '=', 't.user_id')
                ->join('student_roll_nos as r', 'r.user_id', '=', 't.user_id')
                ->select('u.name', 't.user_id', 't.course_id', 'r.roll_numeric', 'r.roll_full_form')
                ->where('c.created_by', $user->id)
                ->get();

            return $data = [
                'userId'                => $user->id,
                'courses'               => $courses,
                'courseTakerStudents'   => $students
            ];
        }
        return response()->json([
            'msg'   => 'Unauthorized Access'
        ], 403);
    }



    public function sendAttendanceData(Request $request){
        $str = $request->input('data');
        //return $str;
        $str = json_decode($str);
        $data = [];
        foreach($str as $item){
            $row['course_id'] = $item->course_id;
            $row['user_id'] = $item->user_id;
            $row['attendance_date'] = date('Y-m-d', strtotime($item->attendance_date));
            $row['attendance_status'] = $item->attendance_status;
            $row['created_at'] = Carbon::now();
            $row['updated_at'] = Carbon::now();
            //array_push($data, $row);

            try{
                StudentAttendance::insert($row);
            }catch (\Illuminate\Database\QueryException $e){
                /*
                 * "Stupidly" assume that, Exception will occur only when constraint violation occurs
                 * And constraint will violate when data exists. So update that data
                 */
                StudentAttendance::where('user_id', $row['user_id'])->where('course_id', $row['course_id'])
                    ->where('attendance_date', $row['attendance_date'])
                    ->update(['attendance_status' => $row['attendance_status']]);
            }
        }


        $response['syncStatus'] = "success";
        return $response;
    }

}
