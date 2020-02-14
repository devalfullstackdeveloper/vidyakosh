<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeorderCm extends Model
{
     protected $table = 'officeorder_content_management';
    protected $fillable = [
        'id','title','description','status'
    ];
}
