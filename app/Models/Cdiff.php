<?php

namespace App\Models;

use App\Models\Departments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Cdiff extends Model
{
	 use SoftDeletes;
	
    protected $table = 'course_difficulty';
    protected $fillable = [
        'id','name','status'
    ];
	
	 /* public function location()
    {
        return $this->hasMany('App\Models\Locations');
    }
	*/
	
	 public function courses(){
        return $this->belongsToMany(Course::class);
    }

}
