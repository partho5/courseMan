<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoticeableCourse extends Model
{
    protected $guarded = [];

    public function courses(){
        return $this->belongsTo(Notice::class);
    }
}
