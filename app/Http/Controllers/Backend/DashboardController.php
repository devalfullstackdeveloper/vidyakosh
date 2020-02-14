<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Userdetail;
use App\Models\Bundle;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\Category;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Input;


/**
 * Class DashboardController.
 */
class DashboardController extends Controller
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
        $departments=NULL;
        $ministry=NULL;
        $courses_list=NULL;
        $course_student_count=NULL;
        $earning=NULL;
        $years=NULL;
        if (\Auth::check()) {

            $purchased_courses = auth()->user()->purchasedCourses();
            $purchased_bundles = auth()->user()->purchasedBundles();
            $pending_orders = auth()->user()->pendingOrders();

            if(auth()->user()->hasRole('teacher')){
                //IF logged in user is teacher
                $students_count = Course::whereHas('teachers', function ($query) {
                    $query->where('user_id', '=', auth()->user()->id);
                })
                    ->withCount('students')
                    ->get()
                    ->sum('students_count');


                $courses_id = auth()->user()->courses()->has('reviews')->pluck('id')->toArray();
                $recent_reviews = Review::where('reviewable_type','=','App\Models\Course')
                    ->whereIn('reviewable_id',$courses_id)
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();



                $unreadThreads = [];
                $threads = [];
                if(auth()->user()->threads){
                    foreach(auth()->user()->threads as $item){
                        if($item->unreadMessagesCount > 0){
                            $unreadThreads[] = $item;
                        }else{
                            $threads[] = $item;
                        }
                    }
                    $threads = Collection::make(array_merge($unreadThreads,$threads))->take(10) ;

                }

            }elseif(auth()->user()->hasRole('administrator')){

                $ministries_id = Input::get('ministries_id');
                $department_id = Input::get('department_id');
                $start_date = Input::get('start_date');
                $end_date = Input::get('end_date');


                $ministry = \DB::table('ministry')->select('*')->get();
                $departments = \DB::table('departments')->select('*')->get();
                $courses_lists = \DB::table('categories')->select('name')->orderBy('id','ASC')->get();
                $courses_list = $courses_lists->pluck('name');
                $course_student = \DB::table('categories')->leftJoin('courses', 'categories.id', '=', 'courses.category_id')->leftJoin('chapter_students', 'chapter_students.course_id', '=', 'courses.id')->select( \DB::raw("count(chapter_students.course_id) as count"))->groupBy('chapter_students.course_id')->groupBy('categories.id')->orderBy('categories.id','ASC')->get();
                $course_student_count = $course_student->pluck('count');

                
                //echo $course_student_count;
                $order_by_years = \DB::table('orders')->select( \DB::raw(" SUM(amount) as total_earn"), \DB::raw('YEAR(created_at) year'))->groupBy('year')->get();
                //echo '<pre>';print_r($order_by_years);echo '</pre>';
                $years = $order_by_years->pluck('year');
                $earning = $order_by_years->pluck('total_earn');
                if(isset($ministries_id) && !empty($ministries_id))
                {
                    $departments_id = \DB::table('departments')->select('id')->where('ministry_id',$ministries_id)->get();
                    $departments_id = $departments_id->pluck('id');
                    $category_count = \DB::table('categories')->whereIn('department_id', $departments_id)->count();

                    $category_data = \DB::table('categories')->select('id')->whereIn('department_id', $departments_id)->get();
                    $category_data = $category_data->pluck('id');

                     $students_count =  \DB::table('users')->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')->where('ministry_id', $ministries_id)->where('role_id', '3')->count();
                    $teachers_count =  \DB::table('users')->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')->where('ministry_id', $ministries_id)->where('role_id', '2')->count();

                    $courses_count = \App\Models\Course::all()->whereIn('category_id', $category_data)->count() + \App\Models\Bundle::all()->whereIn('category_id', $category_data)->count();

                    if(isset($start_date) && !empty($start_date) && isset($end_date) && !empty($end_date))
                    {
                        $start_date=date('Y-m-d', strtotime($start_date));
                        $end_date=date('Y-m-d', strtotime($end_date));
                        $departments_id = \DB::table('departments')->select('id')->where('ministry_id',$ministries_id)->whereBetween('created_at', [$end_date, $start_date])->get();

                        $departments_id = $departments_id->pluck('id');
                        $category_count = \DB::table('categories')->whereIn('department_id', $departments_id)->whereBetween('created_at', [$end_date, $start_date])->count();

                        $category_data = \DB::table('categories')->select('id')->whereIn('department_id', $departments_id->whereBetween('created_at', [$end_date, $start_date]))->get();
                        $category_data = $category_data->pluck('id');

                         $students_count =  \DB::table('users')->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')->where('ministry_id', $ministries_id)->where('role_id', '3')->whereBetween('users.created_at', [$end_date, $start_date])->count();
                        $teachers_count =  \DB::table('users')->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')->where('ministry_id', $ministries_id)->where('role_id', '2')->whereBetween('users.created_at', [$end_date, $start_date])->count();

                        $courses_count = \App\Models\Course::all()->whereIn('category_id', $category_data)->count() + \App\Models\Bundle::all()->whereIn('category_id', $category_data)->whereBetween('created_at', [$end_date, $start_date])->count();
                    }

                }
                elseif(isset($ministries_id) && !empty($ministries_id) && isset($department_id) && !empty($department_id))
                {
                    $departments_id = \DB::table('departments')->select('id')->where('ministry_id',$ministries_id)->get();
                    $departments_id = $departments_id->pluck('id');
                    $category_count = \DB::table('categories')->whereIn('department_id', $departments_id)->count();

                    $category_data = \DB::table('categories')->select('id')->whereIn('department_id', $departments_id)->get();
                    $category_data = $category_data->pluck('id');

                    $students_count =  \DB::table('users')->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')->where('ministry_id', $ministries_id)->where('department_id', $department_id)->where('role_id', '3')->count();
                    $teachers_count =  \DB::table('users')->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')->where('ministry_id', $ministries_id)->where('department_id', $department_id)->where('role_id', '2')->count();
                    $courses_count = \App\Models\Course::all()->whereIn('category_id', $category_data)->count() + \App\Models\Bundle::all()->whereIn('category_id', $category_data)->count();

                    if(isset($start_date) && !empty($start_date) && isset($end_date) && !empty($end_date))
                    {
                        $start_date=date('Y-m-d', strtotime($start_date));
                        $end_date=date('Y-m-d', strtotime($end_date));
                        $departments_id = \DB::table('departments')->select('id')->where('ministry_id',$ministries_id)->whereBetween('created_at', [$end_date, $start_date])->get();

                        $departments_id = $departments_id->pluck('id');
                        $category_count = \DB::table('categories')->whereIn('department_id', $departments_id)->whereBetween('created_at', [$end_date, $start_date])->count();

                        $category_data = \DB::table('categories')->select('id')->whereIn('department_id', $departments_id->whereBetween('created_at', [$end_date, $start_date]))->get();
                        $category_data = $category_data->pluck('id');

                         $students_count =  \DB::table('users')->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')->where('ministry_id', $ministries_id)->where('department_id', $department_id)->where('role_id', '3')->whereBetween('users.created_at', [$end_date, $start_date])->count();
                        $teachers_count =  \DB::table('users')->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')->where('ministry_id', $ministries_id)->where('department_id', $department_id)->where('role_id', '2')->whereBetween('users.created_at', [$end_date, $start_date])->count();

                        $courses_count = \App\Models\Course::all()->whereIn('category_id', $category_data)->count() + \App\Models\Bundle::all()->whereIn('category_id', $category_data)->whereBetween('created_at', [$end_date, $start_date])->count();
                    }

                }
                elseif(isset($department_id) && !empty($department_id))
                {
                    
                    $category_count = \DB::table('categories')->whereIn('department_id', $department_id)->count();

                    $category_data = \DB::table('categories')->select('id')->whereIn('department_id', $departments_id)->get();
                    $category_data = $category_data->pluck('id');

                    $students_count =  \DB::table('users')->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')->where('department_id', $department_id)->where('role_id', '3')->count();
                    $teachers_count =  \DB::table('users')->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')->where('department_id', $department_id)->where('role_id', '2')->count();

                    $courses_count = \App\Models\Course::all()->whereIn('category_id', $category_data)->count() + \App\Models\Bundle::all()->whereIn('category_id', $category_data)->count();

                    if(isset($start_date) && !empty($start_date) && isset($end_date) && !empty($end_date))
                    {
                        $start_date=date('Y-m-d', strtotime($start_date));
                        $end_date=date('Y-m-d', strtotime($end_date));
                        $departments_id = \DB::table('departments')->select('id')->where('ministry_id',$ministries_id)->whereBetween('created_at', [$end_date, $start_date])->get();

                        $departments_id = $departments_id->pluck('id');
                        $category_count = \DB::table('categories')->whereIn('department_id', $departments_id)->whereBetween('created_at', [$end_date, $start_date])->count();

                        $category_data = \DB::table('categories')->select('id')->whereIn('department_id', $departments_id->whereBetween('created_at', [$end_date, $start_date]))->get();
                        $category_data = $category_data->pluck('id');

                         $students_count =  \DB::table('users')->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')->where('department_id', $department_id)->where('role_id', '3')->whereBetween('users.created_at', [$end_date, $start_date])->count();
                        $teachers_count =  \DB::table('users')->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')->where('department_id', $department_id)->where('role_id', '2')->whereBetween('users.created_at', [$end_date, $start_date])->count();

                        $courses_count = \App\Models\Course::all()->whereIn('category_id', $category_data)->count() + \App\Models\Bundle::all()->whereIn('category_id', $category_data)->whereBetween('created_at', [$end_date, $start_date])->count();
                    }
                }
                else
                {
                    $students_count = User::role('student')->count();
                    $teachers_count = User::role('teacher')->count();
                    $courses_count = \App\Models\Course::all()->count() + \App\Models\Bundle::all()->count();
                    $category_count = \DB::table('categories')->count();
                }
                

                $recent_orders = Order::orderBy('created_at','desc')->take(10)->get();
                $recent_contacts = Contact::orderBy('created_at','desc')->take(10)->get();
            }
            
            $studentid = auth()->user()->id;
            $departmentid = 0;
            $designation_id =  0;
            $studentdetail  = Userdetail::where('user_id', $studentid)->first();
            if($studentdetail != ""){
            $departmentid =  $studentdetail->department_id;
            $designation_id =  $studentdetail->designation_id;  
            }
            
            
           
            /*For Office Location*/
        $officeLocation = 1;
        $stateId = 0;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id','state_id')->get();
                $officeLocation = $location[0]->parent_office_id;
                $stateId = $location[0]->state_id;
            }
        }
        
        if($officeLocation == 0){
                /* For Weeks */
            $nextweek = strtotime("+1 week -1 day"); 
                $enddate = date("Y-m-d", $nextweek);
                $trainings = DB::table("crttrainings")
                ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                ->join('locations', 'user_details.office_id', '=', 'locations.id')
                ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id')
                ->where('crttrainings.department_id', $departmentid)
//                        ->where('crttrainings.training_for', "HQ Office")
                ->whereIn('crttrainings.training_for', ["HQ Office", "All Office"])
                ->where('crt_designations.designation_id', $designation_id)
                        ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                        ->whereDate('crttrainings.start_date', '<=', $enddate)
                        ->whereNOTIn('crttrainings.id', function($query) {
                                    $query->select('crt_id')->from('tab_training_status')->where('user_id', auth()->user()->id);
                                })
                        ->get();
           
                if (count($trainings) == 0) {
                    /* For Month */
                    $nextMonth = strtotime('+1 month');
                    $enddate = date("Y-m-d", $nextMonth);
            $trainings = DB::table("crttrainings")
                        ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                    ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                    ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                    ->join('locations', 'user_details.office_id', '=', 'locations.id')
                    ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id')
                        ->where('crttrainings.department_id', $departmentid)
//                        ->where('crttrainings.training_for', "HQ Office")
                    ->whereIn('crttrainings.training_for', ["HQ Office", "All Office"])
                        ->where('crt_designations.designation_id', $designation_id)
                        ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                        ->whereDate('crttrainings.start_date', '<=', $enddate)
                            ->whereNOTIn('crttrainings.id', function($query) {
                                        $query->select('crt_id')->from('tab_training_status')->where('user_id', auth()->user()->id);
                                    })
                            ->get();

                    if (count($trainings) == 0) {
                        /* For Quarter */
                        $current_quarter = ceil(date('n') / 3);
                        $enddate = date('Y-m-t', strtotime(date('Y') . '-' . (($current_quarter * 3)) . '-1'));
                        $trainings = DB::table("crttrainings")
                        ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                        ->join('locations', 'user_details.office_id', '=', 'locations.id')
                        ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id')
                        ->where('crttrainings.department_id', $departmentid)
//                        ->where('crttrainings.training_for', "HQ Office")
                        ->whereIn('crttrainings.training_for', ["HQ Office", "All Office"])
                        ->where('crt_designations.designation_id', $designation_id)
                                ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                                ->whereDate('crttrainings.start_date', '<=', $enddate)
                                ->whereNOTIn('crttrainings.id', function($query) {
                                            $query->select('crt_id')->from('tab_training_status')->where('user_id', auth()->user()->id);
                                        })
                                ->get();
                    }
                }
            }else  {
                /* For Weeks */
                $nextweek = strtotime("+1 week -1 day");
                $enddate = date("Y-m-d", $nextweek);
                $all_trainings = DB::table("crttrainings")
                        ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                        ->join('locations', 'user_details.office_id', '=', 'locations.id')
                        ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id')
                        ->where('crttrainings.department_id', $departmentid)
                        ->where('crt_designations.designation_id', $designation_id)
                        ->where('crttrainings.training_for', "All Office")
                        ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                        ->whereDate('crttrainings.start_date', '<=', $enddate)
                        ->whereNOTIn('crttrainings.id', function($query) {
                                    $query->select('crt_id')->from('tab_training_status')->where('user_id', auth()->user()->id);
                                })
                        ->distinct()
                        ->get();
                $state_trainings = DB::table("crttrainings")
                        ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                        ->join('locations', 'user_details.office_id', '=', 'locations.id')
                        ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id')
                        ->where('crttrainings.department_id', $departmentid)
                        ->where('crt_designations.designation_id', $designation_id)
                        ->where('crttrainings.state_id', $stateId)
                        ->where('crttrainings.training_for', "State Office")
                        ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                        ->whereDate('crttrainings.start_date', '<=', $enddate)
                        ->whereNOTIn('crttrainings.id', function($query) {
                                    $query->select('crt_id')->from('tab_training_status')->where('user_id', auth()->user()->id);
                                })
                        ->distinct()
                        ->get();
                           
                $trainings = collect(array_merge($all_trainings->toArray(), $state_trainings->toArray()));
                if (count($trainings) == 0) {
                    /* For Month */
                $nextMonth = strtotime('+1 month');
                    $enddate = date("Y-m-d", $nextMonth);
                    $all_trainings = DB::table("crttrainings")
                        ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                            ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                            ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                            ->join('locations', 'user_details.office_id', '=', 'locations.id')
                            ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id')
                        ->where('crttrainings.department_id', $departmentid)
                        ->where('crt_designations.designation_id', $designation_id)
                            ->where('crttrainings.training_for', "All Office")
                        ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                        ->whereDate('crttrainings.start_date', '<=', $enddate)
                            ->whereNOTIn('crttrainings.id', function($query) {
                                        $query->select('crt_id')->from('tab_training_status')->where('user_id', auth()->user()->id);
                                    })
                        ->distinct()
                        ->get();
                    $state_trainings = DB::table("crttrainings")
                            ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                            ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                            ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                            ->join('locations', 'user_details.office_id', '=', 'locations.id')
                            ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id')
                            ->where('crttrainings.department_id', $departmentid)
                            ->where('crt_designations.designation_id', $designation_id)
                            ->where('crttrainings.state_id', $stateId)
                            ->where('crttrainings.training_for', "State Office")
                            ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                            ->whereDate('crttrainings.start_date', '<=', $enddate)
                            ->whereNOTIn('crttrainings.id', function($query) {
                                        $query->select('crt_id')->from('tab_training_status')->where('user_id', auth()->user()->id);
                                    })
                            ->distinct()
                            ->get();

                    $trainings = collect(array_merge($all_trainings->toArray(), $state_trainings->toArray()));
                    if (count($trainings) == 0) {
                        /* For Quarter */
                    $current_quarter = ceil(date('n') / 3);
                    $enddate = date('Y-m-t', strtotime(date('Y') . '-' . (($current_quarter * 3)) . '-1'));
                        $all_trainings = DB::table("crttrainings")
                        ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                                ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                                ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                                ->join('locations', 'user_details.office_id', '=', 'locations.id')
                                ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id')
                        ->where('crttrainings.department_id', $departmentid)
                        ->where('crt_designations.designation_id', $designation_id)
                                ->where('crttrainings.training_for', "All Office")
                        ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                        ->whereDate('crttrainings.start_date', '<=', $enddate)
                                ->whereNOTIn('crttrainings.id', function($query) {
                                            $query->select('crt_id')->from('tab_training_status')->where('user_id', auth()->user()->id);
                                    })
                        ->distinct()
                        ->get();
                        $state_trainings = DB::table("crttrainings")
                                ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                                ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                                ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                                ->join('locations', 'user_details.office_id', '=', 'locations.id')
                                ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id')
                                ->where('crttrainings.department_id', $departmentid)
                                ->where('crt_designations.designation_id', $designation_id)
                                ->where('crttrainings.state_id', $stateId)
                                ->where('crttrainings.training_for', "State Office")
                                ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                                ->whereDate('crttrainings.start_date', '<=', $enddate)
                                ->whereNOTIn('crttrainings.id', function($query) {
                                            $query->select('crt_id')->from('tab_training_status')->where('user_id', auth()->user()->id);
                                        })
                                ->distinct()
                                ->get();
                            
                        $trainings = collect(array_merge($all_trainings->toArray(), $state_trainings->toArray()));
                }           
            }
            }
            $trainingArr = array();
            $cnt = 0;
            foreach ($trainings as $key => $value) {
                $trArr = array();
                $trArr['id'] = $value->id;
                $trArr['title'] = $value->title;
                $trArr['start_date'] = $value->start_date;
                $trArr['end_date'] = $value->end_date;
                $trArr['lastnominne'] = $value->lastnominne;
                $trArr['address'] = $value->address;
                if($value->parent_office_id == 0){
                    $trArr['parent_office_id'] = "Head Office";
                }else{
                    $trArr['parent_office_id'] = "State Office";
                }
                $trainingArr[$cnt] = (object) $trArr;
                $cnt++;
            }
            $trainings = collect($trainingArr);
                            
        } 
        return view('backend.dashboard',compact('category_count','purchased_courses','students_count','recent_reviews','threads','purchased_bundles','teachers_count','courses_count','recent_orders','recent_contacts','pending_orders','ministry','departments','courses_list','course_student_count','years','earning','trainings'));
    }
	
    public function loginUserDesignation($id){
        
        $designationArr = array();
        $userDetails =  DB::table("user_details")->where('user_id',$id)->select("designation_id","organisationaldept_role")->get();
        $getChilds =  DB::select("SELECT GROUP_CONCAT(lv SEPARATOR ',') FROM (
                                    SELECT @pv:=(SELECT GROUP_CONCAT(id SEPARATOR ',') FROM designations WHERE parent_designation_id IN (@pv)) AS lv FROM designations
                                    JOIN
                                    (SELECT @pv:=".$userDetails[0]->designation_id.")tmp
                                    WHERE parent_designation_id IN (@pv)) a; 
                                    ");
        foreach ($getChilds[0] as $key => $value) {
            $childs = explode(",", $value);
            foreach ($childs as $childKey => $childVal) {
                $designation = DB::table("designations")->where('id',$childVal)->select("id","designation")->get();
                $designationArr[$designation[0]->id] = $designation[0]->designation;
            }
        }
        
        $deptRoleArr = array();
        $dept_role = DB::table("department_role")->where('parent_id',$userDetails[0]->organisationaldept_role)->select("id","role_name")->get();
        
        foreach ($dept_role as $DrKey => $DrVal) {
            
            $deptRoleArr[$DrVal->id] = $DrVal->role_name;
            $deptRoleChild =  DB::select("SELECT GROUP_CONCAT(lv SEPARATOR ',') FROM (
                                    SELECT @pv:=(SELECT GROUP_CONCAT(id SEPARATOR ',') FROM department_role WHERE parent_id IN (@pv)) AS lv FROM department_role
                                    JOIN
                                    (SELECT @pv:=".$DrVal->id.")tmp
                                    WHERE parent_id IN (@pv)) a;");
            
            foreach ($deptRoleChild[0] as $DrcKey => $DrcVal) {
                $DRchilds = explode(",", $DrcVal);
                foreach ($DRchilds as $DRchildKey => $DRchildVal) {
                    $deptRole = DB::table("department_role")->where('id',$DRchildVal)->select("id","role_name")->get();
                    if(!in_array($deptRole[0]->id, $deptRoleArr)){
                        $deptRoleArr[$deptRole[0]->id] = $deptRole[0]->role_name;
                    }
                }
            }
           
        }
        $returnArr = array();
        $returnArr['designation'] = $designationArr;
        $returnArr['department_role'] = $deptRoleArr;
        
        return json_encode($returnArr);
        
    }
    
    public function loginUsertabs($id){
        
        $userDetails =  DB::table("user_details")->where('user_id',$id)->select("department_id")->get();
        
        $trainings = DB::table("crttrainings")->where('department_id',$userDetails[0]->department_id)->count();
        
        $institutes = DB::table("institute_industry")->where('department_id',$userDetails[0]->department_id)->where('type_id',1)->count();
        
        $industries = DB::table("institute_industry")->where('department_id',$userDetails[0]->department_id)->where('type_id',2)->count();
        
        $instituteFaculties = DB::table("faculty")->where('department_id',$userDetails[0]->department_id)->where('institute_industry_id',1)->count();
        
        $industrieFaculties = DB::table("faculty")->where('department_id',$userDetails[0]->department_id)->where('institute_industry_id',2)->count();
        
        $getInnerUsers = DB::table("user_details")->where('reportingmanager_id',$id)->select("user_id")->get();
        
        $userArr = array($id);
        
        if(count($getInnerUsers) > 0){
            foreach ($getInnerUsers as $key => $value) {
                array_push($userArr,$value->user_id);
            }
        }
//        $completed_course = DB::select('select count(*) AS completedCources FROM chapter_students WHERE user_id IN ('.implode(",",$userArr).')');
        $completed_course = DB::select('select count(*) AS completedCources FROM orders WHERE user_id IN ('.implode(",",$userArr).') AND status=1');
        
        $course_inprogress = DB::select('select count(*) AS course_inprogress FROM orders WHERE user_id IN ('.implode(",",$userArr).') AND status=0');
        
        $getcources = DB::select('select o.id, oi.item_id, c.course_type_id, o.status, c.id AS courseId, c.category_id FROM orders AS o 
                                        JOIN order_items AS oi ON (o.id = oi.order_id)
                                        JOIN courses AS c ON (oi.item_id = c.id)WHERE o.user_id IN ('.implode(",",$userArr).')');
        
        $inhouseCount = 0;
        $inhouseCountCompleted = 0;
		$categoryArr = array();
        foreach ($getcources as $gckey => $gcvalue) {
            if($gcvalue->course_type_id == 2){
                $inhouseCount = $inhouseCount + $gcvalue->course_type_id;
            }
            if($gcvalue->course_type_id == 2 && $gcvalue->status == 1){
                $inhouseCountCompleted = $inhouseCount + $gcvalue->course_type_id;
            }
             $category = DB::table("categories")->where('id',$gcvalue->category_id)->select("short_name")->get();
            $categoryArr[] = $category[0]->short_name;
        }
        
        $crtAttended = DB::select('SELECT count(*) AS totCrtAttended FROM users AS u JOIN tab_training_status AS tts ON (tts.user_id = u.id) WHERE tts.status = 1 AND u.id IN('.implode(",",$userArr).')');
        
        $getRating = DB::select('select rating FROM course_student WHERE user_id IN ('.implode(",",$userArr).')');
        
        $yetToStartCount = 0;
        foreach ($getRating as $ratingkey => $ratingval) {
            if($ratingval->rating > 0 && $ratingval->rating <= 99){
                $yetToStartCount = $yetToStartCount + 1;
            }
        }
		/*Charts*/
        $crtTrainingCharts = DB::table("crttrainings")
                                ->join("states", 'crttrainings.state_id', '=', 'states.id')
                                ->where('department_id',$userDetails[0]->department_id)
                                ->select('crttrainings.id','states.state')
                                ->get();
        $crtChartArr = array();
        foreach ($crtTrainingCharts as $crtChartkey => $crtChartval) {
            $crtChartArr[] = $crtChartval->state;
        }
        /*Dashboard Chart*/
        $crt_chart_arr = array();
        $seminar_chart_arr = array();
        $executiveBriefing_chart_arr = array();
        $eLearning_chart_arr = array();
        $category = DB::table('categories')->where('status', 1)->select('short_name','id', 'name')->get();
        foreach ($category as $catKey => $catVal) {
            $seminarCnt = 0;
            $executiveBriefingCnt = 0;
            $attendedCrt = 0;
            $eLearning = 0;

            $crts = DB::table('tab_training_status')
                            ->join('crttrainings', 'tab_training_status.crt_id', 'crttrainings.id')
                            ->where('tab_training_status.status', 1)
                            ->where('tab_training_status.user_id', $id)
                            ->where('crttrainings.category_id', $catVal->id)
                            ->select('training_type')->get();

            foreach ($crts as $ck => $crtvalue) {
                /* Seminar Count */
                if ($crtvalue->training_type == 5) {
                    $seminarCnt = $seminarCnt + 1;
                }
                /* Executive Briefing Count */
                if ($crtvalue->training_type == 3) {
                    $executiveBriefingCnt = $executiveBriefingCnt + 1;
                }
                /* CRT Training Count */
                if ($crtvalue->training_type == 6) {
                    $attendedCrt = $executiveBriefingCnt + 1;
                }
            }
            
            /* For E-Learning */
            $orders = Order::where('status', '=', 1)
                    ->where('user_id', $id)
                    ->pluck('id');

            $courses_id = OrderItem::whereIn('order_id', $orders)
                    ->where('item_type', '=', "App\Models\Course")
                    ->pluck('item_id');

            $purchased_courses = Course::whereIn('id', $courses_id)->where('category_id', $catVal->id)->get();
            if (count($purchased_courses) > 0) {
                foreach ($purchased_courses as $item) {
                    /* For Course Progress */
                    $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $id)->get()->pluck('model_id')->toArray();

                    if (count($completed_lessons) > 0) {
                        if (count($completed_lessons) > 1) {
                            $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                        } else {
                            $progress = 100;
                        }
                    } else {
                        $progress = 0;
                    }
                    /* isUserCertified */
                    $certifiedStatus = 0;
                    $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $id)->first();
                    if ($certified != null) {
                        $certifiedStatus = 1;
                    }
                    if ($progress == 100 && $certifiedStatus == 1) {
                        $eLearning = $eLearning + 1;
                    }
                }
            }
            if ($catVal->short_name != "") {
                $crt_chart_arr[$catVal->short_name]['cat_id'] = $catVal->id;
                $crt_chart_arr[$catVal->short_name]['count'] = $attendedCrt;
                $seminar_chart_arr[$catVal->short_name]['cat_id'] = $catVal->id;
                $seminar_chart_arr[$catVal->short_name]['count'] = $seminarCnt;
                $executiveBriefing_chart_arr[$catVal->short_name]['cat_id'] = $catVal->id;
                $executiveBriefing_chart_arr[$catVal->short_name]['count'] = $executiveBriefingCnt;
                $eLearning_chart_arr[$catVal->short_name]['cat_id'] = $catVal->id;
                $eLearning_chart_arr[$catVal->short_name]['count'] = $eLearning;
            } else {
                $crt_chart_arr[$catVal->name]['cat_id'] = $catVal->id;
                $crt_chart_arr[$catVal->name]['count'] = $attendedCrt;
                $seminar_chart_arr[$catVal->name]['cat_id'] = $catVal->id;
                $seminar_chart_arr[$catVal->name]['count'] = $seminarCnt;
                $executiveBriefing_chart_arr[$catVal->name]['cat_id'] = $catVal->id;
                $executiveBriefing_chart_arr[$catVal->name]['count'] = $executiveBriefingCnt;
//                $eLearning_chart_arr[$catVal->name] = $eLearning;
                $eLearning_chart_arr[$catVal->name]['cat_id'] = $catVal->id;
                $eLearning_chart_arr[$catVal->name]['count'] = $eLearning;
            }
        }
        
        $tabsArr = array();
        $tabsArr['trainings'] = $trainings;
        $tabsArr['institutes'] = $institutes;
        $tabsArr['industries'] = $industries;
        $tabsArr['instituteFaculties'] = $instituteFaculties;
        $tabsArr['industrieFaculties'] = $industrieFaculties;
        $tabsArr['completed_cources'] = $completed_course[0]->completedCources;
        $tabsArr['course_inprogress'] = $course_inprogress[0]->course_inprogress;
        $tabsArr['course_yet_to_start'] = $yetToStartCount;
        $tabsArr['in_house_courses_accepted'] = $inhouseCount;
        $tabsArr['in_house_courses_completed'] = $inhouseCountCompleted;
        $tabsArr['total_assigned_cources'] = count($getcources);
        $tabsArr['crt_attended'] = $crtAttended[0]->totCrtAttended;
