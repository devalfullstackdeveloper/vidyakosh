<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    protected $table = 'banners';
    protected $fillable = [
        'id','title','banner_image','status'
    ];
}
