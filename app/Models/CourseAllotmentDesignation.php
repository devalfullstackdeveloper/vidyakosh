<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseAllotmentDesignation extends Model
{
    protected $table = 'course_allotment_designation';
    protected $fillable = [
        'id','course_allotment_id','designation_id',
    ];
    public $timestamps = false;
    
	public function courseallotment()
    {
        return $this->belongsTo(CourseAllotment::class);
    }
}
