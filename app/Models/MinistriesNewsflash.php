<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinistriesNewsflash extends Model
{
     protected $table = 'ministries_newsflash';
    protected $fillable = [
        'id','news_id','ministry_id',
    ];
}
