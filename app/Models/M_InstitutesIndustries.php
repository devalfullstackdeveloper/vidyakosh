<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_InstitutesIndustries extends Model
{
    protected $table = 'ministry_institute_industry';
    protected $fillable = [
        'id','institute_industry_id','ministry_id',
    ];
}
