<?php

namespace App\Models;

use App\Models\Departments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class OrganizationDepartments extends Model
{
	 use SoftDeletes;
	
    protected $table = 'organization_departments';
    protected $fillable = [
        'id','department_id','department_name','is_group','parent_id','status'
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
