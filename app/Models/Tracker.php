<?php
   namespace App\Models;

use App\Models\Departments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

    class Tracker extends Model  {
	
		
    public $attributes = ['hits' => 0];
    protected $fillable = ['ip','date'];
    protected $table = 'visitor_count';

    public static function boot() {
        // Any time the instance is updated (but not created)
        static::saving( function ($tracker) {
            $tracker->visit_time = date('H:i:s');
            $tracker->hits++;
        } );
    }

    public static function hit() {
        static::firstOrCreate([
                  'ip'   => $_SERVER['REMOTE_ADDR'],
                  'date' => date('Y-m-d'),
              ])->save();
    }
		

}