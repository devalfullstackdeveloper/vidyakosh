<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreDepartmentsRequest;
use App\Http\Requests\Admin\UpdateDepartmentsRequest;
use App\Models\Departments;
use App\Models\Ministry;
use DB;
use function foo\func;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Departments::all();
        return view('backend.departments.index', compact('departments'));
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
        $departments = "";
		//$departments =Departments::orderBy('id', 'desc')->get();
		$departments=DB::table('departments')
                     ->join('ministry','ministry.id','=','departments.ministry_id')
                     ->select('departments.id','departments.department_name','departments.status','departments.logo','ministry.ministry_name')	
					 ->orderBy('departments.id', 'desc')->get();
        if (auth()->user()->isAdmin() || auth()->user()->is_admin == 1) {
            $has_view = true;
            $has_edit = true;
            $has_delete = true;
			$has_publish = true;
			$has_unpublish = true;
        }


        return DataTables::of($departments)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.departments', 'label' => 'department', 'value' => $q->id]);
                }          

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.departments.edit', ['department' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.departments.destroy', ['department' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
					 if ($has_publish || $has_unpublish) {
						if($q->status == 1){
                    $publish = view('backend.datatable.action-unpublish')
                        ->with(['route' => route('admin.departments.unpublish', ['department' => $q->id])])
                        ->render();
                    $view .= $publish;
						}else{
					   $unpublish = view('backend.datatable.action-publish')
                        ->with(['route' => route('admin.departments.publish', ['department' => $q->id])])
                        ->render();
                    $view .= $unpublish;		
						}
                }

                return $view;

            })
            ->editColumn('status', function ($q) {
				
                return ($q->status == 1) ? "Enabled" : "Disabled";
            })
            ->rawColumns(['actions', 'image'])
            ->make();
    }
	

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	   $ministry = Ministry::where('status', '=', 1)->pluck('ministry_name', 'id')->prepend('Please select', '');
       return view('backend.departments.create',compact('ministry'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartmentsRequest $request)
    {
	//$data=$request->all();
	
	    $ministry_id = $request->input('ministry_id');
		$department_name = $request->input('department_name');
		$image = $request->file('logo');
		$status = $request->input('status');
		
    	if($image){
    		$image_name = str_random(20);
    		$ext = strtolower($image->getClientOriginalExtension());
    		$image_full_name = $image_name.'.'.$ext;
    		$upload_path = 'department-logo/';
    		$image_url = $upload_path.$image_full_name;
    		$success = $image->move($upload_path,$image_full_name);
		
		}
		$departments = new Departments;
        $departments->ministry_id=$ministry_id;
		$departments->department_name=$department_name;
        $departments->logo=$image_full_name;
		$departments->status=$status;
		$departments->save();
	
	return redirect()->route('admin.departments.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function show(Departments $departments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		
		$ministry = Ministry::where('status', '=', 1)->pluck('ministry_name', 'id');
		//echo "<pre>";
		//print_r($ministry); exit;
        $departments = Departments::findOrFail($id);
        return view('backend.departments.edit', compact('ministry','departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartmentsRequest $request, $id)
    {
       $departments = Departments::findOrFail($id);
       $departments->update($request->all());

       $departments->save();
       return redirect()->route('admin.departments.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Departments::findOrFail($id);
        $course->delete();
        return redirect()->route('admin.departments.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
	
	
	//////////////////////////////////////////////////////////////////////unpublish ministry
	
   public function unpublish($id)
    {
		$status=0;
	    $departments = Departments::findOrFail($id);
        $departments->status = $status;
        $departments->update();
        return redirect()->route('admin.departments.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish ministry	
	  public function publish($id)
    {
		$status=1;
	    $departments = Departments::findOrFail($id);
        $departments->status = $status;
        $departments->update();
        return redirect()->route('admin.departments.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
	
	
}
