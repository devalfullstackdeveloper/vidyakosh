<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Bundle;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

/**
 * Class DashboardController.
 */
class MycourseController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $purchased_courses = NULL;
        $students_count = NULL;
        $recent_reviews = NULL;
        $threads = NULL;
        $teachers_count = NULL;
        $courses_count = NULL;
        $pending_orders = NULL;
        $recent_orders = NULL;
        $recent_contacts = NULL;
        $purchased_bundles = NULL;
        $category_count = NULL;
        $departments = NULL;
        $ministry = NULL;
        $courses_list = NULL;
        $course_student_count = NULL;
        $earning = NULL;
        $years = NULL;
        $completed_course = NULL;
        if (\Auth::check()) {

            $user_id = auth()->user()->id;
            $purchased_courses = auth()->user()->purchasedCourses();
            $purchased_bundles = auth()->user()->purchasedBundles();
            $pending_orders = auth()->user()->pendingOrders();

            $completed_course = \DB::table('chapter_students')->select("course_id")->where('user_id', $user_id)->groupBy('course_id')->get();
            $course_year = Input::get('course_year');
            $course_type = Input::get('course_type');
            $start_date = Input::get('start_date');
            $end_date = Input::get('end_date');
            $orderss = Order::where('status', '=', 1)
                    ->where('user_id', '=', $user_id)
                    ->pluck('id');
            $courses_ids = OrderItem::whereIn('order_id', $orderss)
                    ->where('item_type', '=', "App\Models\Course")
                    ->pluck('item_id');

            $in_house_purchased_courses = Course::whereIn('id', $courses_ids)->where('course_type_id', '2')
                    ->get();
            $in_house_completed_course = \DB::table('chapter_students')->Join('courses', 'chapter_students.course_id', '=', 'courses.id')->select("chapter_students.*")->where('user_id', $user_id)->where('courses.course_type_id', '2')->distinct('chapter_students.id')->get();

            if (isset($course_year) && !empty($course_year)) {
                $completed_course = \DB::table('chapter_students')->select("course_id")->where('user_id', $user_id)->whereYear('created_at', $course_year)->groupBy('course_id')->get();
                $purchased_courses = auth()->user()->purchasedCoursesFilter($course_year);
            }
            if (isset($course_type) && !empty($course_type)) {
                $orders = Order::where('status', '=', 1)
                        ->where('user_id', '=', $user_id)
                        ->pluck('id');
                $courses_id = OrderItem::whereIn('order_id', $orders)
                        ->where('item_type', '=', "App\Models\Course")
                        ->pluck('item_id');
                $purchased_courses = Course::whereIn('id', $courses_id)->where('course_type_id', $course_type)
                        ->get();
                $completed_course = \DB::table('chapter_students')->Join('courses', 'chapter_students.course_id', '=', 'courses.id')->select("chapter_students.course_id")->where('user_id', $user_id)->where('courses.course_type_id', $course_type)->groupBy('chapter_students.course_id')->get();
                //print_r($completed_course);
                $courseid = array();
                foreach ($completed_course as $compcourse) {
                    $courseid[] = $compcourse->course_id;
                }
                $cmptdcourse = Course::whereIn('id', $courseid)->get();
            }
        }
        $completionArr = array();
        if ($purchased_courses) {
            foreach ($purchased_courses as $purchased_course) {
                if ($purchased_course->id) {
                    $completionArr[$purchased_course->id]['completion_days'] = 0;
                    $completionArr[$purchased_course->id]['active'] = TRUE;
                    $allotedcourses = DB::table("course_allotment_courses")
                            ->join('course_allotment_users', 'course_allotment_courses.course_allotment_id', '=', 'course_allotment_users.course_allotment_id')
                            ->join('course_allotments', 'course_allotment_courses.course_allotment_id', '=', 'course_allotments.id')
                            ->where("course_allotment_courses.course_id", $purchased_course->id)
                            ->where("course_allotment_users.department_user_id", auth()->user()->id)
                            ->select('course_allotments.completion_date')
                            ->pluck("course_allotments.completion_date");
                    if ($allotedcourses) {
                        foreach ($allotedcourses as $allotedcoursedate) {
                            $completionArr[$purchased_course->id]['completion_date'] = $allotedcoursedate;
                            $completionArr[$purchased_course->id]['completion_days'] = trim(str_replace("+", "", $this->dateDiffInDays($allotedcoursedate, date("Y-m-d"))));
                            if ($completionArr[$purchased_course->id]['completion_days'] > 0) {
                                $completionArr[$purchased_course->id]['active'] = TRUE;
                            } else {
                                $completionArr[$purchased_course->id]['active'] = FALSE;
                            }
                        }
                    }
                }
            }
        }
        $courseid = [];
        foreach ($completed_course as $compcourse) {
            $courseid[] = $compcourse->course_id;
        }
        $cmptdcourse = Course::whereIn('id', $courseid)->get();
        $level = DB::table('course_difficulty')
                ->select('id', 'name')
                ->get();
        /**********************************/
        
        if (\Auth::check()) {
            $user_id = auth()->user()->id;
            $orders = Order::where('status', '=', 1)
                        ->where('user_id', '=', $user_id)
                        ->pluck('id');
            $courses_id = OrderItem::whereIn('order_id', $orders)
                    ->where('item_type', '=', "App\Models\Course")
                    ->pluck('item_id')->toArray();
            
            $ctype = "";
            $cyear = "";
            $currentYear = date("Y");
            $totAssign = 0;
            $totCompleted = 0;
            $totInProgress = 0;
            $totYetToStart = 0;
            
            if (isset($course_year) && !empty($course_year)) {
                if ($course_year == 1) {
                        if($start_date != "" && $end_date != ""){
                            $assignCourses = Course::whereIn('id', $courses_id)
                            ->whereIn('id', $courses_id)
                            ->whereYear('created_at', '=', $currentYear)
                            ->whereDate('created_at', '>=', $start_date)
                            ->whereDate('created_at', '<=', $end_date)
                            ->get();
                        }else{
                            $assignCourses = Course::whereIn('id', $courses_id)
                            ->whereIn('id', $courses_id)
                            ->whereYear('created_at', '=', $currentYear)
                            ->get();
                        }
                } elseif ($course_year == 2) {
                        if($start_date != "" && $end_date != ""){
                            $assignCourses = Course::whereIn('id', $courses_id)
                                ->whereIn('id', $courses_id)
                                ->whereYear('created_at', '<', $currentYear)
                                ->whereDate('created_at', '>=', $start_date)
                                ->whereDate('created_at', '<=', $end_date)
                                ->get();
                        }else{
                            $assignCourses = Course::whereIn('id', $courses_id)
                                ->whereIn('id', $courses_id)
                                ->whereYear('created_at', '<', $currentYear)
                                ->get();
                        }
                } 
            } else {
                if ($start_date != "" && $end_date != "") {
                    $assignCourses = Course::whereIn('id', $courses_id)
                            ->whereIn('id', $courses_id)
                            ->whereDate('created_at', '>=', $start_date)
                            ->whereDate('created_at', '<=', $end_date)
                            ->get();
                } else {
                    $assignCourses = Course::whereIn('id', $courses_id)
                            ->whereIn('id', $courses_id)
                            ->get();
                }
            }
            
            $totAssign = count($assignCourses);
            $completionArr = array();
            $completedCourseArr = array();
            $inprogressArr = array();
            if (count($assignCourses) > 0) {
                foreach ($assignCourses as $item) {
                    /*For Completion Array*/
                    if ($item->id) {

                        $completionArr[$item->id]['completion_days'] = 0;
                        $completionArr[$item->id]['active'] = TRUE;
                        $allotedcourses = DB::table("course_allotment_courses")
                                ->join('course_allotment_users', 'course_allotment_courses.course_allotment_id', '=', 'course_allotment_users.course_allotment_id')
                                ->join('course_allotments', 'course_allotment_courses.course_allotment_id', '=', 'course_allotments.id')
                                ->where("course_allotment_courses.course_id", $item->id)
                                ->where("course_allotment_users.department_user_id", auth()->user()->id)
                                ->select('course_allotments.completion_date')
                                ->pluck("course_allotments.completion_date");
                        if ($allotedcourses) {
                            foreach ($allotedcourses as $allotedcoursedate) {
                                $completionArr[$item->id]['completion_date'] = $allotedcoursedate;
                                $completionArr[$item->id]['completion_days'] = trim(str_replace("+", "", $this->dateDiffInDays($allotedcoursedate, date("Y-m-d"))));
                                if ($completionArr[$item->id]['completion_days'] > 0) {
                                    $completionArr[$item->id]['active'] = TRUE;
                                } else {
                                    $completionArr[$item->id]['active'] = FALSE;
                                }
                            }
                        }
                    }
                    
                    $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $user_id)->get()->pluck('model_id')->toArray();

                    if (count($completed_lessons) > 0) {
                        if (count($completed_lessons) > 1 && $item->courseTimeline->count() != 0) {
                            $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                        } else {
                            $progress = 100;
                        }
                    } else {
                        $progress = 0;
                    }
                    /* isUserCertified */
                    $certifiedStatus = 0;
                    $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $user_id)->first();
                    if ($certified != null) {
                        $certifiedStatus = 1;
                    }
                    if($progress >= 100 && $certified = 1){
                        $totCompleted = $totCompleted + 1;
                        $completedCourseArr[] = $item->id;
                    }
                    if($progress > 0 && $progress < 100){
                        $totInProgress = $totInProgress + 1;
                        $inprogressArr[] = $item->id;
                    }
                    if($progress == 0){
                        $totYetToStart = $totYetToStart + 1;
                    }
                    
                }
            }
             
        }
        $cmptdcourse = Course::whereIn('id', $completedCourseArr)->get();
        $inProgCourse = Course::whereIn('id', $inprogressArr)->get();
        
        return view('backend.mycourse.index', compact('category_count', 'purchased_courses', 'assignCourses', 'students_count', 'recent_reviews', 'threads', 'purchased_bundles', 'teachers_count', 'courses_count', 'recent_orders', 'recent_contacts', 'pending_orders', 'ministry', 'departments', 'courses_list', 'course_student_count', 'years', 'earning', 'completed_course', 'in_house_purchased_courses', 'in_house_completed_course', 'completionArr', 'cmptdcourse', 'level','totAssign','totCompleted','totInProgress','totYetToStart','inProgCourse'));
    }
	
    
	public function dateDiffInDays($date1, $date2)  
	{ 
		// Creates DateTime objects 
		$datetime1 = date_create($date1); 
		$datetime2 = date_create($date2); 
		  
		// Calculates the difference between DateTime objects 
		$interval = date_diff($datetime2, $datetime1); 
        return  $interval->format('%R%a'); 
	}
	
    public function ongoingcourses()
    {
        $purchased_courses = NULL;
        $students_count = NULL;
        $recent_reviews = NULL;
        $threads = NULL;
        $teachers_count = NULL;
        $courses_count = NULL;
        $pending_orders = NULL;
        $recent_orders = NULL;
        $recent_contacts = NULL;
        $purchased_bundles = NULL;
        $category_count = NULL;
        $departments=NULL;
        $ministry=NULL;
        $courses_list=NULL;
        $course_student_count=NULL;
        $earning=NULL;
        $years=NULL;
        $completed_course=NULL;
         if (\Auth::check()) {

            $user_id=auth()->user()->id;
            $purchased_courses = auth()->user()->purchasedCourses();
            $purchased_bundles = auth()->user()->purchasedBundles();
            $pending_orders = auth()->user()->pendingOrders();

            $completed_course = \DB::table('chapter_students')->select("course_id")->where('user_id',$user_id)->groupBy('course_id')->get();
            $course_year=Input::get('course_year');
            $course_type=Input::get('course_type');
            $orderss = Order::where('status','=',1)
                    ->where('user_id','=',$user_id)
                    ->pluck('id');
             $courses_ids = OrderItem::whereIn('order_id',$orderss)
            ->where('item_type','=',"App\Models\Course")
            ->pluck('item_id');

            $in_house_purchased_courses = Course::whereIn('id',$courses_ids)->where('course_type_id','2')
                    ->get();
            $in_house_completed_course = \DB::table('chapter_students')->Join('courses', 'chapter_students.course_id', '=', 'courses.id')->select("chapter_students.*")->where('user_id',$user_id)->where('courses.course_type_id','2')->distinct('chapter_students.id')->get();

            if(isset($course_year) && !empty($course_year))
            {
                $completed_course = \DB::table('chapter_students')->select("course_id")->where('user_id',$user_id)->whereYear('created_at',$course_year)->groupBy('course_id')->get();
                $purchased_courses = auth()->user()->purchasedCoursesFilter($course_year);
               // echo '<pre>';
               //  print_r($purchased_courses);
               //  echo '</pre>';
                print_r(count($purchased_courses));
            }
            if(isset($course_type) && !empty($course_type))
            {
                $orders = Order::where('status','=',1)
                    ->where('user_id','=',$user_id)
                    ->pluck('id');
                     $courses_id = OrderItem::whereIn('order_id',$orders)
                    ->where('item_type','=',"App\Models\Course")
                    ->pluck('item_id');
                $purchased_courses = Course::whereIn('id',$courses_id)->where('course_type_id',$course_type)
                    ->get();
                $completed_course = \DB::table('chapter_students')->Join('courses', 'chapter_students.course_id', '=', 'courses.id')->select("chapter_students.course_id")->where('user_id',$user_id)->where('courses.course_type_id',$course_type)->groupBy('chapter_students.course_id')->get();
                //dd($completed_course);
            }
        }
        $completionArr = array();
        if($purchased_courses) {
            foreach($purchased_courses as $purchased_course) {
                if( $purchased_course->id ) {
                    $completionArr[$purchased_course->id]['completion_days'] = 0;
                    $completionArr[$purchased_course->id]['active']          = TRUE;
                    $allotedcourses = DB::table("course_allotment_courses")
                        ->join('course_allotment_users', 'course_allotment_courses.course_allotment_id', '=', 'course_allotment_users.course_allotment_id')
                        ->join('course_allotments', 'course_allotment_courses.course_allotment_id', '=', 'course_allotments.id')
                        ->where("course_allotment_courses.course_id",$purchased_course->id)
                        ->where("course_allotment_users.department_user_id",auth()->user()->id)
                        ->select('course_allotments.completion_date')
                        ->pluck("course_allotments.completion_date");
                    if( $allotedcourses ) { 
                        foreach($allotedcourses as $allotedcoursedate)  {
                            $completionArr[$purchased_course->id]['completion_date'] = $allotedcoursedate;
                            $completionArr[$purchased_course->id]['completion_days'] = trim(str_replace("+","",$this->dateDiffInDays($allotedcoursedate,date("Y-m-d"))));
                            if( $completionArr[$purchased_course->id]['completion_days'] > 0 ) {
                                $completionArr[$purchased_course->id]['active'] = TRUE;
                            } else {
                                $completionArr[$purchased_course->id]['active'] = FALSE;
                            }
                        }
                    }
                }
            }
        }
	 
        return view('backend.mycourse.ongoing',compact('category_count','purchased_courses','students_count','recent_reviews','threads','purchased_bundles','teachers_count','courses_count','recent_orders','recent_contacts','pending_orders','ministry','departments','courses_list','course_student_count','years','earning','completed_course','in_house_purchased_courses','in_house_completed_course','completionArr'));
    }

    public function completedcourses()
    {
        $purchased_courses = NULL;
        $students_count = NULL;
        $recent_reviews = NULL;
        $threads = NULL;
        $teachers_count = NULL;
        $courses_count = NULL;
        $pending_orders = NULL;
        $recent_orders = NULL;
        $recent_contacts = NULL;
        $purchased_bundles = NULL;
        $category_count = NULL;
        $departments=NULL;
        $ministry=NULL;
        $courses_list=NULL;
        $course_student_count=NULL;
        $earning=NULL;
        $years=NULL;
        $completed_course=NULL;
        if (\Auth::check()) {

            $user_id=auth()->user()->id;
            $purchased_courses = auth()->user()->purchasedCourses();
            $purchased_bundles = auth()->user()->purchasedBundles();
            $pending_orders = auth()->user()->pendingOrders();

            $completed_course = \DB::table('chapter_students')->select("course_id")->where('user_id',$user_id)->groupBy('course_id')->get();
            $course_year=Input::get('course_year');
            $course_type=Input::get('course_type');
            $orderss = Order::where('status','=',1)
                    ->where('user_id','=',$user_id)
                    ->pluck('id');
             $courses_ids = OrderItem::whereIn('order_id',$orderss)
            ->where('item_type','=',"App\Models\Course")
            ->pluck('item_id');

            $in_house_purchased_courses = Course::whereIn('id',$courses_ids)->where('course_type_id','2')
                    ->get();
            $in_house_completed_course = \DB::table('chapter_students')->Join('courses', 'chapter_students.course_id', '=', 'courses.id')->select("chapter_students.*")->where('user_id',$user_id)->where('courses.course_type_id','2')->distinct('chapter_students.id')->get();

            if(isset($course_year) && !empty($course_year))
            {
                $completed_course = \DB::table('chapter_students')->select("course_id")->where('user_id',$user_id)->whereYear('created_at',$course_year)->groupBy('course_id')->get();
                $purchased_courses = auth()->user()->purchasedCoursesFilter($course_year);
               // echo '<pre>';
               //  print_r($purchased_courses);
               //  echo '</pre>';
                print_r(count($purchased_courses));
            }
            if(isset($course_type) && !empty($course_type))
            {
                $orders = Order::where('status','=',1)
                    ->where('user_id','=',$user_id)
                    ->pluck('id');
                     $courses_id = OrderItem::whereIn('order_id',$orders)
                    ->where('item_type','=',"App\Models\Course")
                    ->pluck('item_id');
                $purchased_courses = Course::whereIn('id',$courses_id)->where('course_type_id',$course_type)
                    ->get();
                $completed_course = \DB::table('chapter_students')->Join('courses', 'chapter_students.course_id', '=', 'courses.id')->select("chapter_students.course_id")->where('user_id',$user_id)->where('courses.course_type_id',$course_type)->groupBy('chapter_students.course_id')->get();
                //print_r($purchased_courses);
            }
        }
        $completionArr = array();
        if($purchased_courses) {
            foreach($purchased_courses as $purchased_course) {
                if( $purchased_course->id ) {
                    $completionArr[$purchased_course->id]['completion_days'] = 0;
                    $completionArr[$purchased_course->id]['active']          = TRUE;
                    $allotedcourses = DB::table("course_allotment_courses")
                        ->join('course_allotment_users', 'course_allotment_courses.course_allotment_id', '=', 'course_allotment_users.course_allotment_id')
                        ->join('course_allotments', 'course_allotment_courses.course_allotment_id', '=', 'course_allotments.id')
                        ->where("course_allotment_courses.course_id",$purchased_course->id)
                        ->where("course_allotment_users.department_user_id",auth()->user()->id)
                        ->select('course_allotments.completion_date')
                        ->pluck("course_allotments.completion_date");
                    if( $allotedcourses ) { 
                        foreach($allotedcourses as $allotedcoursedate)  {
                            $completionArr[$purchased_course->id]['completion_date'] = $allotedcoursedate;
                            $completionArr[$purchased_course->id]['completion_days'] = trim(str_replace("+","",$this->dateDiffInDays($allotedcoursedate,date("Y-m-d"))));
                            if( $completionArr[$purchased_course->id]['completion_days'] > 0 ) {
                                $completionArr[$purchased_course->id]['active'] = TRUE;
                            } else {
                                $completionArr[$purchased_course->id]['active'] = FALSE;
                            }
                        }
                    }
                }
            }
        }

        return view('backend.mycourse.completed',compact('category_count','purchased_courses','students_count','recent_reviews','threads','purchased_bundles','teachers_count','courses_count','recent_orders','recent_contacts','pending_orders','ministry','departments','courses_list','course_student_count','years','earning','completed_course','in_house_purchased_courses','in_house_completed_course','completionArr'));
    }
    public function completeMoodle(Request $request)
    {
        $course_id = $request->input('course_id');
        $user_id = $request->input('user_id');
        $current_date_time = Carbon::now()->toDateTimeString();
        DB::table('chapter_students')->insert(
            ['user_id' => $user_id, 'course_id' => $course_id,'created_at'=>$current_date_time,'updated_at'=>$current_date_time]
        );
        return redirect('/user/mycourse');

      //  print_r($course_id);die;
    }
	
	
	//-----------------in progress course------------------------------------//
	public function inprogress(){
		$purchased_courses = NULL;
        $students_count = NULL;
        $recent_reviews = NULL;
        $threads = NULL;
        $teachers_count = NULL;
        $courses_count = NULL;
        $pending_orders = NULL;
        $recent_orders = NULL;
        $recent_contacts = NULL;
        $purchased_bundles = NULL;
        $category_count = NULL;
        $departments=NULL;
        $ministry=NULL;
        $courses_list=NULL;
        $course_student_count=NULL;
        $earning=NULL;
        $years=NULL;
        $completed_course=NULL;
         if (\Auth::check()) {

            $user_id=auth()->user()->id;
            $purchased_courses = auth()->user()->purchasedCourses();
            $purchased_bundles = auth()->user()->purchasedBundles();
            $pending_orders = auth()->user()->pendingOrders();

            $completed_course = \DB::table('chapter_students')->select("course_id")->where('user_id',$user_id)->groupBy('course_id')->get();
            $course_year=Input::get('course_year');
            $course_type=Input::get('course_type');
            $orderss = Order::where('status','=',1)
                    ->where('user_id','=',$user_id)
                    ->pluck('id');
             $courses_ids = OrderItem::whereIn('order_id',$orderss)
            ->where('item_type','=',"App\Models\Course")
            ->pluck('item_id');

            $in_house_purchased_courses = Course::whereIn('id',$courses_ids)->where('course_type_id','2')
                    ->get();
            $in_house_completed_course = \DB::table('chapter_students')->Join('courses', 'chapter_students.course_id', '=', 'courses.id')->select("chapter_students.*")->where('user_id',$user_id)->where('courses.course_type_id','2')->distinct('chapter_students.id')->get();

            if(isset($course_year) && !empty($course_year))
            {
                $completed_course = \DB::table('chapter_students')->select("course_id")->where('user_id',$user_id)->whereYear('created_at',$course_year)->groupBy('course_id')->get();
                $purchased_courses = auth()->user()->purchasedCoursesFilter($course_year);
               // echo '<pre>';
               //  print_r($purchased_courses);
               //  echo '</pre>';
                print_r(count($purchased_courses));
            }
            if(isset($course_type) && !empty($course_type))
            {
                $orders = Order::where('status','=',1)
                    ->where('user_id','=',$user_id)
                    ->pluck('id');
                     $courses_id = OrderItem::whereIn('order_id',$orders)
                    ->where('item_type','=',"App\Models\Course")
                    ->pluck('item_id');
                $purchased_courses = Course::whereIn('id',$courses_id)->where('course_type_id',$course_type)
                    ->get();
                $completed_course = \DB::table('chapter_students')->Join('courses', 'chapter_students.course_id', '=', 'courses.id')->select("chapter_students.course_id")->where('user_id',$user_id)->where('courses.course_type_id',$course_type)->groupBy('chapter_students.course_id')->get();
                //print_r($purchased_courses);
            }
        }
        $completionArr = array();
        if($purchased_courses) {
            foreach($purchased_courses as $purchased_course) {
                if( $purchased_course->id ) {
                    $completionArr[$purchased_course->id]['completion_days'] = 0;
                    $completionArr[$purchased_course->id]['active']          = TRUE;
                    $allotedcourses = DB::table("course_allotment_courses")
                        ->join('course_allotment_users', 'course_allotment_courses.course_allotment_id', '=', 'course_allotment_users.course_allotment_id')
                        ->join('course_allotments', 'course_allotment_courses.course_allotment_id', '=', 'course_allotments.id')
                        ->where("course_allotment_courses.course_id",$purchased_course->id)
                        ->where("course_allotment_users.department_user_id",auth()->user()->id)
                        ->select('course_allotments.completion_date')
                        ->pluck("course_allotments.completion_date");
                    if( $allotedcourses ) { 
                        foreach($allotedcourses as $allotedcoursedate)  {
                            $completionArr[$purchased_course->id]['completion_date'] = $allotedcoursedate;
                            $completionArr[$purchased_course->id]['completion_days'] = trim(str_replace("+","",$this->dateDiffInDays($allotedcoursedate,date("Y-m-d"))));
                            if( $completionArr[$purchased_course->id]['completion_days'] > 0 ) {
                                $completionArr[$purchased_course->id]['active'] = TRUE;
                            } else {
                                $completionArr[$purchased_course->id]['active'] = FALSE;
                            }
                        }
                    }
                }
            }
        }
		return json_encode($purchased_courses); 
	}
	
	//-----------------------------------completed course-----------------------------------------//
	public function completed()
	{
	 $purchased_courses = NULL;
        $students_count = NULL;
        $recent_reviews = NULL;
        $threads = NULL;
        $teachers_count = NULL;
        $courses_count = NULL;
        $pending_orders = NULL;
        $recent_orders = NULL;
        $recent_contacts = NULL;
        $purchased_bundles = NULL;
        $category_count = NULL;
        $departments=NULL;
        $ministry=NULL;
        $courses_list=NULL;
        $course_student_count=NULL;
        $earning=NULL;
        $years=NULL;
        $completed_course=NULL;
        if (\Auth::check()) {

            $user_id=auth()->user()->id;
            $purchased_courses = auth()->user()->purchasedCourses();
            $purchased_bundles = auth()->user()->purchasedBundles();
            $pending_orders = auth()->user()->pendingOrders();

            $completed_course = \DB::table('chapter_students')->select("course_id")->where('user_id',$user_id)->groupBy('course_id')->get();
            $course_year=Input::get('course_year');
            $course_type=Input::get('course_type');
            $orderss = Order::where('status','=',1)
                    ->where('user_id','=',$user_id)
                    ->pluck('id');
             $courses_ids = OrderItem::whereIn('order_id',$orderss)
            ->where('item_type','=',"App\Models\Course")
            ->pluck('item_id');

            $in_house_purchased_courses = Course::whereIn('id',$courses_ids)->where('course_type_id','2')
                    ->get();
            $in_house_completed_course = \DB::table('chapter_students')->Join('courses', 'chapter_students.course_id', '=', 'courses.id')->select("chapter_students.*")->where('user_id',$user_id)->where('courses.course_type_id','2')->distinct('chapter_students.id')->get();

            if(isset($course_year) && !empty($course_year))
            {
                $completed_course = \DB::table('chapter_students')->select("course_id")->where('user_id',$user_id)->whereYear('created_at',$course_year)->groupBy('course_id')->get();
                $purchased_courses = auth()->user()->purchasedCoursesFilter($course_year);
               // echo '<pre>';
               //  print_r($purchased_courses);
               //  echo '</pre>';
                print_r(count($purchased_courses));
            }
            if(isset($course_type) && !empty($course_type))
            {
                $orders = Order::where('status','=',1)
                    ->where('user_id','=',$user_id)
                    ->pluck('id');
                     $courses_id = OrderItem::whereIn('order_id',$orders)
                    ->where('item_type','=',"App\Models\Course")
                    ->pluck('item_id');
                $purchased_courses = Course::whereIn('id',$courses_id)->where('course_type_id',$course_type)
                    ->get();
                $completed_course = \DB::table('chapter_students')->Join('courses', 'chapter_students.course_id', '=', 'courses.id')->select("chapter_students.course_id")->where('user_id',$user_id)->where('courses.course_type_id',$course_type)->groupBy('chapter_students.course_id')->get();
                //print_r($purchased_courses);
            }
        }
		foreach($completed_course as $compcourse){
		$courseid[] = $compcourse->course_id;
		}
		$course = Course::whereIn('id', $courseid)->get();
		foreach($course as $coursedata)
		{
			
		}
	return json_encode($course);
	}
}
