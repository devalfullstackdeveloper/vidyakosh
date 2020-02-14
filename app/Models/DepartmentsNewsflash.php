<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentsNewsflash extends Model
{
     protected $table = 'departments_newsflash';
    protected $fillable = [
        'id','news_id','department_id', 'status'
    ];
}
