<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    protected $table = 'locations';
    protected $fillable = [
        'id',
		'ministry_id',
		'department_id',
		'parent_office_id',
		'state_id',
		'city_id',
		'office_name',
		'address',
		'status',
		'contact',
		'email'
    ];

  /*public function departments()
    {
        return $this->belongsTo(Departments::class);
    }	
	*/
	
}
