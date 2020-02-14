<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentsBanner extends Model
{
    protected $table = 'departments_banner';
    protected $fillable = [
        'id','department_id','banner_id','status'
    ];
}
