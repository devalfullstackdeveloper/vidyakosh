<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class Departments extends Model
{
    protected $table = 'departments';
    protected $fillable = [
        'id','ministry_id','department_name', 'status'
    ];
	
	
	 /* public function Location(){
        return $this->hasMany(Locations::class);
    }*/
	
	
	 public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }
	
	
}
