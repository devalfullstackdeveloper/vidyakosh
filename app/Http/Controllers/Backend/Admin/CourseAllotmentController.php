<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Auth\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseAllotment;
use App\Models\CourseAllotmentCourse;
use App\Models\CourseAllotmentUsers;
use App\Models\CourseAllotmentDesignation;
use App\Models\Track;
use App\Models\CourseTimeline;
use App\Models\Media;
use App\Models\Ministry;
use App\Models\Departments;
use App\Models\SubCategories;
use App\Models\CourseMinistry;
use App\Models\CourseDepartment;
use DB;
use function foo\func;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCoursesRequest;
use App\Http\Requests\Admin\UpdateCoursesRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Order;

class CourseAllotmentController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Course.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // die('Hmmmmmmmm');
        if (!Gate::allows('course_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (!Gate::allows('course_delete')) {
                return abort(401);
            }
            $courses = Course::onlyTrashed()->ofTeacher()->get();
        } else {
            $courses = Course::ofTeacher()->get();
        }

        return view('backend.course-allotment.index', compact('courses'));
    }

    /**
     * Show the form for creating new Course.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('course_create')) {
            return abort(401);
        }
        $teachers = \App\Models\Auth\User::whereHas('roles', function ($q) {
            $q->where('role_id', 2);
        })->get()->pluck('name', 'id');
        $isAdmin = \Auth::user()->isAdmin() ? 'admin' : \Auth::user()->id;
		$tempdepartmentID = array();
		if((int)$isAdmin > 0) {
			$userdepts = DB::table("user_details")
					->where("user_id",$isAdmin)
					 ->select('department_id')
                    ->pluck("department_id");
			if($userdepts) {
				foreach($userdepts as $userdept) {
					$tempdepartmentID[] = $userdept;
				}
			}
		}
        $categories = Category::where('status', '=', 1)->pluck('name', 'id')->prepend('Please select', '');
        $ministry = Ministry::where('status', '=', 1)->pluck('ministry_name', 'id')->prepend('Please select', '');
		if( 0 == (int)count($tempdepartmentID))
        	$departments = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
		else {
			$departments = Departments::whereIn('id', $tempdepartmentID)->pluck('department_name', 'id')->prepend('Please select', '');
		}
		$tracks      = Track::orderBy('created_at','desc')->get();;
        $subcategories = SubCategories::where('status', '=', 1)->pluck('name', 'id')->prepend('Please select', '');
        $difficulty=DB::table('course_difficulty')->select('*')->where('status',1)->get();
        $course_type=DB::table('course_type')->select('*')->where('status',1)->get();
		$course_enrollment_type=DB::table('course_enrollment_type')->select('*')->where('status',1)->get();
 //echo "<PRE>";print_r($tracks);exit;
        return view('backend.course-allotment.create', compact('teachers', 'categories','ministry','departments','subcategories','difficulty','course_type','course_enrollment_type','tracks'));
    }

    /**
     * Store a newly created Course in storage.
     *
     * @param  \App\Http\Requests\StoreCoursesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->all();
        $courseAllotment = CourseAllotment::create($request->all());
        $insertedId = $courseAllotment->id;
        $course_type_id = array_filter((array)$request->input('course_type_id')); 
		//echo "<PRE>";print_r($course_type_id);exit;
        if( 0 < (int)count($course_type_id)) {
			foreach ($course_type_id as $key) {
				$coursetypeid = new CourseAllotmentCourse;
				$coursetypeid->course_allotment_id = $insertedId;
				$coursetypeid->course_id = $key;
				$coursetypeid->save();
			}
		}
		$dept_user_id = array_filter((array)$request->input('dept_user_id')); 
        if( 0 < (int)count($dept_user_id)) {
			foreach ($dept_user_id as $key) {
				$course_allot_user = new CourseAllotmentUsers;
				$course_allot_user->course_allotment_id = $insertedId;
				$course_allot_user->department_user_id = $key;
				$course_allot_user->save();
				/*----------------Get Now Functionality-------------------------*/
				$order = new Order();
				$order->user_id = $key;
				$order->reference_no = str_random(8);
				$order->amount = 0;
				$order->status = 1;
				$order->payment_type = 0;
				$order->save();
				$type = Course::class;
				$itemArr = array();
				if( 0 < (int)count($course_type_id)) {
					foreach ($course_type_id as $key) {
						$order->items()->create([
							'item_id'   => $key,
							'item_type' => $type,
							'price'     => 0
						]);
					}
					foreach ($order->items as $orderItem) {
						$orderItem->item->students()->attach($order->user_id);
					}
				}
				/*----------------Get Now Functionality-------------------------*/
			}
		}
		$dept_deal_id = array_filter((array)$request->input('dept_deal_id')); 
        if( 0 < (int)count($dept_deal_id)) {
			foreach ($dept_deal_id as $key) {
				$course_allot_deal = new CourseAllotmentDesignation;
				$course_allot_deal->course_allotment_id = $insertedId;
				$course_allot_deal->designation_id = $key;
				$course_allot_deal->save();
				/*-----------------------Get Now Functionality---------------------------*/
				$deptusers = DB::table("users")
					->join('user_details', 'users.id', '=', 'user_details.user_id')
					->where("user_details.designation_id",$key)
					->where("users.active",1)
					->where("users.confirmed",1)
					 ->select('users.id')
                    ->pluck("users.id");
				if($deptusers) {	
					foreach($deptusers as $user) {
					$order = new Order();
					$order->user_id = $user;
					$order->reference_no = str_random(8);
					$order->amount = 0;
					$order->status = 1;
					$order->payment_type = 0;
					$order->save();
					$type = Course::class;
					$itemArr = array();
					if( 0 < (int)count($course_type_id)) {
						foreach ($course_type_id as $key) {
							$order->items()->create([
								'item_id'   => $key,
								'item_type' => $type,
								'price'     => 0
							]);
						}
						foreach ($order->items as $orderItem) {
							$orderItem->item->students()->attach($order->user_id);
						}
					}
				}
				}
				/*-----------------------Get Now Functionality---------------------------*/
			}
		}
        return redirect()->route('admin.course_allotment.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Course.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)   
    {   
        $difficulty=DB::table('course_difficulty')->where('status',1)->pluck('name', 'id')->prepend('Please select', '');   
        $departments = Departments::where('status', '=', 1)->pluck('department_name', 'id');    
        $deptArr = array(); 
		$course_allotment = CourseAllotment::find($id);
		$deptArr[] = $course_allotment->department_id;
		//$tracks  = Track::where('department_id', '=', $course_allotment->department_id)->pluck('name', 'id');;
		$tracks = DB::table("tracks")
                    ->where("department_id",$course_allotment->department_id)
					->where("status",1)
                    ->select("name","id")
                    ->pluck('name','id');
		$trackArr = array($course_allotment->track_id);	
		$categories = DB::table("categories")
                    ->where("track_id",$course_allotment->track_id)
					->where("status",1)
                    ->select("name","id")
                    ->pluck('name','id');		
		$catArr = array($course_allotment->category_id);
		$subcategories = DB::table("sub_categories")
                    ->where("cat_id",$course_allotment->category_id)
					->where("status",1)
                    ->select("name","id")
                    ->pluck('name','id');
		$courses = DB::table("courses")
					->join('course_department', 'courses.id', '=', 'course_department.course_id')
					->where("course_department.department_id",$course_allotment->department_id)
                    ->where("courses.category_id",$course_allotment->category_id)
					->where("courses.sub_cat_id",$course_allotment->sub_cat_id)
					->where("courses.difficulty_id",$course_allotment->difficulty_id)
					->where("courses.published",1)
                    ->select("courses.title","courses.id")
                    ->pluck('courses.title','courses.id');	
		$course_type_arr = 	DB::table("course_allotment_courses")
                    ->where("course_allotment_id",$id)
                    ->select("course_id")
                    ->pluck('course_id');
		$assign_to = array('individual'=>'Individual','group'=>'Group')	;
		$designations = DB::table("designations")
					->where("department_id",$course_allotment->department_id)
					->where("status",1)
                    ->select("designation","id")
                    ->pluck('designation','id');	
		$alloted_designations = DB::table("course_allotment_designation")
					->where("course_allotment_id",$id)
                    ->select("designation_id","id")
                    ->pluck('designation_id');
		$alloted_designations_arr = array();
		foreach($alloted_designations as $alloted_designation){
			$alloted_designations_arr[] = $alloted_designation;
		}
		$deptusers = DB::table("users")
					->join('user_details', 'users.id', '=', 'user_details.user_id')
					->where("user_details.department_id",$course_allotment->department_id)
					->where("users.active",1)
					->where("users.confirmed",1)
					 ->select(DB::raw('CONCAT(users.first_name," ",users.last_name,"-",users.emp_code) AS full_name'),'users.id')
                    ->pluck("full_name","users.id");
		$alloted_deptusers = DB::table("course_allotment_users")
					->where("course_allotment_id",$id)
                    ->select("department_user_id","id")
                    ->pluck('department_user_id');			
		$alloted_dusers_arr = array();
		foreach($alloted_deptusers as $alloted_deptuser){
			$alloted_dusers_arr[] = $alloted_deptuser;
		}			
		//echo "<PRE>";print_r($alloted_dusers_arr);echo "</PRE>";exit;
        return view('backend.course-allotment.edit', compact('difficulty','deptArr','departments','course_allotment','tracks','trackArr','categories','catArr','subcategories','courses','course_type_arr','assign_to','designations','alloted_designations_arr','deptusers','alloted_dusers_arr'));   
    }

    /**
     * Update Course in storage.
     *
     * @param  \App\Http\Requests\UpdateCoursesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $course_allotment = CourseAllotment::findOrFail($id);
		//get post data
        $postData = $request->all();
	    $course_allotment->update($postData);
		$course_type_id = array_filter((array)$postData['course_type_id']); 
        if( 0 < (int)count($course_type_id)) {
			DB::table('course_allotment_courses')->where('course_allotment_id', $id)->delete();
			foreach ($course_type_id as $key) {
				$course_type_id = new CourseAllotmentCourse;
				$course_type_id->course_allotment_id = $id;
				$course_type_id->course_id = $key;
				$course_type_id->save();
			}
		}
		$dept_user_id = @array_filter((array)$postData['dept_user_id']); 
        if( 0 < (int)count($dept_user_id)) {
			DB::table('course_allotment_users')->where('course_allotment_id', $id)->delete();
			foreach ($dept_user_id as $key) {
				$course_allot_user = new CourseAllotmentUsers;
				$course_allot_user->course_allotment_id = $id;
				$course_allot_user->department_user_id = $key;
				$course_allot_user->save();
			}
		}
		$dept_deal_id = @array_filter((array)$request->input('dept_deal_id')); 
        if( 0 < (int)count($dept_deal_id)) {
			DB::table('course_allotment_designation')->where('course_allotment_id', $id)->delete();
			foreach ($dept_deal_id as $key) {
				$course_allot_deal = new CourseAllotmentDesignation;
				$course_allot_deal->course_allotment_id = $id;
				$course_allot_deal->designation_id = $key;
				$course_allot_deal->save();
			}
		}
        return redirect()->route('admin.course_allotment.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


    /**
     * Display Course.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$course_allotment = CourseAllotment::find($id);
		$departments = Departments::where('id', '=', $course_allotment->department_id)->pluck('department_name');
		$tracks = DB::table("tracks")
                    ->where("id",$course_allotment->track_id)
					->where("status",1)
                    ->select("name","id")
                    ->pluck('name','id');
		$categories = Category::where('id', '=', $course_allotment->category_id)->pluck('name', 'id');			
		
		$subcategories = DB::table("sub_categories")
                    ->where("id",$course_allotment->sub_cat_id)
					->where("status",1)
                    ->select("name","id")
                    ->pluck('name','id');
		$difficulty=DB::table('course_difficulty')->where('id',$course_allotment->difficulty_id)->pluck('name', 'id'); 			
		$course_type_arr = DB::table("course_allotment_courses")
                    ->where("course_allotment_id",$id)
                    ->select("course_id")
                    ->pluck('course_id');	
		$selectedCourses = array();				
		foreach ($course_type_arr as $carr) {
			$selectedCourses[] = $carr;
		}
		$courses = DB::table("courses")
					->whereIn('id', $selectedCourses)
                    ->select("courses.title","courses.id")
                    ->pluck('courses.title','courses.id');	
			
		$assign_to = array('individual'=>'Individual','group'=>'Group')	;
		$alloted_deptusers = DB::table("course_allotment_users")
					->where("course_allotment_id",$id)
                    ->select("department_user_id","id")
                    ->pluck('department_user_id');	
		$selecteddeptusers = array();	
		foreach($alloted_deptusers  as $uArr) {
			$selecteddeptusers[] = $uArr;
		}
		$deptusers = DB::table("users")
					->whereIn('id', $selecteddeptusers)
					 ->select(DB::raw('CONCAT(first_name," ",last_name,"-",emp_code) AS full_name'))
                    ->pluck("full_name");
		$alloted_designations = DB::table("course_allotment_designation")
					->where("course_allotment_id",$id)
                    ->select("designation_id","id")
                    ->pluck('designation_id');	
		$alloted_designations_arr = array();	
		foreach($alloted_designations as $alloted_designation){
			$alloted_designations_arr[] = $alloted_designation;
		}			
		$designations = DB::table("designations")
					->whereIn('id', $alloted_designations_arr)
                    ->select("designation")
                    ->pluck('designation');	
		//echo "<PRE>";print_r($alloted_designations_arr);echo "</PRE>";exit;				
        return view('backend.course-allotment.show', compact('difficulty','departments','course_allotment','tracks','categories','subcategories','assign_to','designations','deptusers','courses'));
    }


    /**
     * Remove Course from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course_allotment = CourseAllotment::findOrFail($id);
		$course_allotment->delete();
		DB::table('course_allotment_courses')->where('course_allotment_id', $id)->delete();
		DB::table('course_allotment_users')->where('course_allotment_id', $id)->delete();
		DB::table('course_allotment_designation')->where('course_allotment_id', $id)->delete();
        return redirect()->route('admin.course_allotment.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Course at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('course_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = CourseAllotment::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Course from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('course_delete')) {
            return abort(401);
        }
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->restore();

        return redirect()->route('admin.courses.index')->withFlashSuccess(trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Course from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('course_delete')) {
            return abort(401);
        }
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->forceDelete();

        return redirect()->route('admin.courses.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    /**
     * Permanently save Sequence from storage.
     *
     * @param  Request
     */
    public function saveSequence(Request $request)
    {
        if (!Gate::allows('course_edit')) {
            return abort(401);
        }

        foreach ($request->list as $item) {
            $courseTimeline = CourseTimeline::find($item['id']);
            $courseTimeline->sequence = $item['sequence'];
            $courseTimeline->save();
        }

        return 'success';
    }


    /**
     * Publish / Unpublish courses
     *
     * @param  Request
     */
    public function publish($id)
    {
        if (!Gate::allows('course_edit')) {
            return abort(401);
        }

        $course = Course::findOrFail($id);
        if ($course->published == 1) {
            $course->published = 0;
        } else {
            $course->published = 1;
        }
        $course->save();

        return back()->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
	
	
	////////////////////////////////////////////////////////////////////////////Filter-function-mqr


	
	
	  public function departmentFilter($id)
    {
        $departments = DB::table("departments")
                    ->where("ministry_id",$id)
					->where("status",1)
                    ->select("department_name","id")
                    ->pluck('department_name','id');
                return json_encode($departments);
    }
	
	public function trackFilter($id)
    {
        $tracks = DB::table("tracks")
                    ->where("department_id",$id)
					->where("status",1)
                    ->select("name","id")
                    ->pluck('name','id');
                return json_encode($tracks);
    }
	
	public function categoryFilter($id)
    {
        $categories = DB::table("categories")
                    ->where("track_id",$id)
					->where("status",1)
                    ->select("name","id")
                    ->pluck('name','id');
                return json_encode($categories);
    }
	
	public function courseFilter($departmentID,$trackID,$categoryID,$subcatID,$levelID)
    {
        $courses = DB::table("courses")
					->join('course_department', 'courses.id', '=', 'course_department.course_id')
					->where("course_department.department_id",$departmentID)
                    ->where("courses.category_id",$categoryID)
					->where("courses.sub_cat_id",$subcatID)
					->where("courses.difficulty_id",$levelID)
					->where("courses.published",1)
                    ->select("courses.title","courses.id")
                    ->pluck('courses.title','courses.id');
                return json_encode($courses);
    }
	
      public function subcatFilter($id)
    {
        $sub_categories = DB::table("sub_categories")
                    ->where("cat_id",$id)
					->where("status",1)
                    ->select("name","id")
                    ->pluck('name','id');
                return json_encode($sub_categories);
    }
	
	public function deptusersFilter($id) {
		 $users = DB::table("users")
					->join('user_details', 'users.id', '=', 'user_details.user_id')
					->where("user_details.department_id",$id)
					->where("users.active",1)
					->where("users.confirmed",1)
					 ->select(DB::raw('CONCAT(users.first_name," ",users.last_name,"-",users.emp_code) AS full_name'),'users.id')
                    ->pluck("full_name","users.id");
                return json_encode($users);
	}
	
	public function deptdesignationFilter($id) {
		 $users = DB::table("designations")
					->where("department_id",$id)
					->where("status",1)
                    ->select("designation","id")
                    ->pluck('designation','id');
                return json_encode($users);
	}
	
	public function getCourseAllotment(Request $request) {
		$has_view   = true;
        $has_delete = true;
        $has_edit   = true;
        $courses    = "";
		//fetch all deals data
        $courseAllotment = CourseAllotment::orderBy('created_at','desc')->get();
		$caArray         = array();
        foreach($courseAllotment as $ca) {
			$department_id = $ca->department_id;
			$track_id      = $ca->track_id;
			$category_id   = $ca->category_id;
			$dept   = DB::table('departments')->where('id', $department_id)->value('department_name');
			$track  = DB::table('tracks')->where('id', $track_id)->value('name');
			$cat    = DB::table('categories')->where('id', $category_id)->value('name');
			$caArray[$ca->id] = array("id"=>$ca->id,"department"=>$dept,"track"=>$track,"category"=>$cat);
		}
		//			echo "<PRE>";print_r($caArray);echo "<PRE>";
		//exit;
        return DataTables::of($caArray)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.courses', 'label' => 'lesson', 'value' => $q['id']]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.course_allotment.show', ['course' => $q['id']])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.course_allotment.edit', ['course' => $q['id']])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.course_allotment.destroy', ['course' => $q['id']])])
                        ->render();
                    $view .= $delete;
                }
                return $view;

            })
            ->addColumn('department', function ($q) {
                $department = '<span class="label label-info label-many">' . $q['department'] . ' </span>';
                return $department;
            })
			->addColumn('track', function ($q) {
                $track = '<span class="label label-info label-many">' . $q['track'] . ' </span>';
                return $track;
            })
            ->addColumn('category', function ($q) {
                return $q['category'];
            })
            ->rawColumns(['department', 'track', 'category', 'actions'])
            ->make();
	}
}