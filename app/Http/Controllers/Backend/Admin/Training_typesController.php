<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreTrainingtypeRequest;
use App\Http\Requests\Admin\UpdateTrainingtypeRequest;
use App\Models\Designations;
use App\Models\Faculty;
use App\Models\Training_types;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use App\Models\Departments;


class Training_typesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $training_types = DB::table('training_types')->get();
       
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }
       
        return view('backend.training_types.index', compact('training_types','officeLocation'));
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
        $faculty = "";
        //$departments =Departments::orderBy('id', 'desc')->get();
        $faculty=DB::table('training_types')
                     ->join('departments','training_types.department_id','=','departments.id')
                     ->select('training_types.id','training_types.title as training_types_name','training_types.status','departments.department_name')    
                     ->orderBy('training_types.id', 'desc')->get();
        
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }
        
        if (auth()->user()->isAdmin() || (auth()->user()->is_admin == 1 && $officeLocation == 0)) {
            $has_view = true;
            $has_edit = true;
            $has_delete = true;
            $has_publish = true;
            $has_unpublish = true;
        }

        return DataTables::of($faculty)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.training_types', 'label' => 'training_types', 'value' => $q->id]);
                }          

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.training_types.edit', ['training_types' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.training_types.destroy', ['training_types' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                
               if ($has_publish || $has_unpublish) {
                        if($q->status == 1){
                    $publish = view('backend.datatable.action-unpublish')
                        ->with(['route' => route('admin.training_types.unpublish', ['training_types' => $q->id])])
                        ->render();
                    $view .= $publish;
                        }else{
                       $unpublish = view('backend.datatable.action-publish')
                        ->with(['route' => route('admin.training_types.publish', ['training_types' => $q->id])])
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
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }
        
	if(auth()->user()->is_admin == 1 && $officeLocation == 0){
            $userId = auth()->user()->id;
            $userdetails = DB::table('user_details')->where('user_id', '=', $userId)->get();
            $deptId = $userdetails[0]->department_id;
            $departments = Departments::where('id', '=', $deptId)->pluck('department_name', 'id');
        }else{
            $departments = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
        }	
//       $departments = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
       return view('backend.training_types.create',compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingtypeRequest $request)
    {
		
		 $training_types = Training_types::create($request->all());
	
			$training_types->save();
    return redirect()->route('admin.training_types.index')->withFlashSuccess(trans('alerts.backend.general.created'));
	}
		
   
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {           

       $training_types = DB::table('training_types')->where('id',$id)->first();
       
       /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }
       
       if(auth()->user()->is_admin == 1 && $officeLocation == 0){
            $userId = auth()->user()->id;
            $userdetails = DB::table('user_details')->where('user_id', '=', $userId)->get();
            $deptId = $userdetails[0]->department_id;
            $departments = Departments::where('id', '=', $deptId)->pluck('department_name', 'id');
        }else{
            $departments = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
        }
//		$departments = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
        return view('backend.training_types.edit', compact('training_types', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingtypeRequest $request, $id)
    {
       
        $department_id = $request->department_id;
        $title = $request->title;
        $status = $request->status;
        DB::table('training_types')
        ->where('id', $id)  
        ->update(array('department_id' => $department_id, 
                        'title' => $title,
                        'status' => $status
                    ));
        return redirect()->route('admin.training_types.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       DB::table('training_types')->where('id', $id)->delete(); 
       return redirect()->route('admin.training_types.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
    



//////////////////////////////////////////////////////////////////////unpublish Designations
    
   public function unpublish($id)
    {
        $status = 0;
        DB::table('training_types')
            ->where('id', $id)
            ->update(['status' => $status]);
        return redirect()->route('admin.training_types.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish Designations 
      public function publish($id)
    {
        $status=1;
      DB::table('training_types')
            ->where('id', $id)
            ->update(['status' => $status]);
        return redirect()->route('admin.training_types.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
    










    
 public function departmentFilter($id)
    {
        $departments = DB::table("departments")
                    ->where("ministry_id",$id)
                    ->select("department_name","id")
                    ->pluck('department_name','id');
                return json_encode($departments);
    }
    
     public function officeFilter($id)
    {
        $locations = DB::table("locations")
                    ->where("department_id",$id)
                    ->select("office_name","id")
                    ->pluck('office_name','id');
                return json_encode($locations);
    }

    
    
}
