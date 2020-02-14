<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentCategories extends Model
{
    protected $table = 'department_categories';
    protected $fillable = [
        'id','cat_id','department_id', 'status'
    ];
}
