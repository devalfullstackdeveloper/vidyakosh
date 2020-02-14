<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeCategories extends Model
{
     protected $table = 'office_categories';
    protected $fillable = [
        'id','cat_id','office_id', 'status'
    ];
}
