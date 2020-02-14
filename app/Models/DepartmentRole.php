<?php

namespace App\Models;

use App\Models\Departments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DepartmentRole extends Model
{
	 use SoftDeletes;
	
    protected $table = 'department_role';
    protected $fillable = [
        'id','department_id','parent_id','role_name','status'
    ];
	
	 /* public function location()
    {
        return $this->hasMany('App\Models\Locations');
    }
	*/
	
	 public function departments(){
        return $this->hasMany(Departments::class);
    }

}
