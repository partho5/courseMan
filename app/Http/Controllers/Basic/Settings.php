<?php

namespace App\Http\Controllers\Basic;

use App\Batch;
use App\Institute;
use App\StudentCurrentBatch;
use App\StudentRollNo;
use App\UserProfile;
use App\UserRole;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Settings extends Controller
{
    public function index(){
        $instituteId = (new Institute())->currentInstituteId(Auth::id());
        $role = (new UserRole())->getRole($instituteId, Auth::id());

        if($role){
            //user is joined in any department
            if($role == (new UserRole())->roleNames()->TEACHER ){
                //get current institute id
                $row = DB::table('institutes as i')
                    ->join('user_current_institutes as c', 'i.id', '=', 'c.institute_id')
                    ->select('i.join_token')
                    ->where('c.user_id', Auth::id())
                    ->get();
                $joinToken = count($row) == 1 ? $row[0]->join_token : null;

                $userProfile = UserProfile::where('user_id', Auth::id())->select('pp_url')->get();
                $profilePicUrl = count($userProfile) == 1 ? $userProfile[0]->pp_url :  '/images/user-icon.jpeg';

                return view('teacher/basic/settings', compact('joinToken', 'profilePicUrl'));
            }else{
                $instituteId = (new Institute())->currentInstituteId(Auth::id());
                $batches = Batch::where('institute_id', $instituteId)->get();
                $currentBatchId = (new StudentCurrentBatch())->currentBatchId(Auth::id(), $instituteId);
                return view('student/basic/settings', compact('batches', 'currentBatchId'));
            }
        }else{
            //user not joined any department
        }
    }



    public function updateStudentCurrentBatch(Request $request){
        $currentInstituteId = (new Institute())->currentInstituteId(Auth::id());
        $row = StudentCurrentBatch::where('user_id', Auth::id())->where('institute_id', $currentInstituteId)->get();
        if(count($row) > 0){
            StudentCurrentBatch::where('user_id', Auth::id())->where('institute_id', $currentInstituteId)
                ->update(['batch_id'=>$request->input('batch_id')]);
            echo 'success';
        }else{
            StudentCurrentBatch::create([
                'user_id'       => Auth::id(),
                'institute_id'  => $currentInstituteId,
                'batch_id'      => $request->input('batch_id'),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]);
            echo 'success';
        }
    }


    public function saveRollNo(Request $request){
        $request['user_id'] = Auth::id();
        $instituteId = (new Institute())->currentInstituteId(Auth::id());
        $request['institute_id'] = $instituteId;
        $row = StudentRollNo::where('user_id', Auth::id())->where('institute_id', $instituteId)->get();
        if(count($row) > 0){
            StudentRollNo::where('user_id', Auth::id())->where('institute_id', $instituteId)
                ->update(['roll_numeric' => $request->input('roll_numeric'), 'roll_full_form' => $request->input('roll_full_form')]);
            echo 'updated';
        }else{
            StudentRollNo::create($request->except('_token'));
            echo 'saved';
        }
    }


    public function uploadPhoto(Request $request){
        if( $request->file('pp') !== null ){
            $file = $request->file('pp');
            $fileName = str_replace(' ', '_', $file->getClientOriginalName());
            Storage::disk('uploaded')->put($fileName, $file); //'uploaded' is the name of disk, in filesystem.php
            //Storage::disk('s3')->put('my-cloud/'.$fileName, $file, 'public');
            $pp_url = "/uploaded/".$fileName."/".$file->hashName();
            $profile = UserProfile::firstOrNew(['user_id' => Auth::id()]);
            $profile->pp_url = $pp_url;
            $profile->save();
            return redirect('/');
        }
    }



}
