<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseAllotmentCourse extends Model
{
    protected $table = 'course_allotment_courses';
    protected $fillable = [
        'id','course_allotment_id','course_id',
    ];
    public $timestamps = false;
    
	public function courseallotment()
    {
        return $this->belongsTo(CourseAllotment::class);
    }
}
