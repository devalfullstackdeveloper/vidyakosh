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
                $course_student = \DB::table('categories')->leftJoin('courses', 'categories.id', '=', 'courses.category_id')->leftJoin('chapter_students', 'chapter_students.course_id', '=', 'courses.id')->select( \DB::raw("count(chapter_students.course_id) as count"))->groupBy('chapter_students.course_id')->orderBy('categories.id','ASC')->get();
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
        }

        return view('backend.mycourse.index',compact('category_count','purchased_courses','students_count','recent_reviews','threads','purchased_bundles','teachers_count','courses_count','recent_orders','recent_contacts','pending_orders','ministry','departments','courses_list','course_student_count','years','earning'));
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
                $course_student = \DB::table('categories')->leftJoin('courses', 'categories.id', '=', 'courses.category_id')->leftJoin('chapter_students', 'chapter_students.course_id', '=', 'courses.id')->select( \DB::raw("count(chapter_students.course_id) as count"))->groupBy('chapter_students.course_id')->get();
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
        }

        return view('backend.mycourse.index',compact('category_count','purchased_courses','students_count','recent_reviews','threads','purchased_bundles','teachers_count','courses_count','recent_orders','recent_contacts','pending_orders','ministry','departments','courses_list','course_student_count','years','earning'));
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
        if (\Auth::check()) {

            $purchased_courses = auth()->user()->CompletedCourses();
            $purchased_bundles = auth()->user()->purchasedBundles();
            $pending_orders = auth()->user()->pendingOrders();
            //$completed_courses = auth()->user()->CompletedCourses();
            //print_r($completed_courses);
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
                $course_student = \DB::table('categories')->leftJoin('courses', 'categories.id', '=', 'courses.category_id')->leftJoin('chapter_students', 'chapter_students.course_id', '=', 'courses.id')->select( \DB::raw("count(chapter_students.course_id) as count"))->groupBy('chapter_students.course_id')->get();
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
        }

        return view('backend.mycourse.index',compact('category_count','purchased_courses','students_count','recent_reviews','threads','purchased_bundles','teachers_count','courses_count','recent_orders','recent_contacts','pending_orders','ministry','departments','courses_list','course_student_count','years','earning'));
    }
}
