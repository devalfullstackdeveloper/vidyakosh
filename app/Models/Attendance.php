<?php

namespace App\Models;

use App\Models\Departments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Attendance extends Model
{
	 use SoftDeletes;
	
    protected $table = 'attendances';
    protected $fillable = [
        'id','department_id','user_id','designation_id','created_by'
    ];
	
	 /* public function location()
    {
        return $this->hasMany('App\Models\Locations');
    }
	*/
	
	 
}
