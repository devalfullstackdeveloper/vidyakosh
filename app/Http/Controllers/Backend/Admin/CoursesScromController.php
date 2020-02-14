<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Auth\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseTimeline;
use App\Models\Media;
use function foo\func;
// use Illuminate\Support\Facades\File;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCoursesRequest;
use App\Http\Requests\Admin\UpdateCoursesRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Input;
use Validator;
use Auth;

class CoursesScromController extends Controller
{
    use FileUploadTrait;
    
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

        $categories = Category::where('status', '=', 1)->pluck('name', 'id');

        return view('backend.courses.create-scrom', compact('teachers', 'categories'));
    }

    /**
     * Store a newly created Course in storage.
     *
     * @param  \App\Http\Requests\StoreCoursesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCoursesRequest $request)
    {
        // dd('heres');
        // dd($request->all());
        // return public_path();
        if (!Gate::allows('course_create')) {
            return abort(401);
        }
        
        // SCORM PACKAGE
        $attributeNames = [
            'course_scrom_file'    => 'Scrom File',
        ];

        $rules = [
            'course_scrom_file' => 'required|mimes:zip'
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

            $request->all();
            
            // $request = $this->saveFiles($request);

            if($request->hasFile('course_scrom_file')){
                $courseFileName = pathinfo($request->file('course_scrom_file')->getClientOriginalName(), PATHINFO_FILENAME);
                $request->request->add([
                    'course_license_id' => 1122,
                    'course_filename'   => $courseFileName,
                    'file_size'         => $request->file('course_scrom_file')->getSize(),
                    'uploaded_time'     => time(),
                    'course_path'       => time(),
                    'coursecode'        => time(),
                    'course_id'         => $courseFileName,
                    'scorm_course'      => 1
                ]);
        
                ///////////////////////////////////////////
                $storePath = '/storage/uploads/scrom';
                if($request->hasFile('course_scrom_file')){
                    if(Course::where('course_license_id',$request->course_license_id)->where('course_filename',$request->course_filename)->count() > 0){
                        
                        $Course = Course::where('course_filename',$request->course_filename)->where('course_license_id',$request->course_license_id)->first();
                        // $Course->uploaded_bytes = $uploaded_bytes;
                        $Course->uploaded_time  = time();
                        $Course->update();
                        return response()->json([
                            'success'   => false,
                            'message'   => 'Scrom Package already exist!',
                        ]);

                    } else {

                        // mkdir($storePath.'/'.$request->course_path);
                        File::makeDirectory(public_path($storePath.'/'.$request->course_path));
                        
                        $xFile = $request->file('course_scrom_file');
                        $xFileData = $xFile->getClientOriginalName();
                        $xFile->move(public_path($storePath.'/'.$request->course_path), $xFileData);
        
                        $Path = public_path($storePath.'/'.$request->course_path.'/'.$xFileData);
                        \Zipper::make($Path)->extractTo(public_path($storePath.'/'.$request->course_path.'/'.$request->course_filename));
                        \Zipper::close();

                        $XMLFile = public_path().$storePath.'/'.$request->course_path.'/'.$request->course_filename.'/imsmanifest.xml';
                        if(file_exists($XMLFile)){

                            $xml=simplexml_load_file($XMLFile);
                            $XMLschema              = (string)$xml->metadata->schema;
                            $XMLschemaversion       = (string)$xml->metadata->schemaversion;
                            if($XMLschemaversion==""){
                                File::delete(public_path($storePath.'/'.$request->course_path.'/'.$request->course_filename).'.zip');
                                File::deleteDirectory(public_path($storePath.'/'.$request->course_path.'/'.$request->course_filename));
                                $request->request->add(['course_status'=>'invalid']);
                            } else {
                                $request->request->add(['course_status'=>'processing']);
                            }
                            if($request->course_status=="processing"){
                                $request->request->add([
                                    'course_version'    => $XMLschema == 'ADL SCORM'?$XMLschemaversion:'',
                                    'course_schema'     => $XMLschema,
                                    // 'course_id'         => $this->file_name_with_no_ext($name),
                                    // 'uploaded_bytes'    => $uploaded_bytes,
                                    // 'coursecode'        => time(),
                                ]);
                            }

                        } else {
                            
                            File::delete(public_path($storePath.'/'.$request->course_filename).'.zip');
                            File::deleteDirectory(public_path($storePath.'/'.$request->course_filename));

                            return response()->json([
                                'success'   => false,
                                'message'   => 'Invalid Scrom Package!',
                            ]);
                        }
                    }
                }
    
                // return response()->json([
                //     'success'   => true,
                //     'message'   => 'File Upload Successfully',
                // ]);
                ///////////////////////////////////////////
            }
            
            $course = Course::create($request->all());

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
            }


            $teachers = \Auth::user()->isAdmin() ? array_filter((array)$request->input('teachers')) : [\Auth::user()->id];
            $course->teachers()->sync($teachers);

        }

        // return response()->json([
        //     'success'   => true,
        //     'message'   => 'File Upload Successfully',
        // ]);

        return redirect()->route('admin.courses.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    public function show(Request $request, $id){
        if (!Gate::allows('course_edit')) {
            return abort(401);
        }
        $course = Course::findOrFail($id);
        if($course->course_mode == 'normal'){
            $request->request->add(['course_mode' => 'browse']);
        } else {
            $request->request->add(['course_mode' => 'normal']);
        }
        $course->course_mode = $request->course_mode;
        $course->update();

        $teachers = \Auth::user()->isAdmin() ? array_filter((array)$request->input('teachers')) : [\Auth::user()->id];
        $course->teachers()->sync($teachers);

        return redirect()->route('admin.courses.index')->withFlashSuccess(trans('alerts.backend.general.updated_course_mode'));
    }
    
    // public function update(Request $request, $id)
    // {
    //     return $id . 'update here';
    // }
}
