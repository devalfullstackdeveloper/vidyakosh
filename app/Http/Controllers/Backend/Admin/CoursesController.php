<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Auth\User;
use App\Models\Category;
use App\Models\Course;
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
use App\Models\Designations;

class CoursesController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Course.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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

        return view('backend.courses.index', compact('courses'));
    }

    /**
     * Display a listing of Courses via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $courses = "";

        if (request('show_deleted') == 1) {
            if (!Gate::allows('course_delete')) {
                return abort(401);
            }
            $courses = Course::onlyTrashed()
                ->whereHas('category')
                ->ofTeacher()->orderBy('created_at', 'desc')->get();

        } else if (request('teacher_id') != "") {
            $id = request('teacher_id');
            $courses = Course::ofTeacher()
                ->whereHas('category')
                ->whereHas('teachers', function ($q) use ($id) {
                    $q->where('course_user.user_id', '=', $id);
                })->orderBy('created_at', 'desc')->get();
        } else if (request('cat_id') != "") {
            $id = request('cat_id');
            $courses = Course::ofTeacher()
                ->whereHas('category')
                ->where('category_id', '=', $id)->orderBy('created_at', 'desc')->get();
        } else {
            $courses = Course::ofTeacher()
                ->whereHas('category')
                ->orderBy('created_at', 'desc')->get();
        }


        if (auth()->user()->can('course_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('course_edit')) {
            $has_edit = true;
        }
        if (auth()->user()->can('lesson_delete')) {
            $has_delete = true;
        }

        return DataTables::of($courses)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.courses', 'label' => 'lesson', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.courses.show', ['course' => $q->id])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.courses.edit', ['course' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.courses.destroy', ['course' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                if($q->published == 1){
                    $type = 'action-unpublish';
                }else{
                    $type = 'action-publish';
                }
				
				if($q->scorm_course == 1){
                    if ($q->course_status == 'processing') {
                        $parser = '<a href="' . config('app.scorm_url') . 'libs/parser.php?cid=' .$q->coursecode. '" class="btn btn-xs btn-warning text-white mb-1">P</a>';
                        $view .= $parser;
                    }
                    if ($q->course_status == 'ready') {
                        $parser = '<a href="' . config('app.scorm_url') . 'libs/purge-course.php?cid=' .$q->coursecode. '" class="btn btn-xs btn-warning text-white mb-1">P</a>';
                        $view .= $parser;
                    }
                }
                if($q->scorm_course == 1){
                    $edit = view('backend.datatable.action-course-mode')
                        ->with(['route' => route('admin.courses-scrom.show', ['course' => $q->id])])
                        ->render();
                    $view .= $edit;
                    // $parser = '<a href="' . url('/') . '/course-mode/update/' .$q->id. '" class="btn btn-xs btn-info text-white mb-1">M</a>';
                    // $view .= $parser;
                }

                $view .= view('backend.datatable.'.$type)
                    ->with(['route' => route('admin.courses.publish', ['course' => $q->id])])->render();
                return $view;

            })
            ->editColumn('teachers', function ($q) {
                $teachers = "";
                foreach ($q->teachers as $singleTeachers) {
                    $teachers .= '<span class="label label-info label-many">' . $singleTeachers->name . ' </span>';
                }
                return $teachers;
            })
            ->addColumn('lessons', function ($q) {
                $lesson = '<a href="' . route('admin.lessons.create', ['course_id' => $q->id]) . '" class="btn btn-success mb-1"><i class="fa fa-plus-circle"></i></a>  <a href="' . route('admin.lessons.index', ['course_id' => $q->id]) . '" class="btn mb-1 btn-warning text-white"><i class="fa fa-arrow-circle-right"></a>';
                return $lesson;
            })
            ->editColumn('course_image', function ($q) {
                return ($q->course_image != null) ? '<img height="50px" src="' . asset('storage/uploads/' . $q->course_image) . '">' : 'N/A';
            })
            ->editColumn('status', function ($q) {
                $text = "";
                $text = ($q->published == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-dark p-1 mr-1' >" . trans('labels.backend.courses.fields.published') . "</p>" : "";
                $text .= ($q->featured == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-warning p-1 mr-1' >" . trans('labels.backend.courses.fields.featured') . "</p>" : "";
                $text .= ($q->trending == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-success p-1 mr-1' >" . trans('labels.backend.courses.fields.trending') . "</p>" : "";
                $text .= ($q->popular == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-primary p-1 mr-1' >" . trans('labels.backend.courses.fields.popular') . "</p>" : "";
                return $text;
            })
			->addColumn('scormstatus', function ($q) {
                $text = $q->course_status;
                if($text != null && $q->scorm_course == 1){
                    return ucfirst($text);
                } else {
                    return '';
                }
            })
            ->addColumn('coursemode', function ($q) {
                $text = $q->course_mode;
                if($text != null && $q->scorm_course == 1){
                    return ucfirst($text);
                } else {
                    return '';
                }
            })
            ->editColumn('price', function ($q) {
                if ($q->free == 1) {
                    return trans('labels.backend.courses.fields.free');
                }
                return $q->price;
            })
            ->addColumn('category', function ($q) {
                return $q->category->name;
            })
            ->rawColumns(['teachers', 'lessons', 'course_image', 'actions', 'status', 'scormstatus'])
            ->make();
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

        $categories = Category::where('status', '=', 1)->pluck('name', 'id')->prepend('Please select', '');
        $ministry = Ministry::where('status', '=', 1)->pluck('ministry_name', 'id')->prepend('Please select', '');
        //$departments = Departments::where('status', '=', 1)->pluck('department_name', 'id');
        $subcategories = SubCategories::where('status', '=', 1)->pluck('name', 'id')->prepend('Please select', '');
        $difficulty=DB::table('course_difficulty')->select('*')->where('status',1)->get();
        $course_type=DB::table('course_type')->select('*')->where('status',1)->get();

		$course_enrollment_type=DB::table('course_enrollment_type')->select('*')->where('status',1)->get();
		return view('backend.courses.create', compact('teachers', 'categories','ministry','departments','subcategories','difficulty','course_type','course_enrollment_type'));
        //return view('backend.courses.create', compact('teachers', 'categories','ministry','departments','subcategories','difficulty','course_type'));
    }

    /**
     * Store a newly created Course in storage.
     *
     * @param  \App\Http\Requests\StoreCoursesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCoursesRequest $request)
    {
	
        if (!Gate::allows('course_create')) {
            return abort(401);
        }
        
        $ministry_id = array_filter((array)$request->input('ministry_id'));
        $department_id = array_filter((array)$request->input('department_id'));
		$designnationid =  $request->input('crt_designation_id');
		//return $countdata  = count($designnationid);
		
        //print_r($request->all());
		//print_r($designnationid);
		//die;
        $request->all();

        $request = $this->saveFiles($request);

        $course = Course::create($request->all());
        $courseid = $course->id;
		for($i=0;$i<count($designnationid);$i++)
		{
		DB::table('course_designation')->insert(
      ['designation_id' => $designnationid[$i], 'course_id' => $courseid]
       );
		}
	
        //Saving  videos
        if ($request->media_type != "") {
            $model_type = Course::class;
            $model_id = $course->id;
            $size = 0;
            $media = '';
            $url = '';
            $video_id = '';
            $name = $course->title . ' - video';

            if (($request->media_type == 'youtube') || ($request->media_type == 'vimeo')) {
                $video = $request->video;
                $url = $video;
                $video_id = array_last(explode('/', $request->video));
                $media = Media::where('url', $video_id)
                    ->where('type', '=', $request->media_type)
                    ->where('model_type', '=', 'App\Models\Course')
                    ->where('model_id', '=', $course->id)
                    ->first();
                $size = 0;

            } elseif ($request->media_type == 'upload') {
                if (\Illuminate\Support\Facades\Request::hasFile('video_file')) {
                    $file = \Illuminate\Support\Facades\Request::file('video_file');
                    $filename = time() . '-' . $file->getClientOriginalName();
                    $size = $file->getSize() / 1024;
                    $path = public_path() . '/storage/uploads/';
                    $file->move($path, $filename);

                    $video_id = $filename;
                    $url = asset('storage/uploads/' . $filename);

                    $media = Media::where('type', '=', $request->media_type)
                        ->where('model_type', '=', 'App\Models\Lesson')
                        ->where('model_id', '=', $course->id)
                        ->first();
                }
            } else if ($request->media_type == 'embed') {
                $url = $request->video;
                $filename = $course->title . ' - video';
            }

            if ($media == null) {
                $media = new Media();
                $media->model_type = $model_type;
                $media->model_id = $model_id;
                $media->name = $name;
                $media->url = $url;
                $media->type = $request->media_type;
                $media->file_name = $video_id;
                $media->size = 0;
                $media->save();
            }
        }


        if (($request->slug == "") || $request->slug == null) {
            $course->slug = str_slug($request->title);
            $course->save();
        }
        if ((int)$request->price == 0) {
            $course->price = NULL;
            $course->save();
            $insertedId = $course->id;
        }

        $ministry_id = array_filter((array)$request->input('ministry_id')); 
       foreach ($ministry_id as $key) {
        $courseministry = new CourseMinistry;
        $courseministry->ministry_id=$key;
        $courseministry->course_id=$insertedId; 
        $courseministry->save();
        }
        $department_id = array_filter((array)$request->input('department_id'));
         foreach ($department_id as $key) {
        $coursedepartment = new CourseDepartment;
        $coursedepartment->department_id=$key;
        $coursedepartment->course_id=$insertedId;
        $coursedepartment->save();
        }


        $teachers = \Auth::user()->isAdmin() ? array_filter((array)$request->input('teachers')) : [\Auth::user()->id];
        $course->teachers()->sync($teachers);


        return redirect()->route('admin.courses.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Course.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)   
    {   
        if (!Gate::allows('course_edit')) { 
            return abort(401);  
        }   
        $teachers = \App\Models\Auth\User::whereHas('roles', function ($q) {    
            $q->where('role_id', 2);    
        })->get()->pluck('name', 'id'); 
        $categories = Category::where('status', '=', 1)->pluck('name', 'id');   
        $ministry = Ministry::where('status', '=', 1)->pluck('ministry_name', 'id')->prepend('Please select', '');  
        //$departments = Departments::where('status', '=', 1)->pluck('department_name', 'id');  
        $subcategories = SubCategories::where('status', '=', 1)->pluck('name', 'id')->prepend('Please select', ''); 
        $difficulty=DB::table('course_difficulty')->where('status',1)->pluck('name', 'id')->prepend('Please select', '');   
        $course_type=DB::table('course_type')->where('status',1)->pluck('name', 'id')->prepend('Please select', ''); 
		$course_enrollment_type=DB::table('course_enrollment_type')->where('status',1)->pluck('name', 'id')->prepend('Please select', '');
        $departments = Departments::where('status', '=', 1)->pluck('department_name', 'id');    
        $course = Course::findOrFail($id);
		$designation = Designations::where('status', '=', 1)->pluck('designation', 'id');
		$coursedesignation = DB::table('course_designation')->join('designations','course_designation.designation_id','=','designations.id')
							->select('designations.designation','designations.id')
			                 //->pluck('designations.id as id','designations.designation')
							->where('course_designation.course_id','=',$id)               
			             ->get();
	     
			$course_ministry = DB::table("course_ministry")->where('course_id',$id)->select("ministry_id")->get();  
        $ministryArr = array(); 
        foreach ($course_ministry as $key => $value) {  
            $ministryArr[] = $value->ministry_id;   
        }   
        $course_department = DB::table("course_department")->where('course_id',$id)->select("department_id")->get();    
        $deptArr = array(); 
        foreach ($course_department as $key => $value) {    
            $deptArr[] = $value->department_id; 
        }   
        return view('backend.courses.edit', compact('course', 'teachers', 'categories', 'ministry', 'subcategories', 'difficulty', 'course_type','ministryArr','deptArr','departments','course_enrollment_type','coursedesignation','designation'));   
		/*$departments = Departments::where('status', '=', 1)->pluck('department_name', 'id');    
        $course = Course::findOrFail($id);  
        $course_ministry = DB::table("course_ministry")->where('course_id',$id)->select("ministry_id")->get();  
        $ministryArr = array(); 
        foreach ($course_ministry as $key => $value) {  
            $ministryArr[] = $value->ministry_id;   
        }   
        $course_department = DB::table("course_department")->where('course_id',$id)->select("department_id")->get();    
        $deptArr = array(); 
        foreach ($course_department as $key => $value) {    
            $deptArr[] = $value->department_id; 
        }   
        return view('backend.courses.edit', compact('course', 'teachers', 'categories', 'ministry', 'subcategories', 'difficulty', 'course_type','ministryArr','deptArr','departments'));   */
    }

    /**
     * Update Course in storage.
     *
     * @param  \App\Http\Requests\UpdateCoursesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCoursesRequest $request, $id)
    {
        if (!Gate::allows('course_edit')) {
            return abort(401);
        }
        $course = Course::findOrFail($id);
        $request = $this->saveFiles($request);
		$designnationid =  $request->input('crt_designation_id');
		
		//for($i=0;$i<count($designnationid);$i++)
		//{
			//DB::table('course_designation')
            //->where('course_id',$id)
            //->updateOrInsert(['designation_id' => $designnationid[$i]]);
		//}

        //Saving  videos
        if ($request->media_type != "" || $request->media_type  != null) {
            if($course->mediavideo){
                $course->mediavideo->delete();
            }
            $model_type = Course::class;
            $model_id = $course->id;
            $size = 0;
            $media = '';
            $url = '';
            $video_id = '';
            $name = $course->title . ' - video';
            $media = $course->mediavideo;
            if ($media == "") {
                $media = new  Media();
            }
            if ($request->media_type != 'upload') {
                if (($request->media_type == 'youtube') || ($request->media_type == 'vimeo')) {
                    $video = $request->video;
                    $url = $video;
                    $video_id = array_last(explode('/', $request->video));
                    $size = 0;

                } else if ($request->media_type == 'embed') {
                    $url = $request->video;
                    $filename = $course->title . ' - video';
                }
                $media->model_type = $model_type;
                $media->model_id = $model_id;
                $media->name = $name;
                $media->url = $url;
                $media->type = $request->media_type;
                $media->file_name = $video_id;
                $media->size = 0;
                $media->save();
            }

            if ($request->media_type == 'upload') {

                if ($request->video_file != null) {

                    $media = Media::where('type', '=', $request->media_type)
                        ->where('model_type', '=', 'App\Models\Course')
                        ->where('model_id', '=', $course->id)
                        ->first();

                    if ($media == null) {
                        $media = new Media();
                    }
                    $media->model_type = $model_type;
                    $media->model_id = $model_id;
                    $media->name = $name;
                    $media->url = url('storage/uploads/'.$request->video_file);
                    $media->type = $request->media_type;
                    $media->file_name = $request->video_file;
                    $media->size = 0;
                    $media->save();

                }
            }
        }


        $course->update($request->all());
        if (($request->slug == "") || $request->slug == null) {
            $course->slug = str_slug($request->title);
            $course->save();
        }
        if ((int)$request->price == 0) {
            $course->price = NULL;
            $course->save();
        }

        $teachers = \Auth::user()->isAdmin() ? array_filter((array)$request->input('teachers')) : [\Auth::user()->id];
        $course->teachers()->sync($teachers);

        return redirect()->route('admin.courses.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


    /**
     * Display Course.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('course_view')) {
            return abort(401);
        }
        $teachers = User::get()->pluck('name', 'id');
        $lessons = \App\Models\Lesson::where('course_id', $id)->get();
        $tests = \App\Models\Test::where('course_id', $id)->get();

        $course = Course::findOrFail($id);
        $courseTimeline = $course->courseTimeline()->orderBy('sequence', 'asc')->get();

        return view('backend.courses.show', compact('course', 'lessons', 'tests', 'courseTimeline'));
    }


    /**
     * Remove Course from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('course_delete')) {
            return abort(401);
        }
        $course = Course::findOrFail($id);
        if ($course->students->count() >= 1) {
            return redirect()->route('admin.courses.index')->withFlashDanger(trans('alerts.backend.general.delete_warning'));
        } else {
			///////////////////////////////////////////
            $storePath = '/storage/uploads/scrom';
            File::deleteDirectory(public_path($storePath.'/'.$course->course_path.'/'.$course->course_filename));
            ///////////////////////////////////////////
            $course->delete();
        }


        return redirect()->route('admin.courses.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
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
            $entries = Course::whereIn('id', $request->input('ids'))->get();

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
			        ///////////////////////////////////////////
        $storePath = '/storage/uploads/scrom';
        File::deleteDirectory(public_path($storePath.'/'.$course->course_path));
        ///////////////////////////////////////////
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
	
	
      public function subcatFilter($id)
    {
        $sub_categories = DB::table("sub_categories")
                    ->where("cat_id",$id)
					->where("status",1)
                    ->select("name","id")
                    ->pluck('name','id');
                return json_encode($sub_categories);
    }
	
	public function departmentdesignation($id)
	{
		$designation = DB::table("designations")
                    ->where("department_id",$id)
					->where("status",1)
                    ->select("designation","id")
                   ->pluck('designation','id');
               return json_encode($designation);
	}
	public function designationedit($courseid,$id)
	{
	$designation = DB::table("designations")
                    ->where("department_id",$id)
					->where("status",1)
                    ->select("designation","id")
                   ->pluck('designation','id');
               return json_encode($designation);
	}
}
