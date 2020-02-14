<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreOfficeorderRequest;
use App\Http\Requests\Admin\UpdateFacultyRequest;
use App\Models\Designations;
use App\Models\Ministry;
use App\Models\Officeorder;
use App\Models\InstituteIndustry;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use App\Models\Departments;
use Carbon\Carbon;
use Auth; 
use Illuminate\Support\Facades\Redirect;


class OfficeorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $faculty = DB::table('faculty')->get();
         //return view('backend.officeorder.index', compact('faculty'));
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
        
        $status  = DB::table('tab_training_status')
        ->join('crttrainings','tab_training_status.crt_id','=','crttrainings.id')
        ->join('users','users.id','=','tab_training_status.reportingmanager_id')
        ->join('states','crttrainings.state_id','=','states.id')
        ->select('tab_training_status.id','tab_training_status.nominate_date as statusdate','tab_training_status.status as status','crttrainings.title as title','users.first_name as name','users.emp_code','users.email','states.state')
        ->get();
//        if (auth()->user()->isAdmin() || auth()->user()->is_admin == 1) {
//            $has_view = true;
//            $has_edit = true;
//            $has_delete = true;
//            $has_publish = true;
//            $has_unpublish = true;
//        }
        return DataTables::of($status)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.faculty', 'label' => 'faculty', 'value' => $q->id]);
                }          

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.officeorder.edit', ['faculty' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.officeorder.destroy', ['faculty' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                
               // if ($has_publish || $has_unpublish) {
               //          if($q->status == 1){
               //      $publish = view('backend.datatable.action-publish')
               //          ->with(['route' => route('admin.faculty.unpublish', ['faculty' => $q->id])])
               //          ->render();
               //      $view .= $publish;
               //          }else{
               //         $unpublish = view('backend.datatable.action-unpublish')
               //          ->with(['route' => route('admin.faculty.publish', ['faculty' => $q->id])])
               //          ->render();
               //      $view .= $unpublish;        
               //          }
               //  }

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
            $institute_industry = DB::table("institute_industry")->where("department_id",$deptId)->select("name","id")->pluck('name','id')->prepend('Please select', '');
        }else{
            $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
        }
        $subject =  DB::table("subject")->select("name","id")->pluck('name','id');
       return view('backend.officeorder.create',compact('department', 'institute_industry', 'subject'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(StoreOfficeorderRequest $request)
    // {
        
    //     $nomination_type = $request->input('nomination_type');
    //     $department_id = $request->input('department_id');
    //     $action = ($request->input('action') != "") ? $request->input('action') : "";
    //     $training_id = $request->input('training_id');
    //     $signing_authority = $request->input('signing_authority');
    //     $file_no = $request->input('file_no');
    //     $emp_code = $request->input('emp_code');
        
    //     DB::table('office_order')->insert(
    //         [   
    //             'nomination_type' => $nomination_type, 
    //             'department_id' => $department_id,
    //             'action' => $action,
    //             'sign_user_id' => $signing_authority,
    //             'training_id' => $training_id,
    //             'file_no' => $file_no,
    //             'emp_code' => $emp_code
    //         ]
    //     );
        
    // return redirect()->route('admin.officeorder.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    // }

public function store(Request $request)
{

          $nomination_type =  $_POST['nomination_type']; 
           $department_id =  $_POST['department_id']; 
           $training_id =  $_POST['training_id']; 
          $signing_authority =  $_POST['signing_authority'];
          $file_no =  $_POST['file_no'];
          $userid =  $_POST['userid'];
         $designationid =  $_POST['designationid'];
          $empcode =  $_POST['empcode'];
          $loginuserid = Auth::user()->id; 
          DB::table('officeorder')->insert( 
       ['nomination_type' => $nomination_type,'department_id' => $department_id,'training_id' => $training_id,'signing_authority' => $signing_authority,'file_no' => $file_no,'userid' => $userid,'designationid' => $designationid,'empcode' => $empcode,'loginuserid'=>$loginuserid]); 
          return Redirect::back(); 
}
    /**
     * Display the specified resource.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function show()
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
        $faculty = DB::table('faculty')
                ->join('departments','faculty.department_id','=','departments.id')
                ->where('faculty.id',$id)
                ->select('faculty.id','faculty.name','faculty.status','faculty.institute_industry_id', 'departments.department_name','faculty.designation', 'faculty.mobile','faculty.email', 'faculty.address', 'faculty.department_id as deptid')
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
            $institute_industry = DB::table("institute_industry")->where("department_id",$deptId)->select("name","id")->pluck('name','id')->prepend('Please select', '');
        }else{
            $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
            $institute_industry = DB::table("institute_industry")->select("name","id")->pluck('name','id')->prepend('Please select', '');
        }
        $subject = DB::table("subject")->select("name","id")->pluck('name','id')->prepend('Please select', '');
        $fac_sub = DB::table("faculty_subject")->where('faculty_id',$id)->select("subject_id")->get();
        
        $faculty_subject = array();
        foreach ($fac_sub as $key => $value) {
            $faculty_subject[] = $value->subject_id;
        }
        
//        $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
        
//        $institute_industry = InstituteIndustry::where('status', '=', 1)->pluck('name', 'id')->prepend('Please select', '');
        return view('backend.officeorder.edit', compact('faculty', 'department', 'institute_industry', 'subject', 'faculty_subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFacultyRequest $request, $id)
    {   

        $department_id = $request->department_id;
        $institute_industry_id = $request->institute_industry_id;
        $name = $request->name;
        $role = "Teacher";
        $designation = $request->designation;
        $mobile = $request->mobile;
        $email = $request->email;
        $address = $request->address;
        $status = $request->status;
        
        DB::table('faculty')
        ->where('id', $id)  
        ->update(array(
                        'department_id' => $department_id, 
                        'institute_industry_id' => $institute_industry_id, 
                        'name' => $name,
                        'role' => $role,
                        'designation' => $designation,
                        'mobile' => $mobile,
                        'email' => $email,
                        'address' => $address,
                        'status' => $status
                    ));
        
        DB::table('faculty_subject')->where('faculty_id', '=', $id)->delete();
        foreach ($request->subject_id as $subjectId) {
            if($subjectId != ""){
                $faculty_subject = DB::table('faculty_subject')->insert(
                    [
                    'faculty_id' => $id, 
                    'subject_id' => $subjectId, 
                    ]
                );
            }
        }
        
        
        
        return redirect()->route('admin.officeorder.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       DB::table('faculty')->where('id', $id)->delete(); 
       return redirect()->route('admin.officeorder.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
    



//////////////////////////////////////////////////////////////////////unpublish Designations
    
   public function unpublish($id)
    {
        $status=0;
        $designations = Year::findOrFail($id);
        $designations->status = $status;
        $designations->update();
        return redirect()->route('admin.officeorder.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish Designations 
      public function publish($id)
    {
        $status=1;
        $designations = Year::findOrFail($id);
        $designations->status = $status;
        $designations->update();
        return redirect()->route('admin.officeorder.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
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
        $locations = DB::table("institute_industry")
                    ->where("department_id",$id)
                    ->select("name","id")
                    ->pluck('name','id');
                return json_encode($locations);
    }
     public function removeNominationFilter($id)
    {
         $ids = explode(",", $id);
         foreach ($ids as $key => $value) {
             if($value != ""){
                 DB::table('office_order')->where('id', '=', $value)->delete();
             }
         }
        return "success";
    }
    
     public function empcodeFilter($id)
    {    
        $users = DB::table("users")
                    ->where("emp_code",$id)
                    ->select("first_name","emp_code","email")
                    ->get();
                return json_encode($users);
    }
     public function showRemoveFilter($id)
    {    
         $ids = explode(",", $id);
         $dept_id = $ids[0];
         $traing_id = $ids[1];
         
        $showRemove = DB::table("office_order")
                    ->where("department_id",$dept_id)
                    ->where("training_id",$traing_id)
                    ->where("nomination_type",1)
                    ->where("action",0)
                    ->select("emp_code","id")
                    ->get();
        
        $userArr = array();
            foreach ($showRemove as $key => $value) {
                $users = DB::table("users")
                    ->where("emp_code",$value->emp_code)
                    ->select("first_name","emp_code","email")
                    ->get();
                $userArr[$value->id] = $users;
            }
                return json_encode($userArr);
    }
    
     public function signFilter($id)
    {
         $signArr = array();
        $signs = DB::table("signs")
                    ->where("department_id",$id)
                    ->select("officer_id","id")
                    ->get();
        
        foreach ($signs as $key => $value) {
            $users = DB::table("users")
                ->where("id",$value->officer_id)
                ->select("first_name","id","emp_code")
                ->get();
            $signArr['signs'][$users[0]->id] = $users[0]->emp_code." | ".$users[0]->first_name;
        }
        
        $status  = DB::table('tab_training_status')
        ->join('crttrainings','tab_training_status.crt_id','=','crttrainings.id')
        ->join('users','users.id','=','tab_training_status.reportingmanager_id')
        ->select('crttrainings.id','tab_training_status.nominate_date as statusdate','tab_training_status.status as status','crttrainings.title as title','users.first_name as name')
        ->where('crttrainings.department_id','=', $id)
        ->get(); 
        
        foreach ($status as $key => $value) {
            $signArr['training'][$value->id] = $value->title;
        }
            return json_encode($signArr);
    }
public function trainingFilter($id)
{
    //return $id;
        $dt = Carbon::now();
        $data  = DB::table('tab_training_status')
        ->join('crttrainings','tab_training_status.crt_id','=','crttrainings.id')
        ->join('users','users.id','=','tab_training_status.user_id')
        //->join('crt_designations','crttrainings.id','=','crt_designations.crt_id')
        
        ->join('user_details','users.id','=','user_details.user_id')
		->join('designations','user_details.designation_id','=','designations.id')
         ->select('tab_training_status.id','crttrainings.title as title','users.first_name as name','designations.designation','users.emp_code as empcode','users.id as userid','users.email as email','users.state as state','designations.id as designationid')
         //->where('tab_training_status.status','=', 3)
         //->whereDate('crttrainings.start_date','<=', $dt)
        // ->whereDate('crttrainings.lastnominne','>', $dt)
        ->where('crttrainings.id', '=', $id)
        ->get(); 
        return json_encode($data);

}
public function training_office_order_ajax($departmentid, $traingid)
{
      $data  = DB::table('officeorder')
              ->join('users','users.id','=','officeorder.userid')
              ->join('designations','designations.id','=','officeorder.designationid') 
              ->join('crttrainings','officeorder.training_id','=','crttrainings.id')
              ->where('officeorder.department_id','=',$departmentid) 
              ->where('officeorder.training_id','=',$traingid)
               ->where('officeorder.status','=',1)
              ->select('users.id as id','users.first_name as name','designations.designation','crttrainings.corempcode as empcode','users.email as email','users.state as state') 
              ->get();   
              return  $data;
}

public function update_ajax($id)
{   
    $status = 0;
   
    DB::table('officeorder')
            ->where('officeorder.userid', $id)
            ->update(['status' => $status]);
    return json_encode(true);
}
    public function partialadd_ajax($id)
    {
        //return $id;
 $dt = Carbon::now();
        $data  = DB::table('tab_training_status')
        ->join('crttrainings','tab_training_status.crt_id','=','crttrainings.id')
        ->join('users','users.id','=','tab_training_status.user_id')
        ->join('crt_designations','crttrainings.id','=','crt_designations.crt_id')
        ->join('designations','crt_designations.designation_id','=','designations.id')
         ->select('tab_training_status.id','crttrainings.title as title','users.first_name as name','designations.designation','crttrainings.corempcode as empcode','users.id as userid','users.email as email','users.state as state','designations.id as designationid')
         ->where('tab_training_status.status','=', 3)
         ->whereDate('crttrainings.start_date','<=', $dt)
         ->whereDate('crttrainings.end_date','>', $dt)
        ->where('crttrainings.id', '=', $id)
        ->get(); 
        return json_encode($data);
    }


    public function partialsave($deptid,$trainingid,$fileno,$id)
    {
        $loginuserid = Auth::user()->id;
        DB::table('officeorder')->insert( 
       ['department_id' => $deptid,'training_id' => $trainingid,'file_no' => $fileno,'userid' => $id,'loginuserid'=>$loginuserid]); 
    }
    
}
