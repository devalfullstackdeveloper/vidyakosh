<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\storeOrganizationDepartmentsRequest;
use App\Http\Requests\Admin\UpdateOrganizationDepartmentsRequest;
use App\Models\Designations;
use App\Models\Ministry;
use App\Models\OrganizationDepartments;
use App\Models\InstituteIndustry;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use App\Models\Departments;


class OrganizationDepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organization_departments = DB::table('organization_departments')->get();
        
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }
        
        return view('backend.organization_departments.index', compact('organization_departments','officeLocation'));
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
        $organization_departments = "";
        //$departments =Departments::orderBy('id', 'desc')->get();
        $organization_departments=DB::table('organization_departments')
                     ->join('departments','organization_departments.department_id','=','departments.id')
                     ->select('organization_departments.id','departments.department_name', 'organization_departments.department_name','organization_departments.is_group', 'organization_departments.status')    
                     ->orderBy('organization_departments.id', 'desc')->get();
        
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

        return DataTables::of($organization_departments)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.organization_departments', 'label' => 'organization_departments', 'value' => $q->id]);
                }          

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.organization_departments.edit', ['organization_departments' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.organization_departments.destroy', ['organization_departments' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                if ($has_publish || $has_unpublish) {
                        if($q->status == 1){
                    $publish = view('backend.datatable.action-unpublish')
                        ->with(['route' => route('admin.organization_departments.unpublish', ['organization_departments' => $q->id])])
                        ->render();
                    $view .= $publish;
                        }else{
                       $unpublish = view('backend.datatable.action-publish')
                        ->with(['route' => route('admin.organization_departments.publish', ['organization_departments' => $q->id])])
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
        return view('backend.organization_departments.create',compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeOrganizationDepartmentsRequest $request)
    {
        
        $groupId = 0;
        if($request->parent_id != ""){
            $groupId = $request->parent_id;
        }
        $organizationDepartments = new OrganizationDepartments();
        $organizationDepartments->department_id = $request->department_id;
        $organizationDepartments->department_name = $request->department_name;
        $organizationDepartments->is_group = $request->is_group;
        $organizationDepartments->parent_id = $groupId;
        $organizationDepartments->status = $request->status;
        $organizationDepartments->save();
        
//        $insertedId = $organizationDepartments->id;
//        
//        if($request->department_head != "" && $request->department_head != NULL){
//            if(count($request->department_head) > 0){
//                foreach ($request->department_head as $key => $value) {
//                    DB::table('organization_departments_user')->insert(['organization_departments_id' => $insertedId, 'user_id' => $value]);
//                }
//            }
//        }
        
        return redirect()->route('admin.organization_departments.index')->withFlashSuccess(trans('alerts.backend.general.created'));
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
        $organization_departments = DB::table('organization_departments')
                ->join('departments','organization_departments.department_id','=','departments.id')
                ->where('organization_departments.id',$id)
                ->select('organization_departments.id', 'departments.department_name', 'organization_departments.department_id as deptid','organization_departments.status','organization_departments.department_name', 'organization_departments.is_group', 'organization_departments.parent_id')
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
        
        $groupArr = DB::table('organization_departments')->where('department_id',$organization_departments->deptid)->select('department_name','id')->pluck('department_name','id')->prepend('Please select', '');
        
        return view('backend.organization_departments.edit', compact('organization_departments', 'department','groupArr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrganizationDepartmentsRequest $request, $id)
    {
        $groupId = 0;
        if($request->parent_id != ""){
            $groupId = $request->parent_id;
        }
        $department_id = $request->department_id;
        $department_name = $request->department_name;
        $is_group = $request->is_group;
        $parent_id = $groupId;
        $status = $request->status;
        
        DB::table('organization_departments')
        ->where('id', $id)  
        ->update(array(
                        'department_id' => $department_id, 
                        'department_name' => $department_name, 
                        'is_group' => $is_group, 
                        'parent_id' => $parent_id,
                        'status' => $status
                    ));
        
        DB::table('organization_departments_user')->where('organization_departments_id', '=', $id)->delete();
        
        if($request->department_head != "" && $request->department_head != NULL){
            if(count($request->department_head) > 0){
                foreach ($request->department_head as $key => $value) {
                    DB::table('organization_departments_user')->insert(['organization_departments_id' => $id, 'user_id' => $value]);
                }
            }
        }
         
        return redirect()->route('admin.organization_departments.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       DB::table('organization_departments')->where('id', $id)->delete(); 
       return redirect()->route('admin.organization_departments.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
    



//////////////////////////////////////////////////////////////////////unpublish Designations
    
   public function unpublish($id)
    {
        $status=0;
        DB::table('organization_departments')
            ->where('id', $id)
            ->update(['status' => $status]);
        return redirect()->route('admin.organization_departments.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

///////////////////////////////////////////////////////////////////////publish Designations 
      public function publish($id)
    {
        $status=1;
        DB::table('organization_departments')
            ->where('id', $id)
            ->update(['status' => $status]);
        return redirect()->route('admin.organization_departments.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
    
     public function officeFilter($id)
    {   
        $group = DB::table("organization_departments")
                    ->where("department_id",$id)
                    ->where("status",1)
                    ->select("department_name","id")
                    ->pluck('department_name','id');
            
        return json_encode($group);
    }

    
    
}
