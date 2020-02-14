<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
 

class UserFeedback extends Model
{
    protected $table = 'UserFeedbacks';
    protected $fillable = ['name','email','subject','feedback','agree'

    ];
	
	
	 /* public function Location(){
        return $this->hasMany(Locations::class);
    }*/
	
	
	 public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }
	
	
}
