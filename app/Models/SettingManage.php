<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingManage extends Model
{
   protected $table = 'setting_management';
    protected $fillable = [
        'id','ministry_id','department_id', 'status'
    ];
}
