<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
     protected $table = 'agenda';
    protected $fillable = [
        'id','crt_id','agenda_date','session_duration_from','session_duration_to','type','title','speaker','resourse_person'
    ];
}
