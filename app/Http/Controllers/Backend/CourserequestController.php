<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\SubCategories;
use App\Models\Category;
use App\Http\Requests\Admin\StoreRequestCourse;


class CourserequestController extends Controller
{
    public function __construct()
    {

        $path = 'frontend';
        if (session()->has('display_type')) {
            if (session('display_type') == 'rtl') {
                $path = 'frontend-rtl';
            } else {
                $path = 'frontend';
            }
        } else if (config('app.display_type') == 'rtl') {
            $path = 'frontend-rtl';
        }
        $this->path = $path;
    }

    /**
     * Get certificates lost for purchased courses.
     */
    public function getcourserequest()
    {     
           $id = auth()->user()->id; 
           $getcourserequest = DB::table('users')
           ->join('user_details','users.id','=','user_details.user_id')
           ->join('locations','user_details.office_id','=','locations.id')
           ->join('states','locations.state_id','=','states.id')
           ->join('cities','states.id','=','cities.state_id')
           ->join('designations','user_details.designation_id','=','designations.id')
           ->where('users.id','=',$id)
           ->select('users.id','users.email',DB::raw('CONCAT(first_name, " ", last_name) AS full_name'),'designations.designation','states.state','cities.city','users.phone')
           ->first();
           $department_id = 0;

            $userdetail  = DB::table('user_details')->where('user_id', auth()->user()->id)->first();
            $resourcetrack = DB::table('tracks')->where('status', '=', '1')->where('department_id', '=', $userdetail->department_id)->pluck('name', 'id')->prepend('Please select', '');

           $categories = Category::where('status', '=', 1)->pluck('name', 'id')->prepend('Please select', '');
           $subcategories = SubCategories::where('status', '=', 1)->pluck('name', 'id')->prepend('Please select', '');
           $courses = Course::where('course_enrollment_type_id','=',2)->pluck('title', 'id')->prepend('Please select', '');

          return view('backend.courserequest.index',compact('getcourserequest','categories','subcategories','courses', 'resourcetrack'));
    }

    public function store(StoreRequestCourse $request)
    {
        $id = auth()->user()->id;
        $phone = $request->phone;
        $track_id =  $request->track_id;
         $category_id =  $request->category_id;
         $subcategory_id =  $request->subcategory_id;
        $coursesid =  $request->courses_id;
        DB::table('courserequest')->insert(
         ['userid' => $id, 'phone' => $phone,'track_id' => $track_id,'categoryid' => $category_id,'subcategory' => $subcategory_id,'coursesid' => $coursesid,'status' =>0]);
        return redirect()->route('admin.courserequest.index')->withFlashSuccess(trans('alerts.backend.general.created'));

    }

    ///////////////////////////////////////////////////////////
    public function categoryFilter($id)
    {
        $resourcetrack = DB::table('categories')->where('status', '=', '1')->where('track_id', '=', $id)->pluck('name', 'id')->prepend('Please Select', '');
        return json_encode($resourcetrack);
    }

    public function subcategoryFilter($id)
    {
        $subcat = DB::table('sub_categories')->where('status', '=', '1')->where('cat_id', '=', $id)->pluck('name', 'id')->prepend('Please Select', '');
        return json_encode($subcat);
    }

    public function coursesFilter($id)
    {
        $cources = DB::table('courses')->where('sub_cat_id', '=', $id)->where('course_enrollment_type_id', '=', 2)->pluck('title', 'id')->prepend('Please Select', '');
        return json_encode($cources);
    }


   
}
