<?php

namespace App\Models;

use App\Models\Departments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tabtrainingstatus extends Model
{
	 use SoftDeletes;
	
    protected $table = 'tab_training_status';
    protected $fillable = [
        'id','crt_id','user_id','reportingmanagerid','status','nominate_date'
    ];
	
	 /* public function location()
    {
        return $this->hasMany('App\Models\Locations');
    }
	*/
	
	 public function departments(){
        return $this->hasMany(Departments::class);
    }

public function departments(){
        return $this->hasMany(Departments::class);
    }
}
