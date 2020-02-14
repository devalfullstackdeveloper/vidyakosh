<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreCategoriesRequest;
use App\Http\Requests\Admin\UpdateCategoriesRequest;
use App\Models\Category;
use App\Models\Ministry;
use App\Models\Departments;
use App\Models\Track;
use App\Models\Locations;
use DB;
use App\Models\MinistryCategories;
use App\Models\DepartmentCategories;
use App\Models\OfficeCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class CategoriesController extends Controller
{

    use FileUploadTrait;

    /**
     * Display a listing of Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('category_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (!Gate::allows('category_delete')) {
                return abort(401);
            }
            $categories = Category::onlyTrashed()->get();
        } else {
            $categories = Category::all();
        }

        return view('backend.categories.index', compact('categories'));
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
		$has_publish = false;
		$has_unpublish = false;
        $categories = "";


        if (request('show_deleted') == 1) {
            if (!Gate::allows('category_delete')) {
                return abort(401);
            }
            $categories = Category::onlyTrashed()->orderBy('created_at', 'desc')->get();
        } else {
            $categories = Category::orderBy('created_at', 'desc')->get();
        }

        if (auth()->user()->can('category_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('category_edit')) {
            $has_edit = true;
        }
        if (auth()->user()->can('category_delete')) {
            $has_delete = true;
        }
		$has_publish = true;
		$has_unpublish = true;

        return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.categories', 'label' => 'category', 'value' => $q->id]);
                }
//                if ($has_view) {
//                    $view = view('backend.datatable.action-view')
//                        ->with(['route' => route('admin.categories.show', ['category' => $q->id])])->render();
//                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.categories.edit', ['category' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.categories.destroy', ['category' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
				
					 if ($has_publish || $has_unpublish) {
						if($q->status == 1){
                    $publish = view('backend.datatable.action-publish')
                        ->with(['route' => route('admin.categories.unpublish', ['category' => $q->id])])
                        ->render();
                    $view .= $publish;
						}else{
					   $unpublish = view('backend.datatable.action-unpublish')
                        ->with(['route' => route('admin.categories.publish', ['category' => $q->id])])
                        ->render();
                    $view .= $unpublish;		
						}
                }

                $view .= '<a class="btn btn-warning mb-1" href="' . route('admin.courses.index', ['cat_id' => $q->id]) . '">' . trans('labels.backend.courses.title') . '</a>';
                $view .= '<a class="btn btn-success" href="' . route('admin.subcategories.index', ['cat_id' => $q->id]) . '" >' . "Create Sub Category" . '</a>';
		
                return $view;

            })
            ->editColumn('icon', function ($q) {
                if ($q->icon != "") {
                    return '<i style="font-size:40px;" class="'.$q->icon.'"></i>';
                }else{
                    return 'N/A';
                }
            })
            ->editColumn('courses', function ($q) {
                return $q->courses->count();
            })
            ->editColumn('status', function ($q) {
                return ($q->status == 1) ? "Enabled" : "Disabled";
            })
            ->rawColumns(['actions', 'icon'])
            ->make();
    }

    /**
     * Show the form for creating new Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('category_create')) {
            return abort(401);
        }
        $blankArr = array("" => "Please select");
        $track = $blankArr;
        $courses = \App\Models\Course::ofTeacher()->get();
        $courses_ids = $courses->pluck('id');
        $courses = $courses->pluck('title', 'id')->prepend('Please select', '');
        $lessons = \App\Models\Lesson::whereIn('course_id', $courses_ids)->get()->pluck('title', 'id')->prepend('Please select', '');
        $ministry = Ministry::where('status', '=', 1)->pluck('ministry_name', 'id');
        if(auth()->user()->is_admin == 1){
            $userId = auth()->user()->id;
            $userdetails = DB::table('user_details')->where('user_id', '=', $userId)->get();
            $deptId = $userdetails[0]->department_id;
            $departments = Departments::where('id', '=', $deptId)->pluck('department_name', 'id');
            $track = DB::table("tracks")->where("department_id",$deptId)->select("name","id")->pluck('name','id');
        }else{
            $departments = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
        }
        $locations = Locations::where('status', '=', 1)->pluck('office_name', 'id');
        return view('backend.categories.create', compact('courses', 'lessons','ministry','departments','locations','track'));
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param  \App\Http\Requests\StoreCategorysRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoriesRequest $request)
    {
        $this->validate($request, [
        ]);

        if (!Gate::allows('category_create')) {
            return abort(401);
        }
        $category = Category::where('slug','=',str_slug($request->name))->first();
        if($category == null){
            $category = new  Category();
        }
        $category->name = $request->name;
        $category->slug = str_slug($request->name);
        $category->short_name = $request->short_name;
        $category->icon = $request->icon;
        $category->department_id = $request->department_id;
        $category->track_id = $request->tracks;
        $category->moodle_cat_ref_id = "0";
        $category->status = $request->status;
        $category->save();
		$insertedId = $category->id;
		
		$ministry_id = array_filter((array)$request->input('ministry_id'));	
       foreach ($ministry_id as $key) {
        $ministrycategories = new MinistryCategories;
        $ministrycategories->ministry_id=$key;
        $ministrycategories->cat_id=$insertedId;
        $ministrycategories->save();
        }
		$department_id = array_filter((array)$request->input('department_id'));
		 foreach ($department_id as $key) {
        $departmentcategories = new DepartmentCategories;
        $departmentcategories->department_id=$key;
        $departmentcategories->cat_id=$insertedId;
        $departmentcategories->save();
        }
		$office_id = array_filter((array)$request->input('office_id'));
		 foreach ($office_id as $key) {
        $officecategories = new OfficeCategories;
        $officecategories->office_id=$key;
        $officecategories->cat_id=$insertedId;
        $officecategories->save();
        }
		
        return redirect()->route('admin.categories.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Category.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('category_edit')) {
            return abort(401);
        }
        $courses = \App\Models\Course::ofTeacher()->get();
        $courses_ids = $courses->pluck('id');
        $courses = $courses->pluck('title', 'id')->prepend('Please select', '');
        $lessons = \App\Models\Lesson::whereIn('course_id', $courses_ids)->get()->pluck('title', 'id')->prepend('Please select', '');
        $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
        $category = DB::table('categories')->where('id',$id)->first();
        $track = DB::table("tracks")
//                    ->where("department_id",$id)
                    ->select("name","id")
                    ->pluck('name','id');
                
        return view('backend.categories.edit', compact('category', 'courses', 'lessons', 'department', 'track'));
    }

    /**
     * Update Category in storage.
     *
     * @param  \App\Http\Requests\UpdateCategorysRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoriesRequest $request, $id)
    {
        if (!Gate::allows('category_edit')) {
            return abort(401);
        }

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = str_slug($request->name);
        $category->short_name = $request->short_name;
        $category->icon = $request->icon;
        $category->department_id = $request->department_id;
        $category->track_id = $request->tracks;
        $category->save();

        return redirect()->route('admin.categories.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


    /**
     * Display Category.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('category_view')) {
            return abort(401);
        }
        $category = Category::findOrFail($id);

        return view('backend.categories.show', compact('category'));
    }


    /**
     * Remove Category from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //if (!Gate::allows('category_delete')) {
          //  return abort(401);
        //}
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Category at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('category_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Category::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Category from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('category_delete')) {
            return abort(401);
        }
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('admin.categories.index')->withFlashSuccess(trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Category from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('category_delete')) {
            return abort(401);
        }
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()->route('admin.categories.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
	
		   
		   
 //////////////////////////////////////////////////////////////////////unpublish Category
	
   public function unpublish($id)
    {
		$status=0;
	    $category = Category::findOrFail($id);
        $category->status = $status;
        $category->update();
        return redirect()->route('admin.categories.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish Category	
	  public function publish($id)
    {
		$status=1;
	    $category = Category::findOrFail($id);
        $category->status = $status;
        $category->update();
        return redirect()->route('admin.categories.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }	
    
   public function officeFilter($id)
    {
        $tracks = DB::table("tracks")
                    ->where("department_id",$id)
                    ->select("name","id")
                    ->pluck('name','id');
                return json_encode($tracks);
    }
	
}
