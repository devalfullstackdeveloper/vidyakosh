<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseDepartment extends Model
{
     protected $table = 'course_department';
    protected $fillable = [
        'id','course_id','department_id',
    ];

    public function Course(){
        return $this->hasMany(Course::class);
    }


    public function Category()
 {
     return $this->hasMany(Category::class);
 }

  
}
