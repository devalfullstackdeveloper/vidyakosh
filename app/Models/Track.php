<?php

namespace App\Models;

use App\Models\Departments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Track extends Model
{
	 use SoftDeletes;
	
    protected $table = 'tracks';
    protected $fillable = [
        'id','department_id','name','status'
    ];
	
	 /* public function location()
    {
        return $this->hasMany('App\Models\Locations');
    }
	*/
	
	 public function departments(){
        return $this->hasMany(Departments::class);
    }

    public function crt()
    {
        return $this->belongsTo(Crt::class);
    }

    public function crttraining()
    {
        return $this->belongsTo(Crttraining::class);
    }
	
	 public function courses(){
        return $this->hasMany(Course::class);
    }

}
