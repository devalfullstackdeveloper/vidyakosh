<?php

namespace App\Models;

use App\Models\Departments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Training_types extends Model
{
	 use SoftDeletes;
	
    protected $table = 'training_types';
    protected $fillable = [
        'id','department_id','title','status'
    ];
	
	 /* public function location()
    {
        return $this->hasMany('App\Models\Locations');
    }
	*/

}
