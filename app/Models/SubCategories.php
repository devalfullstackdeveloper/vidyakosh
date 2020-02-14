<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategories extends Model
{
    protected $table = 'sub_categories'; 
    protected $fillable = [
        'id','cat_id','name','slug','short_name','moodle_subcat_ref_id','status'
    ];

    public function category()
 {
     return $this->belongsTo(Category::class);
 }

}
