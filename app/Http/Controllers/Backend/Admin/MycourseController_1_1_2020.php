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
        $completed_course=NULL;
        if (\Auth::check()) {

            $user_id=auth()->user()->id;
            $purchased_courses = auth()->user()->purchasedCourses();
            $purchased_bundles = auth()->user()->purchasedBundles();
            $pending_orders = auth()->user()->pendingOrders();

            $completed_course = \DB::table('chapter_students')->select("*")->where('user_id',$user_id)->get();
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
                $completed_course = \DB::table('chapter_students')->select("*")->where('user_id',$user_id)->whereYear('created_at',$course_year)->get();
                $purchased_courses = auth()->user()->purchasedCourses($course_year);
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
                $completed_course = \DB::table('chapter_students')->Join('courses', 'chapter_students.course_id', '=', 'courses.id')->select("chapter_students.*")->where('user_id',$user_id)->where('courses.course_type_id',$course_type)->distinct('chapter_students.id')->get();
                //print_r($completed_course);
            }
        }

        return view('backend.mycourse.index',compact('category_count','purchased_courses','students_count','recent_reviews','threads','purchased_bundles','teachers_count','courses_count','recent_orders','recent_contacts','pending_orders','ministry','departments','courses_list','course_student_count','years','earning','completed_course','in_house_purchased_courses','in_house_completed_course'));
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

            $completed_course = \DB::table('chapter_students')->select("*")->where('user_id',$user_id)->get();
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
                $completed_course = \DB::table('chapter_students')->select("*")->where('user_id',$user_id)->whereYear('created_at',$course_year)->get();
                $purchased_courses = auth()->user()->purchasedCourses($course_year);
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
                $completed_course = \DB::table('chapter_students')->Join('courses', 'chapter_students.course_id', '=', 'courses.id')->select("chapter_students.*")->where('user_id',$user_id)->where('courses.course_type_id',$course_type)->distinct('chapter_students.id')->get();
                //print_r($completed_course);
            }
        }

        return view('backend.mycourse.index',compact('category_count','purchased_courses','students_count','recent_reviews','threads','purchased_bundles','teachers_count','courses_count','recent_orders','recent_contacts','pending_orders','ministry','departments','courses_list','course_student_count','years','earning','completed_course','in_house_purchased_courses','in_house_completed_course'));
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

            $completed_course = \DB::table('chapter_students')->select("*")->where('user_id',$user_id)->get();
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
                $completed_course = \DB::table('chapter_students')->select("*")->where('user_id',$user_id)->whereYear('created_at',$course_year)->get();
                $purchased_courses = auth()->user()->purchasedCourses($course_year);
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
                $completed_course = \DB::table('chapter_students')->Join('courses', 'chapter_students.course_id', '=', 'courses.id')->select("chapter_students.*")->where('user_id',$user_id)->where('courses.course_type_id',$course_type)->distinct('chapter_students.id')->get();
                //print_r($completed_course);
            }
        }

        return view('backend.mycourse.index',compact('category_count','purchased_courses','students_count','recent_reviews','threads','purchased_bundles','teachers_count','courses_count','recent_orders','recent_contacts','pending_orders','ministry','departments','courses_list','course_student_count','years','earning','completed_course','in_house_purchased_courses','in_house_completed_course'));
    }
}
