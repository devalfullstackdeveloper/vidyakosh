<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseMinistry extends Model
{
     protected $table = 'course_ministry';
    protected $fillable = [
        'id','course_id','ministry_id',
    ];
}
