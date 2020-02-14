<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
     protected $table = 'resources';
    protected $fillable = [
        'id','department_id', 'track_id', 'category_id', 'sub_category_id', 'resource_type', 'resource_title', 'suggested_link'
    ];
}
