<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\UpdateSigningRequest;
use App\Http\Requests\Admin\StoreSigningRequest;
use App\Models\Designations;
use App\Models\Auth\User;
use App\Models\Venue;
use App\Models\Locations;
use App\Models\Userdetail;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use App\Models\Departments;
use App\Models\Sign;


class SigningController extends Controller
{
    
    public function index()
    { 
        $signs = DB::table('signs')->get();
        
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }
        
        return view('backend.signs.index', compact('signs','officeLocation'));
    }
        public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $has_publish = false;
        $has_unpublish = false;
        $tracks = "";
        $signs=DB::table('signs')
                     ->join('departments','signs.department_id','=','departments.id')
                     ->join('users','signs.officer_id','=','users.id')
                     ->select('signs.id','signs.status', 'users.first_name','departments.department_name')    
                     ->orderBy('signs.id', 'desc')->get();
        
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
        return DataTables::of($signs)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.signing', 'label' => 'signs', 'value' => $q->id]);
                }          
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.signing.edit', ['signs' => $q->id])])
                        ->render();
                    $view .= $edit;
                }
                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.signing.destroy', ['signs' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                 if ($has_publish || $has_unpublish) {
                         if($q->status == 1){
                     $publish = view('backend.datatable.action-unpublish')
                         ->with(['route' => route('admin.signing.unpublish', ['signs' => $q->id])])
                         ->render();
                     $view .= $publish;
                         }else{
                        $unpublish = view('backend.datatable.action-publish')
                         ->with(['route' => route('admin.signing.publish', ['sectionofficers' => $q->id])])
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
    
    public function create()
    {
        $blankArr = array("" => "Please select");
        $users =  $blankArr;
        
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
            $office = DB::table('locations')->where('status', 1)->select('office_name', 'id')->where('department_id', '=', $deptId)->pluck('office_name', 'id')->prepend('Please select', '');
        }else{
            $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
            $office = DB::table('locations')->where('status', 1)->select('office_name', 'id')->pluck('office_name', 'id')->prepend('Please select', '');
        }
//       $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
//       $users = User::pluck('first_name', 'id as officer_id')->prepend('Please select', '');
       return view('backend.signs.create',compact('department','users','office'));
    }

    public function store(StoreSigningRequest $request)
    {
    $signs = Sign::create($request->all());
    $signs->save(); 
    return redirect()->route('admin.signing.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

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
            $department = Departments::where('id', '=', $deptId)->pluck('department_name', 'id');
            $office = DB::table('locations')->select('office_name', 'id')->where('department_id', '=', $deptId)->pluck('office_name', 'id')->prepend('Please select', '');
        }else{
            $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
            $office = Locations::where('status', '=', 1)->pluck('office_name', 'id')->prepend('Please select', '');
        }
//        $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
//        $office = Locations::where('status', '=', 1)->pluck('office_name', 'id')->prepend('Please select', '');
        $users =Userdetail::select(DB::raw('CONCAT(users.emp_code, " | ", users.first_name, " | ", designations.designation) AS full_name'), 'users.id')
                        ->join('users','user_details.user_id','=','users.id')
                        ->join('designations','user_details.designation_id','=','designations.id')
                        ->pluck('full_name', 'users.id')
                        ->prepend('Please select', '');
        
        $signs = DB::table('signs')
                    ->join('departments','signs.department_id','=','departments.id')
                    ->join('users','signs.officer_id','=','users.id')
                    ->select('signs.id','signs.department_id as departmentid','signs.status','signs.officer_id as firstname','signs.office_id as office')
                    ->where('signs.id',$id)
                    ->first();

        return view('backend.signs.edit', compact('signs','department','users','office'));
    }
   
    public function update(UpdateSigningRequest $request, $id)
    {
        $department_id = $request->department_id;
        $office_id = $request->office_id;
        $officer_id = $request->officer_id;
        $status = $request->status;
         
        DB::table('signs')
        ->where('id', $id)  
        ->update(array(
                    'department_id' => $department_id,
                    'office_id' => $office_id,
                    'officer_id'=>$officer_id)
                );
        
        return redirect()->route('admin.signing.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
    public function destroy($id)
    {
       DB::table('signs')->where('id', $id)->delete(); 
       return redirect()->route('admin.signing.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }


public function unpublish($id)
    {
        $status=0;
        DB::table('signs')
        ->where('id', $id)  
        ->update(array('status' => $status));
        return redirect()->route('admin.signing.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish Designations 
      public function publish($id)
    {
        $status=1;
       DB::table('signs')
        ->where('id', $id)  
        ->where('status', 1)
        ->update(array('status' => $status));
        return redirect()->route('admin.signing.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
    
    public function departmentFilter($id) 
    {
        /* For Office Location */
        $office = DB::table("locations")
                    ->where("department_id",$id)
                    ->where('status', 1)
                    ->select("office_name","id")
                    ->pluck('office_name','id');
        
        return json_encode($office);
    }
    public function officeFilter($id) 
    {
        //return $id;
		/* For City */
        $office = DB::table("user_details")
                    ->join('users','user_details.user_id','=','users.id')
                    ->join('designations','user_details.designation_id','=','designations.id')
			        ->join('crt_designations','designations.id','=','crt_designations.designation_id')
			        ->select('users.id','users.first_name as officer_name','users.emp_code as emp_code','designations.designation')
                    //->select('designations.designation')
                    ->where('crt_designations.crt_id',$id)
                    ->get();
        
        return json_encode($office);
    }
    
}
