<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
     protected $table = 'documents';
    protected $fillable = [
        'id','crt_id','agenda_date','type','description','file'
    ];
}
