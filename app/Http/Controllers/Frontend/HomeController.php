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
            ->first();
            $trendingcourse = DB::table('courses')
            ->join('course_department', 'course_department.course_id', '=', 'courses.id')
            ->join('categories', 'categories.id', '=', 'courses.category_id')
            ->select('courses.*','categories.name')
            ->where('course_department.department_id', $department_id)
            ->where('courses.published', 1)
            ->where('courses.trending', 1)
            ->get();
       
        
        $category = DB::table('categories')
            ->join('department_categories', 'categories.id', '=', 'department_categories.cat_id')
            ->select('categories.*')
            ->where('department_categories.department_id', $department_id)
            ->get();
          
        $elementsdata = array();
        $i = 0;
        
        $chart_category = array();
        $chart_category_data = array();
        foreach ($category as $categorydata) {
            $catid = $categorydata->id;
            $elementsdata[$i]['category']['id'] = $catid;
            $elementsdata[$i]['category']['category_name'] = $categorydata->name;
            $SubCategories = SubCategories::where('cat_id',$catid)->get();
            $j = 0;
            $elementsdata[$i]['category']['subcategory'] = array();
            foreach ($SubCategories as $SubCategoriesdata) {
                $subcatid = $SubCategoriesdata->id;
                $elementsdata[$i]['category']['subcategory'][$j]['id'] = $subcatid;
                $elementsdata[$i]['category']['subcategory'][$j]['subcategory_name'] = $SubCategoriesdata->name;
                $course = Course::where('sub_cat_id',$subcatid)->where('popular',1)->get();

                $elementsdata[$i]['category']['subcategory'][$j]['courses'] = $course;
                $elementsdata[$i]['category']['subcategory'][$j]['categoryname'] = $categorydata->name;
         
                $j++;
            }
            $chart_category[$i] = $categorydata->name;
            $chart_category_data[$i] = Crttraining::where('category_id',$catid)->count();



            $i++;
        }
        
        return view($this->path . '.index-' . config('theme_layout'), compact('news', 'trending_courses', 'teachers', 'faqs', 'course_categories', 'reasons', 'sections','ministry','departments','newsflash','items','allministry','alldepartments','category','SubCategories','course','logo', 'elementsdata', 'chart_category', 'chart_category_data','trendingcourse','banner'));
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
            $department_id = $request->session()->get('department_id');
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
           //  ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           // ->where('course_department.department_id',$department_id)
           ->where('published', 1)->where('popular', '=', 1)->orderBy('id', 'desc')->paginate(12);

        } else if (request('type') == 'trending') {
            $courses = Course::withoutGlobalScope('filter')
           //  ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           // ->where('course_department.department_id',$department_id)
           ->where('published', 1)->where('trending', '=', 1)->orderBy('id', 'desc')->paginate(12);

        } else if (request('type') == 'featured') {
            $courses = Course::withoutGlobalScope('filter')
           //  ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           // ->where('course_department.department_id',$department_id)
           ->where('published', 1)->where('featured', '=', 1)->orderBy('id', 'desc')->paginate(12);

        } else {
            $courses = Course::withoutGlobalScope('filter')
           //  ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           // ->where('course_department.department_id',$department_id)
           ->where('published', 1)->orderBy('id', 'desc')->paginate(12);
        }


        if ($request->category != null) {

            $category = Category::find((int)$request->category);
            $ids = $category->courses->pluck('id')->toArray();

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

            }

        } else {
            $courses = Course::
              //join('course_department', 'courses.id', '=', 'course_department.course_id')
            //->where('course_department.department_id',$department_id)
            where('title', 'LIKE', '%' . $request->q . '%')
                ->orWhere('description', 'LIKE', '%' . $request->q . '%')
                ->where('published', '=', 1)
                ->paginate(12);

        }

        $categories = Category::where('status', '=', 1)->get();


        $q = $request->q;
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();

        return view($this->path . '.search-result.courses', compact('courses', 'q', 'recent_news', 'categories','ministry','departments','allministry','alldepartments','logo'));
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
}

