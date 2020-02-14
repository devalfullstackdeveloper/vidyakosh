<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreFacultyRequest;
use App\Http\Requests\Admin\UpdateFacultyRequest;
use App\Models\Designations;
use App\Models\Ministry;
use App\Models\Faculty;
use App\Models\InstituteIndustry;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use App\Models\Departments;


class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faculty = DB::table('faculty')->get();
        
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }
        
        return view('backend.faculty.index', compact('faculty','officeLocation'));
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
        $faculty=DB::table('faculty')
                     ->join('departments','faculty.department_id','=','departments.id')
                     ->join('institute_industry','faculty.institute_industry_id','=','institute_industry.id')
                     ->select('faculty.id','faculty.name','faculty.email','faculty.status','departments.department_name', 'institute_industry.name as institute_industry_name')    
                     ->orderBy('faculty.id', 'desc')->get();
        
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
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.faculty', 'label' => 'faculty', 'value' => $q->id]);
                }          

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.faculty.edit', ['faculty' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.faculty.destroy', ['faculty' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                
                if ($has_publish || $has_unpublish) {
                         if($q->status == 1){
                        $publish = view('backend.datatable.action-unpublish')
                         ->with(['route' => route('admin.faculty.unpublish', ['faculty' => $q->id])])
                         ->render();
                            $view .= $publish;
                         }else{
                        $unpublish = view('backend.datatable.action-publish')
                         ->with(['route' => route('admin.faculty.publish', ['faculty' => $q->id])])
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
            $institute_industry = DB::table("institute_industry")->where("department_id",$deptId)->select("name","id")->pluck('name','id')->prepend('Please select', '');
        }else{
            $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
        }
        $subject =  DB::table("subject")->select("name","id")->pluck('name','id');
//       $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
       return view('backend.faculty.create',compact('department', 'institute_industry', 'subject'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFacultyRequest $request)
    {
        $faculty = new Faculty();
        $faculty->department_id = $request->department_id;
        $faculty->institute_industry_id = $request->institute_industry_id;
        $faculty->name = $request->name;
        $faculty->role = "Teacher";
        $faculty->designation = $request->designation;
        $faculty->mobile = $request->mobile;
        $faculty->email = $request->email;
        $faculty->address = $request->address;
        $faculty->status = $request->status;
        $faculty->save();
        
        $insertedId = $faculty->id;
        foreach ($request->subject_id as $subjectId) {
            if($subjectId != ""){
                $faculty_subject = DB::table('faculty_subject')->insert(
                    [
                    'faculty_id' => $insertedId, 
                    'subject_id' => $subjectId, 
                    ]
                );
            }
        }
        
    return redirect()->route('admin.faculty.index')->withFlashSuccess(trans('alerts.backend.general.created'));
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
        return view('backend.faculty.edit', compact('faculty', 'department', 'institute_industry', 'subject', 'faculty_subject'));
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
        
        
        
        return redirect()->route('admin.faculty.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
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
       return redirect()->route('admin.faculty.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
    



//////////////////////////////////////////////////////////////////////unpublish Designations
    
   public function unpublish($id)
    {
        $status=0;
        DB::table('faculty')
            ->where('id', $id)
            ->update(['status' => $status]);
        return redirect()->route('admin.faculty.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish Designations 
      public function publish($id)
    {
        $status=1;
         DB::table('faculty')
            ->where('id', $id)
            ->update(['status' => $status]);
        return redirect()->route('admin.faculty.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
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

    
    
}
