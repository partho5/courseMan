<?php

namespace App\Http\Controllers\Basic;

use App\Institute;
use App\User;
use App\UserCurrentInstitute;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class RoleManager extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instituteId = (new Institute())->currentInstituteId(Auth::id());
        $userInfo = DB::table('user_roles as r')
            ->select('r.user_id', 'r.role_id', 'u.name', 'u.email', 'u.created_at')
            ->join('users as u', 'u.id', '=', 'r.user_id')
            ->where('r.institute_id', '=', $instituteId)
            ->where('r.desired_role_id', '=', (new UserRole())->roleNames()->TEACHER)
            ->get();
        $roles = (new UserRole())->roleNames();
        return view('teacher/basic/role_manager', compact('userInfo', 'roles'));
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


    public function UpdateRoleByTeachers(Request $request){
        $requesterRole = UserRole::where('user_id', Auth::id())->select('role_id')->get();
        $targetUserInstitute = UserCurrentInstitute::where('user_id', $request->input('user_id'))->select('institute_id')->get();
        if(count($requesterRole) > 0 && count($targetUserInstitute) > 0){
            if($requesterRole[0]->role_id >= (new UserRole())->roleNames()->TEACHER){
                //if user has at least teacher role
                try{
                    UserRole::where('user_id', $request->input('user_id'))
                        ->where('institute_id', $targetUserInstitute[0]->institute_id)
                        ->update(['role_id'=>$request->input('role_id')]);
                    return response()->json(['msg'=>'success'], 200);
                }catch (Exception $e){
                    return 'error';
                }
            }
        }
        return 'error';
    }
}
