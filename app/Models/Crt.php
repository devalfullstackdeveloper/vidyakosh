<?php

namespace App\Models;

use App\Models\Departments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Crt extends Model
{
	 use SoftDeletes;
	
    protected $table = 'crts';
    protected $fillable = [
        'id','department_id','officer_id'
    ];
	
	 /* public function location()
    {
        return $this->hasMany('App\Models\Locations');
    }
	*/
	
	 public function departments(){
        return $this->hasMany(Departments::class);
    }

     public function tracks(){
        return $this->hasMany(Track::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
