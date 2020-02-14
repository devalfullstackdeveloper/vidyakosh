<?php

namespace App\Models;

use App\Models\Departments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Faculty extends Model
{
	 use SoftDeletes;
	
    protected $table = 'faculty';
    protected $fillable = [
        'id','department_id','institute_industry_id','name','status'
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
