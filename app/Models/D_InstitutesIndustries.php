<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class D_InstitutesIndustries extends Model
{
    protected $table = 'department_institute_industry';
    protected $fillable = [
        'id','institute_industry_id','ministry_id',
    ];
}
