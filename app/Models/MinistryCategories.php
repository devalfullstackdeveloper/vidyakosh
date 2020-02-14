<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinistryCategories extends Model
{
     protected $table = 'ministry_categories';
    protected $fillable = [
        'id','cat_id','ministry_id', 'status'
    ];
}
