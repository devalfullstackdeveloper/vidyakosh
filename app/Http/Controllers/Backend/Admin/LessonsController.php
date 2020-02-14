<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Course;
use App\Models\CourseTimeline;
use App\Models\Lesson;
use App\Models\Media;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLessonsRequest;
use App\Http\Requests\Admin\UpdateLessonsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Input;
use Validator;
use Auth;

class LessonsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Lesson.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Gate::allows('lesson_access')) {
            return abort(401);
        }
        $courses = $courses = Course::has('category')->ofTeacher()->pluck('title', 'id')->prepend('Please select', '');

        return view('backend.lessons.index', compact('courses'));
    }

    /**
     * Display a listing of Lessons via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {

        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $lessons = "";
        $lessons = Lesson::whereIn('course_id', Course::ofTeacher()->pluck('id'));


        if ($request->course_id != "") {
            $lessons = $lessons->where('course_id', (int)$request->course_id)->orderBy('created_at', 'desc')->get();
        }

        if ($request->show_deleted == 1) {
            if (!Gate::allows('lesson_delete')) {
                return abort(401);
            }
            $lessons = Lesson::query()->with('course')->orderBy('created_at', 'desc')->onlyTrashed()->get();
        }


        if (auth()->user()->can('lesson_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('lesson_edit')) {
            $has_edit = true;
        }
        if (auth()->user()->can('lesson_delete')) {
            $has_delete = true;
        }

        return DataTables::of($lessons)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.lessons', 'label' => 'lesson', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.lessons.show', ['lesson' => $q->id])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.lessons.edit', ['lesson' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                // 
                if($q->scorm_lesson == 1){
                    if ($q->lesson_status == 'processing') {
                        $parser = '<a href="' . config('app.scorm_url') . 'libs/parser.php?cid=' .$q->lessoncode. '&type=lesson" class="btn btn-xs btn-warning text-white mb-1 mr-1">P</a>';
                        $view .= $parser;
                    }
                    if ($q->lesson_status == 'ready') {
                        $parser = '<a href="' . config('app.scorm_url') . 'libs/purge-course.php?cid=' .$q->lessoncode. '&course_id='.$q->course_id.'&type=lesson" class="btn btn-xs btn-warning text-white mb-1 mr-1">P</a>';
                        $view .= $parser;
                    }
                }

                if($q->scorm_lesson == 1){
                    $edit = view('backend.datatable.action-course-mode')
                        ->with(['route' => route('admin.lessons.modechange', ['lesson' => $q->id])])
                        ->render();
                    $view .= $edit;
                }
                // 

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.lessons.destroy', ['lesson' => $q->id])])
                        ->render();
                    $view .= $delete;
                }

                if (auth()->user()->can('test_view')) {
                    if ($q->test != "") {
                        $view .= '<a href="' . route('admin.tests.index', ['lesson_id' => $q->id]) . '" class="btn btn-success btn-block mb-1">' . trans('labels.backend.tests.title') . '</a>';
                    }
                }

                return $view;

            })
            // 
            ->addColumn('scormstatus', function ($q) {
                $text = $q->lesson_status;
                if($text != null && $q->scorm_lesson == 1){
                    return ucfirst($text);
                } else {
                    return '';
                }
            })
            ->addColumn('coursemode', function ($q) {
                $text = $q->lesson_mode;
                if($text != null && $q->scorm_lesson == 1){
                    return ucfirst($text);
                } else {
                    return '';
                }
            })
            // 
            ->editColumn('course', function ($q) {
                return ($q->course) ? $q->course->title : 'N/A';
            })
            ->editColumn('lesson_image', function ($q) {
                return ($q->lesson_image != null) ? '<img height="50px" src="' . asset('storage/uploads/' . $q->lesson_image) . '">' : 'N/A';
            })
            ->editColumn('free_lesson', function ($q) {
                return ($q->free_lesson == 1) ? "Yes" : "No";
            })
            ->editColumn('published', function ($q) {
                return ($q->published == 1) ? "Yes" : "No";
            })
            ->rawColumns(['lesson_image', 'actions', 'scormstatus', 'coursemode'])
            ->make();
    }

    /**
     * Show the form for creating new Lesson.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('lesson_create')) {
            return abort(401);
        }
        $courses = Course::has('category')->ofTeacher()->get()->pluck('title', 'id')->prepend('Please select', '');
        return view('backend.lessons.create', compact('courses'));
    }

    /**
     * Store a newly created Lesson in storage.
     *
     * @param  \App\Http\Requests\StoreLessonsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessonsRequest $request)
    {
        if (!Gate::allows('lesson_create')) {
            return abort(401);
        }
        // dd($request->all());
        // SCORM PACKAGE
        $attributeNames = [
            'lesson_scrom_file'    => 'Scrom File',
        ];

        $rules = [
             'lesson_scrom_file' => 'required|mimes:zip'
        ];

        $messages = [
            // 
        ];

        $Validator = Validator::make($request->all(), $rules, $messages);
        $Validator->setAttributeNames($attributeNames);
        
        if($Validator->fails()){
            return response()->json([
                'success'   => false,
                'errors'    => $Validator->errors(),
            ]);
        }
        else
        {
            if($request->hasFile('lesson_scrom_file')){
                $lessonFileName = pathinfo($request->file('lesson_scrom_file')->getClientOriginalName(), PATHINFO_FILENAME);
                $request->request->add([
                    'lesson_license_id' => 1122,
                    'lesson_filename'   => $lessonFileName,
                    'file_size'         => $request->file('lesson_scrom_file')->getSize(),
                    'uploaded_time'     => time(),
                    'lesson_path'       => time(),
                    'lessoncode'        => time(),
                    'lesson_id'         => $lessonFileName,
                    'scorm_lesson'      => 1
                ]);
        
                ///////////////////////////////////////////
                $storePath = '/storage/uploads/scrom';
                if($request->hasFile('lesson_scrom_file')){
/*
                    if(Lesson::where('lesson_license_id',$request->lesson_license_id)->where('lesson_filename',$request->lesson_filename)->count() > 0){
                        
                        $Lesson = Lesson::where('lesson_filename',$request->lesson_filename)->where('lesson_license_id',$request->lesson_license_id)->first();
                        // $Lesson->uploaded_bytes = $uploaded_bytes;
                        $Lesson->uploaded_time  = time();
                        $Lesson->update();
                        return redirect()->route('admin.lessons.index', ['course_id' => $request->course_id])->withFlashWarning(__('alerts.backend.general.scorm_package_exist'));
                        // return response()->json([
                        //     'success'   => false,
                        //     'message'   => 'Scrom Package already exist!',
                        // ]);

                    } else {
*/
					//echo public_path();
					//echo $storePath.'/'.$request->lesson_path;die;
                        // mkdir($storePath.'/'.$request->lesson_path);
					//echo public_path() . $storePath.'/'.$request->lesson_path;die;
                        File::makeDirectory(public_path() . $storePath.'/'.$request->lesson_path);
                        //echo 'i m here';die;
                        $xFile = $request->file('lesson_scrom_file');
                        $xFileData = $xFile->getClientOriginalName();
                        $xFile->move(public_path($storePath.'/'.$request->lesson_path), $xFileData);
        
                        $Path = public_path($storePath.'/'.$request->lesson_path.'/'.$xFileData);
                        \Zipper::make($Path)->extractTo(public_path($storePath.'/'.$request->lesson_path.'/'.$request->lesson_filename));
                        \Zipper::close();

                        $XMLFile = public_path().$storePath.'/'.$request->lesson_path.'/'.$request->lesson_filename.'/imsmanifest.xml';
                        if(file_exists($XMLFile)){

                            $xml=simplexml_load_file($XMLFile);
                            $XMLschema              = (string)$xml->metadata->schema;
                            $XMLschemaversion       = (string)$xml->metadata->schemaversion;
                            if($XMLschemaversion==""){
                                File::delete(public_path($storePath.'/'.$request->lesson_path.'/'.$request->lesson_filename).'.zip');
                                File::deleteDirectory(public_path($storePath.'/'.$request->lesson_path.'/'.$request->lesson_filename));
                                $request->request->add(['lesson_status'=>'invalid']);
                            } else {
                                $request->request->add(['lesson_status'=>'processing']);
                            }
                            if($request->lesson_status=="processing"){
                                $request->request->add([
                                    'lesson_version'    => $XMLschema == 'ADL SCORM'?$XMLschemaversion:'',
                                    'lesson_schema'     => $XMLschema,
                                    // 'lesson_id'         => $this->file_name_with_no_ext($name),
                                    // 'uploaded_bytes'    => $uploaded_bytes,
                                    // 'coursecode'        => time(),
                                ]);
                            }

                        } else {
                            
                            File::delete(public_path($storePath.'/'.$request->lesson_filename).'.zip');
                            File::deleteDirectory(public_path($storePath.'/'.$request->lesson_filename));

                            // return response()->json([
                            //     'success'   => false,
                            //     'message'   => 'Invalid Scrom Package!',
                            // ]);
                            return redirect()->route('admin.lessons.index', ['course_id' => $request->course_id])->withFlashSuccess(__('alerts.backend.general.invalid_scorm_package'));
                        }
                    /*}*/
                }
    
                // return response()->json([
                //     'success'   => true,
                //     'message'   => 'File Upload Successfully',
                // ]);
                ///////////////////////////////////////////
            }

            $lesson = Lesson::create($request->except('downloadable_files', 'lesson_image')
                + ['position' => Lesson::where('course_id', $request->course_id)->max('position') + 1]);


            //Saving  videos
            if ($request->media_type != "") {
                $model_type = Lesson::class;
                $model_id = $lesson->id;
                $size = 0;
                $media = '';
                $url = '';
                $video_id = '';
                $name = $lesson->title . ' - video';

                if (($request->media_type == 'youtube') || ($request->media_type == 'vimeo')) {
                    $video = $request->video;
                    $url = $video;
                    $video_id = array_last(explode('/', $request->video));
                    $media = Media::where('url', $video_id)
                        ->where('type', '=', $request->media_type)
                        ->where('model_type', '=', 'App\Models\Lesson')
                        ->where('model_id', '=', $lesson->id)
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
                            ->where('model_id', '=', $lesson->id)
                            ->first();
                    }
                } else if ($request->media_type == 'embed') {
                    $url = $request->video;
                    $filename = $lesson->title . ' - video';
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

            if(isset($request->downloadable_files)){
                $request = $this->saveAllFiles($request, 'downloadable_files', Lesson::class, $lesson);
            }

            if (($request->slug == "") || $request->slug == null) {
                $lesson->slug = str_slug($request->title);
                $lesson->save();
            }

            $sequence = 1;
            if (count($lesson->course->courseTimeline) > 0) {
                $sequence = $lesson->course->courseTimeline->max('sequence');
                $sequence = $sequence + 1;
            }

            if ($lesson->published == 1) {
                $timeline = CourseTimeline::where('model_type', '=', Lesson::class)
                    ->where('model_id', '=', $lesson->id)
                    ->where('course_id', $request->course_id)->first();
                if ($timeline == null) {
                    $timeline = new CourseTimeline();
                }
                $timeline->course_id = $request->course_id;
                $timeline->model_id = $lesson->id;
                $timeline->model_type = Lesson::class;
                $timeline->sequence = $sequence;
                $timeline->save();
            }

        }

        // return response()->json([
        //     'success'   => true,
        //     'message'   => 'File Upload Successfully',
        // ]);

        return redirect()->route('admin.lessons.index', ['course_id' => $request->course_id])->withFlashSuccess(__('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Lesson.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('lesson_edit')) {
            return abort(401);
        }
        $videos = '';
        $courses = Course::has('category')->ofTeacher()->get()->pluck('title', 'id')->prepend('Please select', '');

        $lesson = Lesson::with('media')->findOrFail($id);
        if ($lesson->media) {
            $videos = $lesson->media()->where('media.type', '=', 'YT')->pluck('url')->implode(',');
        }

        return view('backend.lessons.edit', compact('lesson', 'courses', 'videos'));
    }

    /**
     * Update Lesson in storage.
     *
     * @param  \App\Http\Requests\UpdateLessonsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLessonsRequest $request, $id)
    {
        if (!Gate::allows('lesson_edit')) {
            return abort(401);
        }
        $lesson = Lesson::findOrFail($id);
        $lesson->update($request->except('downloadable_files', 'lesson_image'));
        if (($request->slug == "") || $request->slug == null) {
            $lesson->slug = str_slug($request->title);
            $lesson->save();
        }

        //Saving  videos
        if ($request->media_type != "") {
            $model_type = Lesson::class;
            $model_id = $lesson->id;
            $size = 0;
            $media = '';
            $url = '';
            $video_id = '';
            $name = $lesson->title . ' - video';
            $media = $lesson->mediavideo;
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
                    $filename = $lesson->title . ' - video';
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
                        ->where('model_id', '=', $lesson->id)
                        ->first();

                    if ($media == null) {
                        $media = new Media();
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
            }
        }
        if($request->hasFile('add_pdf')){
            $pdf = $lesson->mediaPDF;
            if($pdf){
                $pdf->delete();
            }
        }


        $request = $this->saveAllFiles($request, 'downloadable_files', Lesson::class, $lesson);

        $sequence = 1;
        if (count($lesson->course->courseTimeline) > 0) {
            $sequence = $lesson->course->courseTimeline->max('sequence');
            $sequence = $sequence + 1;
        }

        if (($lesson->published != 1) && ((int)$request->published == 1)) {
            $timeline = CourseTimeline::where('model_type', '=', Lesson::class)
                ->where('model_id', '=', $lesson->id)
                ->where('course_id', $request->course_id)->first();
            if ($timeline == null) {
                $timeline = new CourseTimeline();
            }
            $timeline->course_id = $request->course_id;
            $timeline->model_id = $lesson->id;
            $timeline->model_type = Lesson::class;
            $timeline->sequence = $sequence;
            $timeline->save();
        }


        return redirect()->route('admin.lessons.index', ['course_id' => $request->course_id])->withFlashSuccess(__('alerts.backend.general.updated'));
    }


    /**
     * Display Lesson.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('lesson_view')) {
            return abort(401);
        }
        $courses = Course::get()->pluck('title', 'id')->prepend('Please select', '');

        $tests = Test::where('lesson_id', $id)->get();

        $lesson = Lesson::findOrFail($id);


        return view('backend.lessons.show', compact('lesson', 'tests', 'courses'));
    }


    /**
     * Remove Lesson from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('lesson_delete')) {
            return abort(401);
        }
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();

        return back()->withFlashSuccess(__('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Lesson at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('lesson_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Lesson::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Lesson from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('lesson_delete')) {
            return abort(401);
        }
        $lesson = Lesson::onlyTrashed()->findOrFail($id);
        $lesson->restore();

        return back()->withFlashSuccess(trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Lesson from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('lesson_delete')) {
            return abort(401);
        }
        $lesson = Lesson::onlyTrashed()->findOrFail($id);

        if(File::exists(public_path('/storage/uploads/'.$lesson->lesson_image))) {
            File::delete(public_path('/storage/uploads/'.$lesson->lesson_image));
            File::delete(public_path('/storage/uploads/thumb/'.$lesson->lesson_image));
        }

        $timelineStep = CourseTimeline::where('model_id', '=', $id)
            ->where('course_id', '=', $lesson->course->id)->first();
        if($timelineStep){
            $timelineStep->delete();
        }

        $lesson->forceDelete();



        return back()->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    

    public function modeChange(Request $request, $id){
        if (!Gate::allows('lesson_edit')) {
            return abort(401);
        }
        $lesson = Lesson::findOrFail($id);
        if($lesson->lesson_mode == 'normal'){
            $request->request->add(['lesson_mode' => 'browse']);
        } else {
            $request->request->add(['lesson_mode' => 'normal']);
        }
        $lesson->lesson_mode = $request->lesson_mode;
        $lesson->update();

        // $teachers = \Auth::user()->isAdmin() ? array_filter((array)$request->input('teachers')) : [\Auth::user()->id];
        // $lesson->teachers()->sync($teachers);

        return redirect()->route('admin.lessons.index', ['course_id' => $lesson->course_id])->withFlashSuccess(__('alerts.backend.general.updated_lesson_mode'));
        // return redirect()->route('admin.lessons.index')->withFlashSuccess(trans('alerts.backend.general.updated_lesson_mode'));
        
    }


}
