<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Blog;
use App\Models\Bundle;
use App\Models\Config;
use App\Models\Course;
use App\Models\CourseTimeline;
use App\Models\Faq;
use App\Models\Lesson;
use App\Models\Page;
use App\Models\Reason;
use App\Models\Sponsor;
use App\Models\System\Session;
use App\Models\Tag;
use App\Models\Ministry; 
use App\Models\Departments;
use App\Models\NewsFlash;
use App\Models\Category;
use App\Models\SubCategories;
use App\Models\Testimonial;
use App\Models\Crttraining;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Newsletter;
use DB;
use App\Models\SettingManage;
use App\Models\CourseDepartment;
use App\Models\CourseMinistry;
use Cookie;
use Auth; 
use App\Models\DepartmentCategories;
use Carbon\Carbon;
use App\Models\Track;
use App\Models\Designations;
use Mail;
use App\Models\Tracker;





/**
 * Class HomeController.
 */ 
class HomeController extends Controller
{
	
    /**
     * @return \Illuminate\View\View
     */

    private $path;

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

   public function getdptname(Request $request)
   {
     $department = $request->department;
     $departmentdata  = Departments::where('department_name',$department)->where('status',1)->first();
     $department_id = $departmentdata->id;
     $request->session()->put('department_id', $department_id);

   }
    public function index(Request $request)
    { 
	
        if (request('page')) {
            $page = Page::where('slug', '=', request('page'))
                ->where('published', '=', 1)->first();
            if ($page != "") {
                return view($this->path . '.pages.index', compact('page'));
            }
            abort(404);
        }
	    
        $rating = DB::table('reviews')
               ->select('reviewable_id', DB::raw('AVG(rating) as rating'))
                ->groupBy('reviewable_id')->get();
        $enroll = DB::table('course_student')
               ->select('course_id', DB::raw('count(user_id) as totalstudent'))
                ->groupBy('course_id')->get();
        $department_id = '0';
        $newsflash = array();
        $news = array();
        $items = array();
        $SubCategories = array();
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();
            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }
        if($department_id == 0){
            $department_id = $request->session()->get('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $request->session()->put('department_id', $department_id);
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
            $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get(); 
            $departments = Departments::where('id',$department_id)->where('status',1)->first(); 
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            $request->session()->put('department_id', $department_id);
            $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
            $departments = Departments::where('id',$department_id)->where('status',1)->first();
        }
        $news1 = DB::table('crttrainings')
            ->select('crttrainings.title','crttrainings.start_date','crttrainings.end_date')
			->where('status',1)
            ->where('crttrainings.start_date', '<=', Carbon::now())
            ->where('crttrainings.end_date', '>=', Carbon::now())
            ->where('crttrainings.department_id', $department_id);
        $news = DB::table('departments_newsflash')
            ->select('departments_newsflash.*')
            ->where('departments_newsflash.department_id', $department_id)
            ->get();
		$news_data = array();
            foreach ($news as $newsdata) {
		$news_data[] = $newsdata->news_id;
            }
		$news = NewsFlash::select('title','start_date','end_date')->whereIn('id', $news_data)->where('status',1)->where('start_date','<=', Carbon::now())->where('end_date','>=', Carbon::now())->union($news1)->orderBy('start_date','asc')->get();
	        $newsflash = array($news);   
        $banner = DB::table('banners')
            ->join('departments_banner', 'departments_banner.banner_id', '=', 'banners.id')
            ->select('banners.*')
		
            ->where('departments_banner.department_id', $department_id)
			->where('banners.status',1)
            ->first();
           $trendingcourse = Course::
          join('course_department', 'courses.id', '=', 'course_department.course_id')
		   ->join('order_items','order_items.item_id','=','courses.id')
           ->where('course_department.department_id',$department_id)
			   ->where('published', 1)->where('trending', 1)
											->paginate(10);
		 
		/*
		$trendingcourse = Course::select(DB::raw('count(order_items.item_id)  countorder','order_items.item_id','order_items.item_id'))
           ->join('course_department', 'courses.id', '=', 'course_department.course_id')
		   ->join('order_items','order_items.item_id','=','courses.id')
           ->where('course_department.department_id',$department_id)
			   ->where('published', 1)->where('trending', 1)
											->groupBy('order_items.item_id')
											->paginate(10);
		*/
		
	 		$lessons = DB::table('lessons')
                     ->select(DB::raw('count(*) as lessoncount, course_id'))
                     ->groupBy('course_id')
                     ->get();
	
		
		
	   /* $trendingcourse = DB::table('courses')
            ->join('course_department', 'course_department.course_id', '=', 'courses.id')
            ->join('categories', 'categories.id', '=', 'courses.category_id')
			->join('order_items', 'courses.id', '=', 'order_items.item_id')
            ->select('courses.*','categories.name', DB::raw('count(order_items.item_id) as count_order','order_items.item_id'))
            ->where('course_department.department_id', $department_id)
            ->where('courses.published', 1)
            ->where('courses.trending', 1)
			->groupBy('count_order')
			->orderBy('count_order','desc')
		    ->take(10);*/
		
		
            
		
        $category = DB::table('categories')
            ->join('department_categories', 'categories.id', '=', 'department_categories.cat_id')
            ->select('categories.*')
            ->where('department_categories.department_id', $department_id)
			->where('categories.status',1)
            ->get();
        $elementsdata = array();
        $i = 0;
        $chart_category = array();
        $chart_category_data = array();
        $trending_courses = array();
        $trending_courses_data = array();
		$classroom_trainings_chart_data = array();
        foreach ($category as $categorydata) {
            $catid = $categorydata->id;
            $elementsdata[$i]['category']['id'] = $catid;
            $elementsdata[$i]['category']['category_name'] = $categorydata->name;
            $count = DB::table('courses')->where('courses.category_id', $catid)->count();
            $elementsdata[$i]['category']['count'] = $count;
            $SubCategories = SubCategories::where('cat_id',$catid)->get();
            $j = 0;
            $elementsdata[$i]['category']['subcategory'] = array();
            foreach ($SubCategories as $SubCategoriesdata) {
                $subcatid = $SubCategoriesdata->id;
                $elementsdata[$i]['category']['subcategory'][$j]['id'] = $subcatid;
                $subcount = DB::table('courses')->where('courses.sub_cat_id', $subcatid)->count();
                $elementsdata[$i]['category']['subcategory'][$j]['subcount'] = $subcount;
                $elementsdata[$i]['category']['subcategory'][$j]['subcategory_name'] = $SubCategoriesdata->name;
                $course = Course::where('sub_cat_id',$subcatid)->where('popular',1)->get();
                $elementsdata[$i]['category']['subcategory'][$j]['courses'] = $course;
                $elementsdata[$i]['category']['subcategory'][$j]['categoryname'] = $categorydata->name;
            $j++;
            }
			$classroom_trainings_chart_data[] = array((($categorydata->short_name!='' || $categorydata->short_name != null)?$categorydata->short_name:$categorydata->name), Crttraining::where('category_id',$catid)->where('crttrainings.training_type','=','6')->count());
            //$chart_category[$i] = '"'.(($categorydata->short_name!='' || $categorydata->short_name != null)?$categorydata->short_name:$categorydata->name).'"';
            //$chart_category_data[$i] = Crttraining::where('category_id',$catid)->count();
        $i++;
        } 
		/*'['.implode(",", $chart_category).']';
        $chart_category_data_count = '['.implode(",", $chart_category_data).']';*/

        //$hit = Tracker::hit();
        $course_graph_data = DB::select("select courses.title as title, courses.short_name, count(order_items.item_id) as count_order, order_items.item_id from courses left join order_items on courses.id = order_items.item_id inner join course_department on courses.id = course_department.course_id where course_department.department_id = '$department_id' group by order_items.item_id, courses.title,courses.short_name  order by count_order desc limit 10");

        $trending_courses = array();
        $trending_courses_data = array();
        foreach($course_graph_data as $cgd){
            $trending_courses[] = '"' . (($cgd->short_name != '' || $cgd->short_name != null)?$cgd->short_name:$cgd->title) . '"';
            $trending_courses_data[] = $cgd->count_order;
        }
        $trending_courses = '['.implode(",", $trending_courses).']';
        $trending_courses_data = '['.implode(",", $trending_courses_data).']';

       // dd($trending_courses);

        $elementcourse = array();

        $details = DB::table("course_student")
             ->join('courses','courses.id','=','course_student.course_id')
             ->join('course_department','courses.id','=','course_department.course_id')
             ->select('courses.title as label')
             ->where('course_department.department_id',$department_id)
             ->groupBy('courses.title')
            ->get();
            $chartcourse = "";
            foreach ($details as $detailsdata) {
             $chartcourse .= $detailsdata->label.", ";
            }

        $coursescount = Course::count();
        $usercount = User::join('user_details','users.id','=','user_details.user_id')->where('user_details.department_id',$department_id)->count();
        $crttrainingcount = Crttraining::where('training_type','=', 6)->where('status','=', 1)->count();
        $seminarcount = Crttraining::where('training_type','=', 5)->where('status','=', 1)->count();
        $executivebrifing = Crttraining::where('training_type','=', 3)->where('status','=', 1)->count();
		$designations = Designations::where('status',1)->where('department_id',$department_id)->get();
		$level = DB::table('course_difficulty')
               ->select('id','name')
                ->get();
		$usercreated = DB::table('user_details')
			    ->select('created_at')
                ->latest('created_at');
              
		$lastupdateddate = DB::table('courses')
			    ->select('created_at')
                ->latest('created_at')
			    ->union($usercreated)
               ->first();
		$visitor = DB::table('visitor_count')->count();
	 
        return view($this->path . '.index-' . config('theme_layout'), compact('news', 'trending_courses', 'teachers', 'faqs', 'course_categories', 'reasons', 'sections','ministry','departments','newsflash','items','allministry','alldepartments','category','SubCategories','course','logo', 'elementsdata','trendingcourse', 'trending_courses','trending_courses_data','banner','rating','count','enroll','chartcourse','chart_course_title','coursescount','usercount','crttrainingcount','seminarcount','executivebrifing','designations','lessons', 'classroom_trainings_chart_data','level','lastupdateddate','visitor'));
    }
    
