<?php

namespace App\Models;

use App\Models\Departments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Year extends Model
{
	 use SoftDeletes;
	
    protected $table = 'years';
    protected $fillable = [
        'id','department_id','name','year','status'
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
