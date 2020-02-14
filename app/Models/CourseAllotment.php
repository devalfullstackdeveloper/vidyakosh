<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

/**
 * Class Course
 *
 * @package App
 * @property string $title
 * @property string $slug
 * @property text $description
 * @property decimal $price
 * @property string $course_image
 * @property string $start_date
 * @property tinyInteger $published
 */
class CourseAllotment extends Model
{

    protected $fillable = ['department_id','track_id','category_id', 'sub_cat_id','difficulty_id','course_id','assign_to','department_user_id','completion_date'];

    protected $appends = ['image'];

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setCompletionDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['completion_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['completion_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getCompletionDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }
	
	public function courseallotmentcourse()
    {
        return $this->belongsToMany(CourseAllotmentCourse::class,'course_allotment_courses');
    }
}