//		$tabsArr['crt_chart'] = json_encode(array_count_values($crtChartArr), TRUE);
        $tabsArr['crt_chart'] = json_encode($crt_chart_arr, TRUE);
        $tabsArr['seminar_chart'] = json_encode($seminar_chart_arr, TRUE);
        $tabsArr['executiveBriefing_chart'] = json_encode($executiveBriefing_chart_arr, TRUE);
        $tabsArr['eLearning_chart'] = json_encode($eLearning_chart_arr, TRUE);
//        $tabsArr['eLearning_chart'] = json_encode(array_count_values($categoryArr), TRUE);
        return json_encode($tabsArr);
        
    }
    
    public function crtDetails($param){
        $params = explode(",", $param);
        $uid = $params[0];
        $catId = $params[1];
        $chart = $params[2];
        $returnArr = array();
        if($chart == "e_learning"){
            /* For E-Learning */
            $orders = Order::where('status', '=', 1)
                    ->where('user_id', $uid)
                    ->pluck('id');

            $courses_id = OrderItem::whereIn('order_id', $orders)
                    ->where('item_type', '=', "App\Models\Course")
                    ->pluck('item_id');

            $purchased_courses = Course::whereIn('id', $courses_id)->where('category_id', $catId)->get();
            if (count($purchased_courses) > 0) {
                foreach ($purchased_courses as $item) {
                    /* For Course Progress */
                    $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $uid)->get()->pluck('model_id')->toArray();

                    if (count($completed_lessons) > 0) {
                        if (count($completed_lessons) > 1) {
                            $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                        } else {
                            $progress = 100;
                        }
                    } else {
                        $progress = 0;
                    }
                    /* isUserCertified */
                    $certifiedStatus = 0;
                    $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $uid)->first();
                    if ($certified != null) {
                        $certifiedStatus = 1;
                    }
                    if ($progress == 100 && $certifiedStatus == 1) {
                        $elArr = array();
                        $elArr['name'] = $item->title;
                        $returnArr[] = $elArr;
                    }
                }
            }
        }elseif($chart == "crt_training"){
            $crts = DB::table('tab_training_status')
                            ->join('crttrainings', 'tab_training_status.crt_id', 'crttrainings.id')
                            ->join('venues', 'crttrainings.venue_id', 'venues.id')
                            ->where('tab_training_status.status', 1)
                            ->where('tab_training_status.user_id', $uid)
                            ->where('crttrainings.category_id', $catId)
                            ->where('crttrainings.training_type', 6)
                            ->select('crttrainings.title','crttrainings.start_date','crttrainings.end_date','venues.address')->get();
        }elseif($chart == "seminar"){
            $crts = DB::table('tab_training_status')
                            ->join('crttrainings', 'tab_training_status.crt_id', 'crttrainings.id')
                            ->join('venues', 'crttrainings.venue_id', 'venues.id')
                            ->where('tab_training_status.status', 1)
                            ->where('tab_training_status.user_id', $uid)
                            ->where('crttrainings.category_id', $catId)
                            ->where('crttrainings.training_type', 5)
                            ->select('crttrainings.title','crttrainings.start_date','crttrainings.end_date','venues.address')->get();
        }elseif($chart == "executing_briefing"){
            $crts = DB::table('tab_training_status')
                            ->join('crttrainings', 'tab_training_status.crt_id', 'crttrainings.id')
                            ->join('venues', 'crttrainings.venue_id', 'venues.id')
                            ->where('tab_training_status.status', 1)
                            ->where('tab_training_status.user_id', $uid)
                            ->where('crttrainings.category_id', $catId)
                            ->where('crttrainings.training_type', 3)
                            ->select('crttrainings.title','crttrainings.start_date','crttrainings.end_date','venues.address')->get();
        }
        
        if($chart == "e_learning"){
            return json_encode($returnArr);
        }else{
            foreach ($crts as $ck => $crtvalue) {
                $crtArr = array();
                $crtArr['name'] = $crtvalue->title;
                $crtArr['duration'] = $crtvalue->start_date." - ".$crtvalue->end_date;
                $crtArr['venue'] = $crtvalue->address;
                $returnArr[] = $crtArr;
            }
            return json_encode($returnArr);
        }
        
    }
}
