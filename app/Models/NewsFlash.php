<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsFlash extends Model
{
     protected $table = 'news_flash';
    protected $fillable = [
        'id','title','description','start_date','end_date', 'status'
    ];
}
