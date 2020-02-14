<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
 

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $fillable = [
        'id','department_id','login_user_id','training_id','topic','topic_rating','faculties','faculties_rating','prospective','structure','interaction','venue','arrangement','location_rate','coordination','coordination_rating','activities','capability','utilizing','suggestions','overall_rating'
    ];
	
	
	 /* public function Location(){
        return $this->hasMany(Locations::class);
    }*/
	
	
	 public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }
	
	
}
