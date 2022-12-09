<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserCurrentInstitute extends Model
{
    protected $guarded = [];



    public function insertCurrentInstitute($userId, $instituteId){
        UserCurrentInstitute::create([
            'user_id'           => $userId,
            'institute_id'      => $instituteId,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
        ]);
    }

    public function updateCurrentInstitute($userId, $instituteId){
        UserCurrentInstitute::where('user_id', $userId)->update(['institute_id' => $instituteId]);
    }

    public function setCurrentInstituteId($userId, $instituteId){
        $exist = UserCurrentInstitute::where('user_id', $userId)->where('institute_id', $instituteId)->get();
        if(count($exist) > 0){
            $this->updateCurrentInstitute($userId, $instituteId);
        }else{
            $this->insertCurrentInstitute($userId, $instituteId);
        }
    }
}
