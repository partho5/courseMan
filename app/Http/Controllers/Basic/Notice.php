<?php

namespace App\Http\Controllers\Basic;

use App\Institute;
use App\Mail\NoticeMailing;
use App\NoticeableCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Notice extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $notice = \App\Notice::create([
            'title'         => $request->input('title'),
            'details'       => $request->input('details'),
            'file_path'     => null, // actually it must be checked if theres any file uploaded (but temporarily I hardcoded null)
            'created_by'    => Auth::id(),
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        $courseIds = json_decode($request->input('courseIdToNotify'), true);
        $courseIdsArray = array();
        foreach ($courseIds as $val){
            array_push($courseIdsArray, (int)$val);
            NoticeableCourse::create([
                'notice_id'     => $notice->id,
                'institute_id'  => (new Institute())->currentInstituteId(Auth::id()),
                'course_id'     => (int)$val,
            ]);
        }

        $mailList = DB::table('course_taken_by_students as c')
            ->join('users as u', 'u.id', '=', 'c.user_id')
            ->select('u.email')
            ->whereIn('c.course_id', $courseIdsArray)
            ->get();

        $noticeData = [
            'title'     => $request->input('title'),
            'details'   => $request->input('details'),
            'created_by'=> Auth::user()->name,
        ];

        Mail::bcc($mailList)->queue(new NoticeMailing($noticeData));

        echo $notice->id;
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
