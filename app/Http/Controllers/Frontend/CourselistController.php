<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ministry;
use App\Models\Departments;
use App\Models\Course;
use App\Models\SubCategories;
use App\Models\Category;
use App\Models\SettingManage;
use App\Models\CourseDepartment;
use App\Models\CourseMinistry;
use DB;
 
class CourselistController extends Controller
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
        $subcatid = Course::where('sub_cat_id', $id)->first();
        if($subcatid){
        $subcategory = SubCategories::where('cat_id',$subcatid->category_id)->get();
        $category = Category::where('id',$subcatid->category_id)->get();
        $courses = Course::where('sub_cat_id', $id)->get();

        return view($this->path.'.courselist', compact('ministry','departments','category','subcategory','courses','allministry','alldepartments','logo'));
    }
    else
    {
        return "No record Available";
    }
    }

    public function subcategory($id)
    {

    	$setting = SettingManage::latest()->first();
        $ministry_id = $setting->ministry_id;
        $department_id = $setting->department_id;   
        $ministry = Ministry::where('id',$ministry_id)->where('status',1)->get();
        $allministry = Ministry::where('status',1)->get();
         $departments = Departments::where('id',$department_id)->where('status',1)->get();
        $alldepartments = Departments::where('status',1)->get();
         $category = Category::where('id',$id)->get();
         $subcategory = SubCategories::where('cat_id',$id)->get();
        $course = Course::where('sub_cat_id',$id)->get();
        return view($this->path.'.subcat_course', compact('ministry','departments','course','category','subcategory','allministry','alldepartments'));
    	
    	
    }
    public function getdepartment(Request $request)
    {
      $allministry = $request->allministry;
      $ministry = Ministry::where('ministry_name',$allministry)->first();
      $ministryid  = $ministry->id;
      $departments = Departments::where('ministry_id',$ministryid)->get();
      return $departments = json_encode($departments);
      
    }
}

