<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ministry;
use App\Models\Departments;
use App\Models\Course;
use App\Models\Category;
use App\Models\SubCategories;
use App\Models\SettingManage;
use App\Models\CourseDepartment;
use App\Models\CourseMinistry;

class CoursedetailController extends Controller
{
     private $path;
 
    public function __construct()
    {
        $path = 'frontend';
        if(session()->has('display_type')){
            if(session('display_type') == 'rtl'){
                $path = 'frontend-rtl';
            }else{
                $path = 'frontend';
            }
        }else if(config('app.display_type') == 'rtl'){
            $path = 'frontend-rtl';
        }
        $this->path = $path;
    }


    public function index($id) 
    {
        $department_id = session('department_id');
        if(isset($department_id))
        {
            $department_id = session('department_id');
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
              $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            $departments = Departments::where('id',$department_id)->where('status',1)->get();  
            $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get(); 
        }
        else{
        $setting = SettingManage::latest()->first();
        $ministry_id = $setting->ministry_id;
        $department_id = $setting->department_id;
          $logo = $setting->logo;   
        $ministry = Ministry::where('id',$ministry_id)->where('status',1)->get();
        $allministry = Ministry::where('status',1)->get();
        $departments = Departments::where('id',$department_id)->where('status',1)->get();
        $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
        }
        $course = Course::where('id',$id)->get();
        //dd($course);
        foreach ($course as $coursedata) {
            $category = Category::where('id',$coursedata->category_id)->get();
        }

       foreach ($category as $categorydata) {
          $subcategory = SubCategories::where('cat_id',$categorydata->id)->get(); 
       }

     // $subcategory = SubCategories::where('id',$id)->get();
        // print_r($subcategory);
        //  die;
        return view($this->path.'.coursedetail', compact('ministry','departments','category','subcategory','course','allministry','alldepartments','logo'));
    }
}
 