<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinistryBanner extends Model
{
    protected $table = 'ministries_banner';
    protected $fillable = [
        'id','ministry_id','banner_id','status'
    ];
}