    public function getFaqs()
    {
        $faq_categories = Category::has('faqs', '>', 0)->get();
        return view($this->path . '.faq', compact('faq_categories'));
    }

    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'email' => 'required'
        ]);

        if (config('mail_provider') != "" && config('mail_provider') == "mailchimp") {
            try {
                if (!Newsletter::isSubscribed($request->subs_email)) {
                    if (config('mailchimp_double_opt_in')) {
                        Newsletter::subscribePending($request->subs_email);
                        session()->flash('alert', "We've sent you an email, Check your mailbox for further procedure.");
                    } else {
                        Newsletter::subscribe($request->subs_email);
                        session()->flash('alert', "You've subscribed successfully");
                    }
                    return back();
                } else {
                    session()->flash('alert', "Email already exist in subscription list");
                    return back();

                }
            } catch (Exception $e) {
                \Log::info($e->getMessage());
                session()->flash('alert', "Something went wrong, Please try again Later");
                return back();
            }

        } elseif (config('mail_provider') != "" && config('mail_provider') == "sendgrid") {
            try {
                $apiKey = config('sendgrid_api_key');
                $sg = new \SendGrid($apiKey);
                $query_params = json_decode('{"page": 1, "page_size": 1}');
                $response = $sg->client->contactdb()->recipients()->get(null, $query_params);
                if ($response->statusCode() == 200) {
                    $users = json_decode($response->body());
                    $emails = [];
                    foreach ($users->recipients as $user) {
                        array_push($emails, $user->email);
                    }
                    if (in_array($request->subs_email, $emails)) {
                        session()->flash('alert', "Email already exist in subscription list");
                        return back();
                    } else {
                        $request_body = json_decode(
                            '[{
                             "email": "' . $request->subs_email . '",
                             "first_name": "",
                             "last_name": ""
                              }]'
                        );
                        $response = $sg->client->contactdb()->recipients()->post($request_body);
                        if ($response->statusCode() != 201 || (json_decode($response->body())->new_count == 0)) {

                            session()->flash('alert', "Email already exist in subscription list");
                            return back();
                        } else {
                            $recipient_id = json_decode($response->body())->persisted_recipients[0];
                            $list_id = config('sendgrid_list');
                            $response = $sg->client->contactdb()->lists()->_($list_id)->recipients()->_($recipient_id)->post();
                            if ($response->statusCode() == 201) {
                                session()->flash('alert', "You've subscribed successfully");
                            } else {
                                session()->flash('alert', "Check your email and try again");
                                return back();
                            }

                        }
                    }
                }
            } catch (Exception $e) {
                \Log::info($e->getMessage());
                session()->flash('alert', "Something went wrong, Please try again Later");
                return back();
            }
        }

    }

    public function getTeachers()
    {
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $teachers = User::role('teacher')->paginate(12);
        return view($this->path . '.teachers.index', compact('teachers', 'recent_news'));
    }

    public function showTeacher(Request $request)
    {
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $teacher = User::role('teacher')->where('id', '=', $request->id)->first();
        $courses = NULL;
        if (count($teacher->courses) > 0) {
            $courses = $teacher->courses()->paginate(12);
        }
        return view($this->path . '.teachers.show', compact('teacher', 'recent_news', 'courses'));
    }

    public function getDownload(Request $request)
    {
        if (auth()->check()) {
            $lesson = Lesson::findOrfail($request->lesson);
            $course_id = $lesson->course_id;
            $course = Course::findOrfail($course_id);
            $purchased_course = \Auth::check() && $course->students()->where('user_id', \Auth::id())->count() > 0;
            if ($purchased_course) {
                $file = public_path() . "/storage/uploads/" . $request->filename;

                return Response::download($file);
            }
            return abort(404);

        }
        return abort(404);

    }

    public function searchCourse(Request $request)
    {
        $department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            session('department_id');
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();  
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            $request->session()->put('department_id', $department_id);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
        }

        if (request('type') == 'popular') {
            $courses = Course::withoutGlobalScope('filter')
             //->join('course_department', 'courses.id', '=', 'course_department.course_id')
            //->where('course_department.department_id',$department_id)
           ->where('published', 1)->where('popular', '=', 1)->orderBy('title')->paginate(12);
			
			  $coursecountt = Course::withoutGlobalScope('filter')
             //->join('course_department', 'courses.id', '=', 'course_department.course_id')
            //->where('course_department.department_id',$department_id)
           ->where('published', 1)->where('popular', '=', 1)->orderBy('title')->count();
			$popular = "Popular";
			
			

        } else if (request('type') == 'trending') {
            $courses = Course::withoutGlobalScope('filter')
             //->join('course_department', 'courses.id', '=', 'course_department.course_id')
            //->where('course_department.department_id',$department_id)
           ->where('published', 1)->where('trending', '=', 1)->orderBy('title')->paginate(12);
			
			 $coursecountt = Course::withoutGlobalScope('filter')
             //->join('course_department', 'courses.id', '=', 'course_department.course_id')
            //->where('course_department.department_id',$department_id)
           ->where('published', 1)->where('trending', '=', 1)->orderBy('title')->count();
			$trending = "Trending";
			
			
			
			

        } else if (request('type') == 'featured') {
            $courses = Course::withoutGlobalScope('filter')
             //->join('course_department', 'courses.id', '=', 'course_department.course_id')
            //->where('course_department.department_id',$department_id)
           ->where('published', 1)->where('featured', '=', 1)->orderBy('title')->paginate(12);
			
			
			$coursecountt = Course::withoutGlobalScope('filter')
             //->join('course_department', 'courses.id', '=', 'course_department.course_id')
            //->where('course_department.department_id',$department_id)
           ->where('published', 1)->where('featured', '=', 1)->orderBy('title')->count();
			$featured = "Featured";
		

        } 

        else {
            $courses = Course::withoutGlobalScope('filter')
             //->join('course_department', 'courses.id', '=', 'course_department.course_id')
            //->where('course_department.department_id',$department_id)
           ->where('published', 1)->orderBy('id', 'desc')->paginate(12);
			
			
			$coursecountt = Course::withoutGlobalScope('filter')
             //->join('course_department', 'courses.id', '=', 'course_department.course_id')
            //->where('course_department.department_id',$department_id)
           ->where('published', 1)->orderBy('id', 'desc')->count();
			
			
        }


        if ($request->selecttrack != null) {
		
			//$track =DB::table('tracks')Track::find((int)$request->selecttrack);
		    $trackid = (int)$request->selecttrack;
			$categoryid = (int)$request->category;
			$subcategoryid = (int)$request->subcategory;
			$sortbyrating = (int)$request->sortbyrating;
			$sortbytrend = $request->sortbytrend;
			$courselevel = (int)$request->courselevel;
			$designation = (int)$request->designation;
			$coursetype = (int)$request->coursetype;
	
			$subcategory_arraydata = array();
			$category_arraydata = array();
			$courses = array();
			
			if($request->category != null){
				$category = Category::find((int)$request->category);
			} else {
				$category = (object)Category::all();
			}
			
			
			
			if($request->subcategory != null){
				$subcategory_arraydata = DB::table('sub_categories')->where('status', '=', 1)->where('id','=',$subcategoryid)->first();
				$subcategoryid= $subcategory_arraydata->id;
				$courses = $category->courses()->where(function ($query) use ($request) {
                        $query->where('title', 'LIKE', '%' . $request->q . '%');
                        $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
					   
                    })
                        ->where('published', '=', 1)
					    ->orderBy('title')
                        ->where('sub_cat_id', '=', $subcategoryid)
					    ->where('published', '=', 1)
                        //->where($type, '=', 1)
						->when($courselevel, function ($query, $courselevel) {
							if($courselevel != null){
								return $query->where('difficulty_id', $courselevel);
							}
						})
						->when($sortbytrend, function ($query, $sortbytrend) {
							$types = ['popular', 'trending', 'featured'];
							if(in_array($sortbytrend, $types)){
								return $query->where($sortbytrend, '1');
							}
						})
					->when($coursetype, function ($query, $coursetype) {
							if($coursetype != null){
								return $query->where('course_type_id', $coursetype);
							}
						})
					->when($designation, function($query, $designation){
					if($designation != null){
						return $query->DB::table('courses')->join('course_designation','courses.id','=','course_designation.course_id')->where('course_designation.designation_id',$designation);
					}
					})
					
                        ->paginate(12);
			
				
				
				$coursecountt = $category->courses()->where(function ($query) use ($request) {
                        $query->where('title', 'LIKE', '%' . $request->q . '%');
                        $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
					   
                    })
                        ->where('published', '=', 1)
					    ->orderBy('title')
                        ->where('sub_cat_id', '=', $subcategoryid)
					    ->where('published', '=', 1)
                        //->where($type, '=', 1)
						->when($courselevel, function ($query, $courselevel) {
							if($courselevel != null){
								return $query->where('difficulty_id', $courselevel);
							}
						})
						->when($sortbytrend, function ($query, $sortbytrend) {
							$types = ['popular', 'trending', 'featured'];
							if(in_array($sortbytrend, $types)){
								return $query->where($sortbytrend, '1');
							}
						})
					->when($coursetype, function ($query, $coursetype) {
							if($coursetype != null){
								return $query->where('course_type_id', $coursetype);
							}
						})
					->when($designation, function($query, $designation){
					if($designation != null){
						return $query->DB::table('courses')->join('course_designation','courses.id','=','course_designation.course_id')->where('course_designation.designation_id',$designation);
					}
					})
					
                        ->count();
			 	$track = DB::table('tracks')->where('id',$trackid)->first();
				$categoryname = Category::where('id',$categoryid)->first();
				$subcategoryname = SubCategories::where('id',$subcategoryid)->first();
				$sortbytrend = $sortbytrend;
				$courselevel = DB::table('course_difficulty')->where('id',$courselevel)->first();
				$designations = Designations::where('id',$designation)->first();
				$coursetype = $coursetype;
				
			}
			else if($request->category != null){
           		$category_arraydata = DB::table('categories')->where('status', '=', 1)->where('id','=',$categoryid)->first();
				$categoryid= $category_arraydata->id;
				$courses = $category->courses()->where(function ($query) use ($request) {
                        $query->where('title', 'LIKE', '%' . $request->q . '%');
                        $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
				     	
					   
                    	})
                        ->where('published', '=', 1)
					
                        //->where($type, '=', 1)
						->when($courselevel, function ($query, $courselevel) {
							if($courselevel != null){
								return $query->where('difficulty_id', $courselevel);
							}
						})
					
						->when($sortbytrend, function ($query, $sortbytrend) {
							$types = ['popular', 'trending', 'featured'];
							if(in_array($sortbytrend, $types)){
								return $query->where($sortbytrend, '1');
							}
						})
					->when($coursetype, function ($query, $coursetype) {
							if($coursetype != null){
								return $query->where('course_type_id', $coursetype);
							}
						})
					->when($designation, function($query, $designation){
					if($designation != null){
						return $query->DB::table('courses')->join('course_designation','courses.id','=','course_designation.course_id')->where('course_designation.designation_id',$designation);
					}
					})
                        ->where('category_id', '=', $categoryid)
				    	->orderBy('title')
                        ->paginate(12);
				
				
				$coursecountt = $category->courses()->where(function ($query) use ($request) {
                        $query->where('title', 'LIKE', '%' . $request->q . '%');
                        $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
				     	
					   
                    	})
                        ->where('published', '=', 1)
					
                        //->where($type, '=', 1)
						->when($courselevel, function ($query, $courselevel) {
							if($courselevel != null){
								return $query->where('difficulty_id', $courselevel);
							}
						})
					
						->when($sortbytrend, function ($query, $sortbytrend) {
							$types = ['popular', 'trending', 'featured'];
							if(in_array($sortbytrend, $types)){
								return $query->where($sortbytrend, '1');
							}
						})
					->when($coursetype, function ($query, $coursetype) {
							if($coursetype != null){
								return $query->where('course_type_id', $coursetype);
							}
						})
					->when($designation, function($query, $designation){
					if($designation != null){
						return $query->DB::table('courses')->join('course_designation','courses.id','=','course_designation.course_id')->where('course_designation.designation_id',$designation);
					}
					})
                        ->where('category_id', '=', $categoryid)
				    	->orderBy('title')
                        ->count();
					    $track = DB::table('tracks')->where('id',$trackid)->first();
						$categoryname = Category::where('id',$categoryid)->first();
				        $sortbytrend = $sortbytrend;
				        $courselevel = DB::table('course_difficulty')->where('id',$courselevel)->first();
						$designations = Designations::where('id',$designation)->first();
				        $coursetype = $coursetype;
					
				
			} else if($request->selecttrack){
					
				$courses = Course::join('categories', 'categories.id', '=', 'courses.category_id')
				   		->where('categories.track_id',$request->selecttrack)
						->where('title', 'LIKE', '%' . $request->q . '%')
						->orWhere('description', 'LIKE', '%' . $request->q . '%')
					
					
                        //->where($type, '=', 1)
						->when($courselevel, function ($query, $courselevel) {
							if($courselevel != null){
								return $query->where('difficulty_id', $courselevel);
							}
						})
					
						->when($sortbytrend, function ($query, $sortbytrend) {
							$types = ['popular', 'trending', 'featured'];
							if(in_array($sortbytrend, $types)){
								return $query->where($sortbytrend, '1');
							}
						}) 
					->when($coursetype, function ($query, $coursetype) {
							if($coursetype != null){
								return $query->where('course_type_id', $coursetype);
							}
						})
					->when($designation, function($query, $designation){
					if($designation != null){
						return $query->DB::table('courses')->join('course_designation','courses.id','=','course_designation.course_id')->where('course_designation.designation_id',$designation);
					}
					})
						->where('published', '=', 1)
					    ->orderBy('title')
						->paginate(12);
				
				
				$coursecountt  = Course::join('categories', 'categories.id', '=', 'courses.category_id')
				   		->where('categories.track_id',$request->selecttrack)
						->where('title', 'LIKE', '%' . $request->q . '%')
						->orWhere('description', 'LIKE', '%' . $request->q . '%')
					
					
                        //->where($type, '=', 1)
						->when($courselevel, function ($query, $courselevel) {
							if($courselevel != null){
								return $query->where('difficulty_id', $courselevel);
							}
						})
					
						->when($sortbytrend, function ($query, $sortbytrend) {
							$types = ['popular', 'trending', 'featured'];
							if(in_array($sortbytrend, $types)){
								return $query->where($sortbytrend, '1');
							}
						}) 
					->when($coursetype, function ($query, $coursetype) {
							if($coursetype != null){
								return $query->where('course_type_id', $coursetype);
							}
						})
					->when($designation, function($query, $designation){
					if($designation != null){
						return $query->DB::table('courses')->join('course_designation','courses.id','=','course_designation.course_id')->where('course_designation.designation_id',$designation);
					}
					})
						->where('published', '=', 1)
					    ->orderBy('title')
						->count();
				$track = DB::table('tracks')->where('id',$trackid)->first();
			    $sortbytrend = $sortbytrend;
				$courselevel = DB::table('course_difficulty')->where('id',$courselevel)->first();
				$designations = Designations::where('id',$designation)->first();
				$coursetype = $coursetype;
			} else {
				$courses = $category->courses()->where(function ($query) use ($request) {
                        $query->where('title', 'LIKE', '%' . $request->q . '%');
                        $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
					   
		
                    	})
                        ->where('published', '=', 1)
					    ->orderBy('title')
                        ->paginate(12);	
				$coursecountt  = $category->courses()->where(function ($query) use ($request) {
                        $query->where('title', 'LIKE', '%' . $request->q . '%');
                        $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
					   
		
                    	})
                        ->where('published', '=', 1)
					    ->orderBy('title')
                        ->count();	
			}
			
					
			/*$subcategory = SubCategories::where('cat_id','=', $request->category)->get();
            $types = ['popular', 'trending', 'featured'];
            if ($category) {
                if (in_array(request('type'), $types)) {
                    $type = request('type');
                    $courses = $category->courses()->where(function ($query) use ($request) {
                        $query->where('title', 'LIKE', '%' . $request->q . '%');
                        $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
                    })
                        ->whereIn('id', $ids)
                        ->where('published', '=', 1)
                        ->where($type, '=', 1)
                        ->paginate(12);
                } else {
                    $courses = $category->courses()
                        ->where(function ($query) use ($request) {
                            $query->where('title', 'LIKE', '%' . $request->q . '%');
                            $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
                        })
                        ->where('published', '=', 1)
                        ->whereIn('id', $ids)
                        ->paginate(12);
                }

            }*/

        } else {
            $courses = Course::
           //   join('course_department', 'courses.id', '=', 'course_department.course_id')
           // ->where('course_department.department_id',$department_id)
            where('title', 'LIKE', '%' . $request->q . '%')
                ->orWhere('description', 'LIKE', '%' . $request->q . '%')
                ->where('published', '=', 1)
				->orderBy('title')
                ->paginate(12);
			$coursecountt  = Course::
           //   join('course_department', 'courses.id', '=', 'course_department.course_id')
           // ->where('course_department.department_id',$department_id)
            where('title', 'LIKE', '%' . $request->q . '%')
                ->orWhere('description', 'LIKE', '%' . $request->q . '%')
                ->where('published', '=', 1)
				->orderBy('title')
                ->count();

        }
		
	

        $categories = Category::where('status', '=', 1)->get();
        $coursescount = Course::count();
        $q = $request->q;
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();


        $usercount = User::join('user_details','users.id','=','user_details.user_id')->where('user_details.department_id',$department_id)->count();;
        $crttrainingcount = Crttraining::count();
        $crtcurrentcount = Crttraining::whereYear('created_at','=', now()->year)->count();
        $executivebrifing = Crttraining::where('training_type','=', 2)->count();
		$tracks = DB::table('tracks')->where('department_id','=',$department_id)->where('status','=',1)->get();
		$designation = Designations::where('status',1)->where('department_id','=',$department_id)->get();
		$usercreated = DB::table('user_details')->select('created_at')->latest('created_at');
		$lastupdateddate = DB::table('courses')->select('created_at')->latest('created_at')->union($usercreated)->first();
		$visitor = DB::table('visitor_count')->count();
   		$level = DB::table('course_difficulty')->select('id','name')->get();
		
        return view($this->path . '.search-result.courses', compact('courses', 'q', 'recent_news', 'categories','ministry','departments','allministry','alldepartments','logo','coursescount','usercount','crttrainingcount','crtcurrentcount','executivebrifing','subcategory','tracks','designation','level','coursecountt','popular','track','categoryname','subcategoryname','track','sortbytrend','courselevel','designations','coursetype','lastupdateddate','visitor'));
    }


    public function searchBundle(Request $request)
    {

        if (request('type') == 'popular') {
            $bundles = Bundle::withoutGlobalScope('filter')->where('published', 1)->where('popular', '=', 1)->orderBy('id', 'desc')->paginate(12);

        } else if (request('type') == 'trending') {
            $bundles = Bundle::withoutGlobalScope('filter')->where('published', 1)->where('trending', '=', 1)->orderBy('id', 'desc')->paginate(12);

        } else if (request('type') == 'featured') {
            $bundles = Bundle::withoutGlobalScope('filter')->where('published', 1)->where('featured', '=', 1)->orderBy('id', 'desc')->paginate(12);

        } else {
            $bundles = Bundle::withoutGlobalScope('filter')->where('published', 1)->orderBy('id', 'desc')->paginate(12);
        }


        if ($request->category != null) {
            $category = Category::find((int)$request->category);
            $ids = $category->bundles->pluck('id')->toArray();
            $types = ['popular', 'trending', 'featured'];
            if ($category) {

                if (in_array(request('type'), $types)) {
                    $type = request('type');
                    $bundles = $category->bundles()->where(function ($query) use ($request) {
                        $query->where('title', 'LIKE', '%' . $request->q . '%');
                        $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
                    })
                        ->whereIn('id', $ids)
                        ->where('published', '=', 1)
                        ->where($type, '=', 1)
                        ->paginate(12);
                } else {
                    $bundles = $category->bundles()
                        ->where(function ($query) use ($request) {
                            $query->where('title', 'LIKE', '%' . $request->q . '%');
                            $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
                        })
                        ->where('published', '=', 1)
                        ->whereIn('id', $ids)
                        ->paginate(12);
                }

            }

        } else {
            $bundles = Bundle::where('title', 'LIKE', '%' . $request->q . '%')
                ->orWhere('description', 'LIKE', '%' . $request->q . '%')
                ->where('published', '=', 1)
                ->paginate(12);

        }

        $categories = Category::where('status', '=', 1)->get();


        $q = $request->q;
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();

        return view($this->path . '.search-result.bundles', compact('bundles', 'q', 'recent_news', 'categories'));
    }

    public function searchBlog(Request $request)
    {
        $blogs = Blog::where('title', 'LIKE', '%' . $request->q . '%')
            ->paginate(12);
        $categories = Category::has('blogs')->where('status', '=', 1)->paginate(10);
        $popular_tags = Tag::has('blogs', '>', 4)->get();


        $q = $request->q;
        return view($this->path . '.search-result.blogs', compact('blogs', 'q', 'categories', 'popular_tags'));
    }


    public function pilofselflearning(Request $request)
    { 
        $department_id = '0';
        $items = array();
        $SubCategories = array();
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();
            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }
        if($department_id == 0){
            $department_id = session('department_id');;
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
            $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get(); 
            $departments = Departments::where('id',$department_id)->where('status',1)->first(); 
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            $request->session()->put('department_id', $department_id);
            $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
            $departments = Departments::where('id',$department_id)->where('status',1)->first();
        }
            $coursescount = Course::join('course_department','courses.id','=','course_department.course_id')->where('course_department.department_id',$department_id)->count();
		  $crttrainingcount = Crttraining::where('training_type','=', 6)->where('department_id',$department_id)->count();
          $seminarcount = Crttraining::where('training_type','=', 5)->where('department_id',$department_id)->where('status','=', 1)->count();
          $executivebrifing = Crttraining::where('training_type','=', 3)->where('department_id',$department_id)->where('status','=', 1)->count();
		$usercreated = DB::table('user_details')->select('created_at')->latest('created_at');
		$lastupdateddate = DB::table('courses')->select('created_at')->latest('created_at')->union($usercreated)->first();
		$visitor = DB::table('visitor_count')->count();
        
        return view($this->path . '.banner.pilofselflearning',compact('ministry','departments','allministry','alldepartments','logo','coursescount','crtcount','crttrainingcount','seminarcount','executivebrifing','lastupdateddate','visitor'));
    }

    public function beneficiaries(Request $request)
    {
        $department_id = '0';
        $items = array();
        $SubCategories = array();
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();
            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }
        if($department_id == 0){
            $department_id = session('department_id');;
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
            $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get(); 
            $departments = Departments::where('id',$department_id)->where('status',1)->first(); 
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            $request->session()->put('department_id', $department_id);
            $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
            $departments = Departments::where('id',$department_id)->where('status',1)->first();
        }
        $coursescount = Course::count();
		$usercreated = DB::table('user_details')->select('created_at')->latest('created_at');
		$lastupdateddate = DB::table('courses')->select('created_at')->latest('created_at')->union($usercreated)->first();
		$visitor = DB::table('visitor_count')->count();
        
        /*!!!!!!!!*/
        
        return view($this->path . '.banner.beneficiaries',compact('ministry','departments','allministry','alldepartments','logo','coursescount','lastupdateddate','visitor'));
    }
    
    public function beneficiaries_ajax(){
        $attendedCrt = DB::table('tab_training_status')
                       ->select('crt_id')
                       ->where('status',1)
                       ->groupBy('crt_id')
                       ->get();
        
        $divisionArr = array();
        foreach ($attendedCrt as $key => $value) {
            $getUser = DB::table('tab_training_status')->select('user_id')->where('status',1)->where('crt_id',$value->crt_id)->get();
            foreach ($getUser as $ukey => $uval) {
                $getDivision = DB::table('user_details')
                        ->join('organization_departments','user_details.organisationaldept_id','organization_departments.id')
                        ->select('organisationaldept_id')
                        ->where('user_details.user_id',$uval->user_id)
                        ->where('organization_departments.is_group',0)
                        ->get();
                if(count($getDivision) > 0){
                $divisionArr[] = $getDivision[0]->organisationaldept_id;
            }
        }
        }
        $divisions = array_count_values( $divisionArr );
        arsort($divisions);
        $divisions = array_slice($divisions, 0, 10,TRUE);
        $chartDIvisionArr = array();
        foreach ($divisions as $division => $divisionCnt) {
            $crtTraining = 0;
            $seminar = 0;
            $executiveBriefing = 0;
            $eLearning = 0;
            
            $getDivUser = DB::table('user_details')
                    ->join('tab_training_status','user_details.user_id','tab_training_status.user_id')
                    ->select('tab_training_status.user_id','tab_training_status.crt_id')
                    ->where('user_details.organisationaldept_id',$division)
                    ->where('tab_training_status.status',1)
                    ->get();
            
            $userArr = array();
            foreach ($getDivUser as $crtkey => $crtval) {
                $crt = DB::table('crttrainings')
                        ->where('id',$crtval->crt_id)
                        ->select('training_type')->first();
                $userArr[]=$crtval->user_id;
                
                /*For CRT Training*/
                if($crt->training_type == 6){
                    $crtTraining = $crtTraining + 1;
                }
                /*For Executive Briefing*/
                if($crt->training_type == 3){
                    $executiveBriefing = $executiveBriefing + 1;
                }
                /*For Seminars*/
                if($crt->training_type == 5){
                    $seminar = $seminar + 1;
                }
            }
            
            $userArr = array_unique($userArr);
            foreach ($userArr as $uid) {
//                $completed_course = \DB::table('chapter_students')->select("course_id")->where('user_id',$uid)->groupBy('course_id')->get();
                $orders = Order::where('status', '=', 1)
                        ->where('user_id', '=', $uid)
                        ->pluck('id');
                
                $courses_id = OrderItem::whereIn('order_id', $orders)
                        ->where('item_type', '=', "App\Models\Course")
                        ->pluck('item_id');
                
                $purchased_courses = Course::whereIn('id', $courses_id)->get();
                if(count($purchased_courses)>0){
                    foreach($purchased_courses as $item){
                        /*For Course Progress*/
                        $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $uid)->get()->pluck('model_id')->toArray();
                       
                        if (count($completed_lessons) > 0) {
                            if(count($completed_lessons)>1){
                                $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                            }
                            else
                            {
                                $progress = 100;
                            }

                        } else {
                            $progress = 0;
                        }
                        /*isUserCertified*/
                        $certifiedStatus = 0;
                        $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $uid)->first();
                        if ($certified != null) {
                            $certifiedStatus = 1;
                        }
                        if($progress == 100 && $certifiedStatus == 1){
                    $eLearning = $eLearning + 1;
        }
            }
                }
            }
            $chartDIvisionArr[$division] = array($crtTraining, $executiveBriefing, $seminar, $eLearning);
        }
        $labelArr = array();
        $dataArr = array(
                            array("label"=>"CRT Training","backgroundColor"=>"#1a2b4a","data"=>array()),
                            array("label"=>"Executive Briefing","backgroundColor"=>"#dfc32a","data"=>array()),
                            array("label"=>"Seminars","backgroundColor"=>"#ec5252","data"=>array()),
                            array("label"=>"Elearning Course","backgroundColor"=>"#75de41","data"=>array())
                        );
        foreach ($chartDIvisionArr as $divkey => $divval) {
            $getDiv = DB::table('organization_departments')->where('id',$divkey)->select('department_name')->first();
            $labelArr[]=$getDiv->department_name;
            
            foreach ($divval as $k => $v) {
                if($k == 0){
                    $dataArr[$k]['data'][] = $v; 
                }
                if($k == 1){
                    $dataArr[$k]['data'][] = $v;
                }
                if($k == 2){
                    $dataArr[$k]['data'][] = $v;
                }
                if($k == 3){
                    $dataArr[$k]['data'][] = $v;
            }
        }
        }
        $returnArr = array();
        $returnArr['label'] = $labelArr;
        $returnArr['data'] = $dataArr;
        return json_encode($returnArr, TRUE);
    }
    
    public function analytics()
    {
		
        $department_id = '0';
        $items = array();
        $SubCategories = array();
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();
            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }
        if($department_id == 0){
            $department_id = session('department_id');;
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
            $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get(); 
            $departments = Departments::where('id',$department_id)->where('status',1)->first(); 
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            $request->session()->put('department_id', $department_id);
            $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
            $departments = Departments::where('id',$department_id)->where('status',1)->first();
        }

		$designations = Designations::where('status',1)->where('department_id',$department_id)->get();
        $category = DB::table('categories')
            ->join('department_categories', 'categories.id', '=', 'department_categories.cat_id')
            ->select('categories.*')
            ->where('department_categories.department_id', $department_id)
			->where('categories.status',1)
            ->get();
		 $elementsdata = array();
        $i = 0;
        $chart_category = array();
        $chart_category_data = array();
        $trending_courses = array();
        $trending_courses_data = array();
		$classroom_trainings_chart_data = array();
		$seminar_trainings_chart_data = array();
		$exec_trainings_chart_data = array();
        foreach ($category as $categorydata) {
            $catid = $categorydata->id;
            $elementsdata[$i]['category']['id'] = $catid;
            $elementsdata[$i]['category']['category_name'] = $categorydata->name;
            $count = DB::table('courses')->where('courses.category_id', $catid)->count();
            $elementsdata[$i]['category']['count'] = $count;
            $SubCategories = SubCategories::where('cat_id',$catid)->get();
            $j = 0;
            $elementsdata[$i]['category']['subcategory'] = array();
            foreach ($SubCategories as $SubCategoriesdata) {
                $subcatid = $SubCategoriesdata->id;
                $elementsdata[$i]['category']['subcategory'][$j]['id'] = $subcatid;
                $subcount = DB::table('courses')->where('courses.sub_cat_id', $subcatid)->count();
                $elementsdata[$i]['category']['subcategory'][$j]['subcount'] = $subcount;
                $elementsdata[$i]['category']['subcategory'][$j]['subcategory_name'] = $SubCategoriesdata->name;
                $course = Course::where('sub_cat_id',$subcatid)->where('popular',1)->get();
                $elementsdata[$i]['category']['subcategory'][$j]['courses'] = $course;
                $elementsdata[$i]['category']['subcategory'][$j]['categoryname'] = $categorydata->name;
            $j++;
            }

            $classroom_trainings_chart_data[] = array((($categorydata->short_name!='' || $categorydata->short_name != null)?$categorydata->short_name:$categorydata->name), Crttraining::where('category_id',$catid)->where('crttrainings.status','=','1')->where('crttrainings.department_id',$department_id)->where('crttrainings.training_type','=','6')->count());
			

            $seminar_trainings_chart_data[] = array((($categorydata->short_name!='' || $categorydata->short_name != null)?$categorydata->short_name:$categorydata->name), Crttraining::where('category_id',$catid)->where('crttrainings.status','=','1')->where('crttrainings.department_id',$department_id)->where('crttrainings.training_type','=','5')->count());
			

            $exec_trainings_chart_data[] = array((($categorydata->short_name!='' || $categorydata->short_name != null)?$categorydata->short_name:$categorydata->name), Crttraining::where('category_id',$catid)->where('crttrainings.status','=','1')->where('crttrainings.department_id',$department_id)->where('crttrainings.training_type','=','3')->count());
			
			
        $i++;
        }
	
        //$chart_category_names = '['.implode(",", $chart_category).']';
        //$chart_category_data_count = '['.implode(",", $chart_category_data).']';
		
		
		
		
		$course_graph_data = DB::select("select courses.title as title,course_department.course_id as courseid, count(order_items.item_id) as count_order, order_items.item_id from courses left join order_items on courses.id = order_items.item_id join course_department on courses.id= course_department.course_id where course_department.department_id = $department_id  group by course_department.course_id,order_items.item_id, courses.title order by count_order desc limit 10");
		

		
        $trending_courses = array();
        $trending_courses_data = array();
         $trending_courses = array();
        $trending_courses_data = array();
        foreach($course_graph_data as $cgd){
            $trending_courses[] = '"' . $cgd->title . '"';
            $trending_courses_data[] = $cgd->count_order;
        }
        $trending_courses = '['.implode(",", $trending_courses).']';
        $trending_courses_data = '['.implode(",", $trending_courses_data).']';
		

        $elementcourse = array();
        $details = DB::table("course_student")
             ->join('courses','courses.id','=','course_student.course_id')
             ->join('course_department','courses.id','=','course_department.course_id')
             ->select('courses.title as label')
             ->where('course_department.department_id',$department_id)
             ->groupBy('courses.title')
            ->get();
            $chartcourse = "";
            foreach ($details as $detailsdata) {
             $chartcourse .= $detailsdata->label.", ";
            }
        $coursescount = Course::count();
		

        $usercreated = DB::table('user_details')->select('created_at')->latest('created_at');
		$lastupdateddate = DB::table('courses')->select('created_at')->latest('created_at')->union($usercreated)->first();
		$visitor = DB::table('visitor_count')->count();
		
        return view($this->path . '.banner.analytics',compact('ministry','departments','allministry','alldepartments','chart_category_names','chartcourse','classroom_trainings_chart_data','trending_headings','trending_courses','trending_courses_data', 'exec_trainings_chart_data', 'seminar_trainings_chart_data','logo', 'coursescount', 'designations','lastupdateddate','visitor'));
    }
	
	public function designationid($id)
	{
	 return $id;
	}

	
	public function training_charts(Request $request, $charttype, $id, $designationid){
		
		$department_id = $request->session()->get('department_id');
		if($charttype == "classroom"){
			$charttype ='6';
		} else if ($charttype == "seminar"){
			$charttype ='5';
		} else if ($charttype == "execbrf"){
			$charttype ='3';
		}
		//die($charttype);
		if($id==2){

			$current_year = date('Y');
			 $next_year = $current_year+1;

			$startdate = date('Y') + 1 . '-03-31';
			$month_array = array(1,2,3);
			if(in_array(date('m'), $month_array)){
				$startdate = date('Y') . '-03-31';
			}

			$years = DB::table('crttrainings')
			->select(DB::raw('YEAR(start_date) yearnumber'), DB::raw('count(title) totaltraining'))->where('start_date','<=',$startdate)->where('crttrainings.training_type','=',$charttype)->where('department_id', '=', $department_id)
			->groupBy('yearnumber')
			->get();
			$yearscounterdata = array();
			foreach($years as $yrs){
				$yearscounterdata[] = array($yrs->yearnumber, $yrs->totaltraining);
			}

			 return json_encode($yearscounterdata);
		}	
		else if($id==1){
			$startdate_value = date('Y') . '-04-01';
			$enddate_value = date('Y') + 1 . '-03-31';
			$month_array = array(1,2,3);
			if(in_array(date('m'), $month_array)){
				$startdate_value = date('Y') - 1 . '-04-01';
				$enddate_value = date('Y') . '-03-31';
			}
			//echo $charttype;die;
			$months = DB::table('crttrainings')
				->select(DB::raw('MONTH(start_date) month'), DB::raw('count(title) totaltraining'))->where('start_date','>=',$startdate_value)->where('end_date','<=',$enddate_value)->where('crttrainings.training_type','=',$charttype)->where('department_id', '=', $department_id)
				->groupBy('month')
				->get();
			$monthname = array(
				"4" => 'April',
				"5" => 'May',
				"6" => 'June',
				"7" => 'July ',
				"8" => 'August',
				"9" => 'September',
				"10" => 'October',
				"11" => 'November',
				"12" => 'December',
				"1" => 'January',
				"2" => 'February',
				"3" => 'March'
			);
			$monthdata = array(
				"4" => 0,
				"5" => 0,
				"6" => 0,
				"7" => 0,
				"8" => 0,
				"9" => 0,
				"10" => 0,
				"11" => 0,
				"12" => 0,
				"1" => 0,
				"2" => 0,
				"3" => 0
			);
			foreach($months as $mdata){
				$monthdata[$mdata->month] = $mdata->totaltraining;
			}

			$monthcounter_data = array();
			foreach($monthname as $key => $value){
				$monthcounter_data[] = array($monthname[$key], $monthdata[$key]);
			}

			 return json_encode($monthcounter_data);
		 }
		else if($id==4){
			
			$category = DB::table('categories')
				->join('department_categories', 'categories.id', '=', 'department_categories.cat_id')
				->select('categories.*')
				->where('department_categories.department_id', $department_id)
				->where('categories.status',1)
				->get();
			$classroom_trainings_chart_data = array();
			foreach ($category as $categorydata) {
				$catid = $categorydata->id;
				$classroom_trainings_chart_data[] = array((($categorydata->short_name!='' || $categorydata->short_name != null)?$categorydata->short_name:$categorydata->name), Crttraining::where('category_id',$catid)->where('crttrainings.training_type','=',$charttype)->count());
			}

			 return json_encode($classroom_trainings_chart_data);
		}
		else if($id==3){
			
			$category = DB::table('categories')
				->join('department_categories', 'categories.id', '=', 'department_categories.cat_id')
				->select('categories.*')
				->where('department_categories.department_id', $department_id)
				->where('categories.status',1)
				->get();
			$classroom_trainings_chart_data = array();
			foreach ($category as $categorydata) {
				$catid = $categorydata->id;
				if($designationid == '0'){
					$classroom_trainings_chart_data[] = array((($categorydata->short_name!='' || $categorydata->short_name != null)?$categorydata->short_name:$categorydata->name), Crttraining::where('category_id',$catid)->where('crttrainings.training_type','=',$charttype)->count());
				} else {
					$classroom_trainings_chart_data[] = array((($categorydata->short_name!='' || $categorydata->short_name != null)?$categorydata->short_name:$categorydata->name), Crttraining::join('crt_designations','crttrainings.id','=','crt_designations.crt_id')->where('crttrainings.training_type','=',$charttype)->where('crt_designations.designation_id',$designationid)->where('category_id',$catid)->count());
				}
				
			}

			 return json_encode($classroom_trainings_chart_data);
		}
	}
	

public function sendemail()
{
   return  $email = $_GET['email'];
	//return redirect()->route('frontend.auth.password.reset',compact('email'));
	//return redirect('frontend.auth.password.reset', compact('email'));
}
	public function visitorcount()
	{
		$ip = $_GET['ip'];
	    $insert = 	DB::table('visitor_count')->insert(['ip' =>$ip]);
	}


}

