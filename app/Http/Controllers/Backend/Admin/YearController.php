<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreYearRequest;
use App\Http\Requests\Admin\UpdateYearRequest;
use App\Models\Designations;
use App\Models\Ministry;
use App\Models\Year;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use App\Models\Departments;


class YearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $years = DB::table('years')->get();
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }

        return view('backend.years.index', compact('years', 'officeLocation'));
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
        $years = "";
        //$departments =Departments::orderBy('id', 'desc')->get();
        $years=DB::table('years')
                     ->join('departments','years.department_id','=','departments.id')
                     ->select('years.id','years.name','years.year','years.status','departments.department_name')    
                     ->orderBy('years.id', 'desc')->get();
                     // dd($years);
        
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

        return DataTables::of($years)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.year', 'label' => 'year', 'value' => $q->id]);
                }          

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.year.edit', ['years' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.year.destroy', ['years' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                
               if ($has_publish || $has_unpublish) {
                        if($q->status == 1){
                    $publish = view('backend.datatable.action-unpublish')
                        ->with(['route' => route('admin.year.unpublish', ['years' => $q->id])])
                        ->render();
                    $view .= $publish;
                        }else{
                       $unpublish = view('backend.datatable.action-publish')
                        ->with(['route' => route('admin.year.publish', ['years' => $q->id])])
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
            $department = Departments::where('id', '=', $deptId)->pluck('department_name', 'id');
        }else{
            $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
        }
       return view('backend.years.create',compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreYearRequest $request)
    {
    $years = $request->input('year');
    if($request->input('year2') != "" && $request->input('year2') != "0000"){
        $years = $request->input('year')." - ".$request->input('year2');
    }
    $designations = new Year;
    $designations->department_id = $request->input('department_id');
    $designations->name = $request->input('name');
    $designations->year = $years;
    $designations->status = $request->input('status');

//    $designations = Year::create($request->all());
    $designations->save();
    return redirect()->route('admin.year.index')->withFlashSuccess(trans('alerts.backend.general.created'));
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
        $years = DB::table('years')
                ->join('departments','years.department_id','=','departments.id')
                ->where('years.id',$id)
                ->select('years.id','years.year','years.status','departments.department_name','years.name as yearname','years.department_id as deptid')
                ->first();
        $userId = auth()->user()->id;
	
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
        return view('backend.years.edit', compact('years', 'department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateYearRequest $request, $id)
    {
        $years = $request->input('year');
        if($request->input('year2') != "" && $request->input('year2') != "0000"){
            $years = $request->input('year')." - ".$request->input('year2');
        }
        $department_id = $request->department_id;
        $name = $request->name;
        $year = $years;
        $status = $request->status;
        DB::table('years')
        ->where('id', $id)  
        ->update(array('department_id' => $department_id, 
                        'name' => $name,
                        'year' => $year,
                        'status' => $status
                    ));
        return redirect()->route('admin.year.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       DB::table('years')->where('id', $id)->delete(); 
       return redirect()->route('admin.year.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
    




    
  //////////////////////////////////////////////////////////////////////unpublish Designations
    
   public function unpublish($id)
    { 
        $status=0;
        DB::table('years')
            ->where('id', $id)
            ->update(['status' => $status]);
        return redirect()->route('admin.year.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish Designations 
      public function publish($id)
    {
        $status=1;
         DB::table('years')
            ->where('id', $id)
            ->update(['status' => $status]);
        return redirect()->route('admin.year.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
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
