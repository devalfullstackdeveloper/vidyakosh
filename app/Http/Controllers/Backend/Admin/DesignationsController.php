<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreDesignationsRequest;
use App\Http\Requests\Admin\UpdateDesignationsRequest;
use App\Models\Designations;
use App\Models\Departments;
use App\Models\Ministry;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;


class DesignationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designations = Designations::all();
        
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }
        
        return view('backend.designations.index', compact('designations','officeLocation'));
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
        $designations = "";
		//$departments =Departments::orderBy('id', 'desc')->get();
		$designations=DB::table('designations')
                    ->join('departments','departments.id','=','designations.department_id')
                    ->select('designations.id','designations.designation','designations.status','departments.department_name')	
                    ->orderBy('designations.id', 'desc')->get();
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


        return DataTables::of($designations)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.designations', 'label' => 'designation', 'value' => $q->id]);
                }          

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.designations.edit', ['designations' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.designations.destroy', ['designations' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
				
			   if ($has_publish || $has_unpublish) {
						if($q->status == 1){
                    $publish = view('backend.datatable.action-publish')
                        ->with(['route' => route('admin.designations.unpublish', ['designations' => $q->id])])
                        ->render();
                    $view .= $publish;
						}else{
					   $unpublish = view('backend.datatable.action-unpublish')
                        ->with(['route' => route('admin.designations.publish', ['designations' => $q->id])])
                        ->render();
                    $view .= $unpublish;		
						}
                }

                return $view;

            })
          //  ->editColumn('status', function ($q) {
				
              //  return ($q->status == 1) ? "Enabled" : "Disabled";
         //   })
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
                 $designations = Designations::where('status', '=', 1)->pluck('designation', 'id')->prepend('Please select', '');
        }else{
                $departments = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
                $designations = Designations::where('status', '=', 1)->pluck('designation', 'id')->prepend('Please select', '');
        }
       return view('backend.designations.create',compact('departments','designations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDesignationsRequest $request)
    {
    $designations = Designations::create($request->all());
    $designations->save();
	return redirect()->route('admin.designations.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function show(Designations $designations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
                $designation = Designations::where('status', '=', 1)->pluck('designation', 'id')->prepend('Please select', '');
        }else{
                $departments = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
                $designation = Designations::where('status', '=', 1)->pluck('designation', 'id')->prepend('Please select', '');
                 
        }
        $designations = Designations::findOrFail($id);
        $parentArr = Designations::where('status', '=', 1)->where('department_id',$designations->department_id)->pluck('designation', 'id');
        if(count($parentArr) == 0){
            $parentArr = array(""=>"Please select","0"=>"Root");
        }
        return view('backend.designations.edit', compact('designations','departments','designation','parentArr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDesignationsRequest $request, $id)
    {
        $designations = Designations::findOrFail($id);
        $designations->update($request->all());

       $designations->save();
       return redirect()->route('admin.designations.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         DB::table('designations')->where('id', $id)->delete(); 
       return redirect()->route('admin.designations.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
	



//////////////////////////////////////////////////////////////////////unpublish Designations
	
   public function unpublish($id)
    {
		$status=0;
	    $designations = Designations::findOrFail($id);
        $designations->status = $status;
        $designations->update();
        return redirect()->route('admin.designations.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish Designations	
	  public function publish($id)
    {
		$status=1;
	    $designations = Designations::findOrFail($id);
        $designations->status = $status;
        $designations->update();
        return redirect()->route('admin.designations.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
 public function departmentFilter($id)
    {
        $departments = DB::table("departments")
                    ->where("ministry_id",$id)
                    ->where('status', 1)
                    ->select("department_name","id")
                    ->pluck('department_name','id');
                return json_encode($departments);
    }
	
	 public function officeFilter($id)
    {
        $locations = DB::table("locations")
                    ->where("department_id",$id)
                    ->where('status', 1)
                    ->select("office_name","id")
                    ->pluck('office_name','id');
                return json_encode($locations);
    }

	public function designation_ajax($id)
    {  
        $designation = Designations::where('status', '=', 1)->where('department_id',$id)->where('status', 1)->pluck('designation', 'id');
        
        if(count($designation) == 0){
            $designation = array("0"=>"Root");
        }
        return json_encode($designation);
    }
	
    public function filterdesignation($id)
    {
        $designation = Designations::where('status', '=', 1)->where('id',$id)->where('status', 1)->first();  
        $deptId = $designation->department_id;
        ///return $deptId;
        $designation = Designations::where('status', '=', 1)->where('department_id','=',$deptId)->where('status', 1)->pluck('designation', 'id')->prepend('Please select', '');
        return json_encode($designation);
    }
}
