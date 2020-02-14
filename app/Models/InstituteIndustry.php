<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstituteIndustry extends Model
{
     protected $table = 'institute_industry';
    protected $fillable = [
        'id','type_id','name','phone','email','address', 'status', 'department_id'
    ];
}
