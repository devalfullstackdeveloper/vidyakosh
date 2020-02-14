<?php

namespace App\Models;

use App\Models\Departments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Sectionofficer extends Model
{
	 use SoftDeletes;
	
    protected $table = 'sectionofficers';
    protected $fillable = [
        'id','department_id','officer_id','status'
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
