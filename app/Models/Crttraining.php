<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crttraining extends Model
{
     protected $table = 'crttrainings';
    protected $fillable = [
        'id','department_id','track_id', 'category_id','year_id','state_id','city_id','venue_id','designation_id','title','description','corempcode','corinst_id','resourceempcode','resourceinst_id','timing','start_date','end_date','lastnominne','feedback'
        
    ];


     public function tracks(){
       return $this->belongsTo(Track::class);
    }
    public function tabtrainingstatus(){
       return $this->belongsTo(Tabtrainingstatus::class);
    }
}
