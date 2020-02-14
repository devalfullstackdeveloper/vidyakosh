<?php

namespace App\Models;
use App\Models\Auth\User;

use Illuminate\Database\Eloquent\Model;

class Userdetail extends Model
{
     protected $table = 'user_details';
    protected $fillable = [
        'id','user_id','ministry_id', 'department_id','office_id','designation_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
