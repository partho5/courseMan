<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class UserRole extends Model
{
    protected $guarded = [];


    public function roleNames(){
        $roles = new \stdClass();

        //NEVER modify these values : 0,5,10 ...etc or role names : GUEST, STUDENT ...etc.
        $roles->GUEST = 0;
        $roles->STUDENT = 5;
        $roles->TEACHER = 10;

        return $roles;
    }


    public function setRole($instituteId, $userId, $roleId, $desiredRoleId){
        UserRole::create([
            'institute_id'  => $instituteId,
            'user_id'       => $userId,
            'role_id'       => $desiredRoleId,
            'desired_role_id'=> $roleId,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }


    public function getRole($instituteId, $userId){
        if(is_null($instituteId)){
            //then just find , if there's at least one institute_id related to this user_id
            $row = UserRole::where('user_id', $userId)->get();
            if(count($row) > 0){
                return $row[0]->role_id;
            }
            return null;
        }
        $row = UserRole::where('user_id', $userId)->where('institute_id', $instituteId)->get();
        if(count($row) > 0){
            return $row[0]->role_id;
        }
        return null;
    }
}
