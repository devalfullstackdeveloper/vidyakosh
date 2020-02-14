<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
        protected $fillable = [
        'id',
        'user_id',
        'ministry_id',
        'department_id',
		'office_id',
	   'designation_id',
    ];
}
