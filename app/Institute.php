<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    protected $guarded = [];

    public function courses(){
        return $this->hasMany(Course::class, 'institute_id');
    }

    public function instituteInfo($userId){
        $institute = Institute::find( $this->currentInstituteId($userId) );
        if(count($institute) > 0){
            return $institute;
        }
        return null;
    }

    public function currentInstituteId($userId){
        $row = UserRole::where('user_id', $userId)->select('institute_id')->get();
        if(count($row) > 0){
            return $row[0]->institute_id;
        }
        return null;
    }
}
