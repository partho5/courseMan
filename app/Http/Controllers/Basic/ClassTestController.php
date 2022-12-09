<?php

namespace App\Http\Controllers\Basic;

use App\ClassTest;
use App\Course;
use App\StudentAttendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ClassTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $courseId = $request->input('id');
        $users = DB::table('course_taken_by_students as c')
            ->join('users as u', 'u.id', '=', 'c.user_id')
            ->join('student_roll_nos as r', 'r.user_id', '=', 'u.id')
            ->select('u.id as user_id', 'u.name', 'r.roll_full_form')
            ->where('c.course_id', $courseId)
            ->get();

        $tmpMarks = ClassTest::where('course_id', $courseId)->get();
        $marks = [];
        foreach ($tmpMarks as $tmp){
            $row = [];
            $row[$tmp->user_id] = $tmp;
            array_push($marks, $row);
        }


        $rows = StudentAttendance::where('course_id', $courseId)
            ->where('attendance_status', 1)
            ->get()
            ->groupBy('user_id');
        $numOfClassAttended = []; $attendancePercent = [];
        $marksAllocatedForAttendance = 5;
        $totalClass = Course::find($courseId)->total_class;
        foreach ($rows as $user_id => $row){
            $totalPresent = count($row);
            $numOfClassAttended[$user_id] = $totalPresent;
            $attendancePercent[$user_id] = number_format($totalPresent * 100 / $totalClass, 2);
            $mark = $marksAllocatedForAttendance * $totalPresent / $totalClass;
            $attendanceMarks[$user_id] = number_format($mark, 2);
        }
        //return $marks;
        return view('teacher/course/class_test', compact(
            'users', 'courseId', 'attendanceMarks', 'attendancePercent', 'numOfClassAttended', 'marks'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->input('marks') as $row){
            $courseId = $request->input('courseId');
            $userId = $row['userId'];

            $classTest = ClassTest::firstOrNew(['user_id' => $userId, 'course_id' => $courseId]);
            $classTest->ct1 = $row['ct1Mark'];
            $classTest->ct2 = $row['ct2Mark'];
            $classTest->assignment1 = $row['assignment1Mark'];
            $classTest->assignment2 = $row['assignment2Mark'];
            $classTest->assignment3 = $row['assignment3Mark'];
            $classTest->note = $row['note'];
            $classTest->save();
        }
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
