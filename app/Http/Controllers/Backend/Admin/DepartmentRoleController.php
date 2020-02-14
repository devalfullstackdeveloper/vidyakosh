<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\storeDepartmentRoleRequest;
use App\Http\Requests\Admin\UpdateDepartmentRoleRequest;
use App\Models\Designations;
use App\Models\Ministry;
use App\Models\DepartmentRole;
use App\Models\InstituteIndustry;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use App\Models\Departments;


class DepartmentRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department_role = DB::table('department_role')->get();
        
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }
        
        return view('backend.department_role.index', compact('department_role','officeLocation'));
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
        $department_role = "";
        //$departments =Departments::orderBy('id', 'desc')->get();
        $department_role=DB::table('department_role')
                     ->join('departments','department_role.department_id','=','departments.id')
                     ->select('department_role.id','departments.department_name', 'department_role.role_name', 'department_role.status')    
                     ->orderBy('department_role.id', 'desc')->get();
        
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

        return DataTables::of($department_role)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.department_role', 'label' => 'department_role', 'value' => $q->id]);
                }          

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.department_role.edit', ['department_role' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.department_role.destroy', ['department_role' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                if ($has_publish || $has_unpublish) {
                        if($q->status == 1){
                    $publish = view('backend.datatable.action-unpublish')
                        ->with(['route' => route('admin.department_role.unpublish', ['department_role' => $q->id])])
                        ->render();
                    $view .= $publish;
                        }else{
                       $unpublish = view('backend.datatable.action-publish')
                        ->with(['route' => route('admin.department_role.publish', ['department_role' => $q->id])])
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
        $blankArr = array("" => "Please select");
        $institute_industry =  $blankArr;
        $subject =  array();
        
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
            $department = Departments::where('id', '=', $deptId)->pluck('department_name', 'id')->prepend('Please select', '');
        }else{
            $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
        }
        $parent_id = array("" =>"Please Select");
       return view('backend.department_role.create',compact('department','parent_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeDepartmentRoleRequest $request)
    {
        $departmentRole = new DepartmentRole();
        $departmentRole->department_id = $request->department_id;
        $departmentRole->parent_id = $request->parent_id;
        $departmentRole->role_name = $request->role_name;
        $departmentRole->status = $request->status;
        $departmentRole->save();
        
        return redirect()->route('admin.department_role.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function show(Year $designations)
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
        $departmentRole = DB::table('department_role')
                ->join('departments','department_role.department_id','=','departments.id')
                ->where('department_role.id',$id)
                ->select('department_role.id', 'departments.department_name', 'department_role.department_id as deptid','department_role.status','department_role.role_name','department_role.parent_id')
                ->first();
        
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
            $department = Departments::where('id', '=', $deptId)->pluck('department_name', 'id');
        }else{
            $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
        }
        
        if($departmentRole->parent_id == 0){
            $parentDept = array("0"=>"Root");
        }else{
            $parentDept = DB::table("department_role")
                    ->where("department_id",$departmentRole->deptid)
                    ->select("role_name","id")
                    ->pluck('role_name','id');
        }
        return view('backend.department_role.edit', compact('departmentRole', 'department', 'parentDept'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartmentRoleRequest $request, $id)
    {
        
        $department_id = $request->department_id;
        $parent_id = $request->parent_id;
        $role_name = $request->role_name;
        $status = $request->status;
        
        DB::table('department_role')
        ->where('id', $id)  
        ->update(array(
                        'department_id' => $department_id, 
                        'parent_id' => $parent_id, 
                        'role_name' => $role_name,
                        'status' => $status
                    ));
        
         
        return redirect()->route('admin.department_role.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       DB::table('department_role')->where('id', $id)->delete(); 
       return redirect()->route('admin.department_role.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
    



//////////////////////////////////////////////////////////////////////unpublish Designations
    
   public function unpublish($id)
    {
        $status=0;
        DB::table('department_role')
            ->where('id', $id)
            ->update(['status' => $status]);
        return redirect()->route('admin.department_role.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish Designations 
      public function publish($id)
    {
        $status=1;
        DB::table('department_role')
            ->where('id', $id)
            ->update(['status' => $status]);
        return redirect()->route('admin.department_role.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
    
    public function parentDepartmentFilter($id)
    {
        $departments = DB::table("department_role")
                    ->where("department_id",$id)
                    ->select("role_name","id")
                    ->pluck('role_name','id');
            
            if(count($departments) == 0){
                $departments = array("0"=>"Root");
            }
        
                return json_encode($departments);
    }
    
     public function officeFilter($id)
    {
        $locations = DB::table("institute_industry")
                    ->where("department_id",$id)
                    ->select("name","id")
                    ->pluck('name','id');
                return json_encode($locations);
    }

    
    
}
