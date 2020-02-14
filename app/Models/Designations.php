<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designations extends Model
{
     protected $table = 'designations';
    // 
     protected $fillable = [
        'id','department_id','parent_designation_id','designation','status'
    ];
}
