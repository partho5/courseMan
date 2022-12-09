<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentCurrentBatch extends Model
{
    protected $guarded = [];

    public function currentBatchId($userId, $instituteId){
        $batch = StudentCurrentBatch::where('user_id', $userId)->where('institute_id', $instituteId)->get();
        if(count($batch) > 0){
            return $batch[0]->batch_id;
        }
        return null;
    }
}
