<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseAllotmentUsers extends Model
{
    protected $table = 'course_allotment_users';
    protected $fillable = [
        'id','course_allotment_id','department_user_id',
    ];
    public $timestamps = false;
    
	public function courseallotment()
    {
        return $this->belongsTo(CourseAllotment::class);
    }
}
