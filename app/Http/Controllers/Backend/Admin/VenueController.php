<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\UpdateVenueRequest;
use App\Http\Requests\Admin\StoreVenueRequest;
use App\Models\Designations;
use App\Models\Ministry;
use App\Models\Venue;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use App\Models\Departments;
use App\Models\States;
use App\Models\Cities;


class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $venues = DB::table('venues')->get();
		
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }
		
        return view('backend.venues.index', compact('venues','officeLocation'));
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
        $tracks = "";
        //$departments =Departments::orderBy('id', 'desc')->get();
        $venues=DB::table('venues')
                     ->join('departments','venues.department_id','=','departments.id')
					  ->join('states','venues.state','=','states.id')
					 ->join('cities','venues.city','=','cities.id')
                     ->select('venues.id','states.state','cities.city','venues.address','venues.status','departments.department_name')    
                     ->orderBy('venues.id', 'desc')->get();
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

		

        return DataTables::of($venues)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.venue', 'label' => 'venue', 'value' => $q->id]);
                }          

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.venue.edit', ['venues' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.venue.destroy', ['venues' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                
               if ($has_publish || $has_unpublish) {
                        if($q->status == 1){
                    $publish = view('backend.datatable.action-unpublish')
                        ->with(['route' => route('admin.venue.unpublish', ['years' => $q->id])])
                        ->render();
                    $view .= $publish;
                        }else{
                       $unpublish = view('backend.datatable.action-publish')
                        ->with(['route' => route('admin.venue.publish', ['years' => $q->id])])
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
//        $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
        $state = States::where('status', '=', 1)->pluck('state', 'id')->prepend('Please select', '');
        $cities = Cities::where('status', '=', 1)->pluck('city', 'id')->prepend('Please select', '');
        return view('backend.venues.create',compact('department','state','cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVenueRequest $request)
    {
		
    $venues = Venue::create($request->all());
	
    $venues->save();
    return redirect()->route('admin.venue.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $venues = DB::table('venues')->where('id',$id)->first();
        $state = States::where('status', '=', 1)->pluck('state', 'id')->prepend('Please select', '');
        $cities = Cities::where('status', '=', 1)->pluck('city', 'id')->prepend('Please select', '');
        
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
//        $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
		
        return view('backend.venues.edit', compact('venues','state','cities','department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVenueRequest $request, $id)
    {
         $state = $request->state;
         $city = $request->city;
         $address = $request->address;
		 $department = $request->department;
		 $status = $request->status;
        DB::table('venues')
        ->where('id', $id)  
        ->update(array('state' => $state,'city'=>$city,'address'=>$address,'department_id'=>$department,'status'=>$status));
        return redirect()->route('admin.venue.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       DB::table('venues')->where('id', $id)->delete(); 
       return redirect()->route('admin.venue.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
    



//////////////////////////////////////////////////////////////////////unpublish Designations
  
   public function unpublish($id)
    { 
        $status=0;
        DB::table('venues')
            ->where('id', $id)
            ->update(['status' => $status]);
        return redirect()->route('admin.venue.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish Designations 
      public function publish($id)
    {
        $status=1;
         DB::table('venues')
            ->where('id', $id)
            ->update(['status' => $status]);
        return redirect()->route('admin.venue.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    










    
        public function departmentFilter($id)
    {
        $departments = DB::table("departments")
                    ->where("ministry_id",$id)
                    ->where("status",1)
                    ->select("department_name","id")
                    ->pluck('department_name','id');
                return json_encode($departments);
    }
	
	public function statecityFilter($id)
    {
        $cities = DB::table("cities")
                    ->where("state_id",$id)
                    ->where("status",1)
                    ->select("city","id")
                    ->pluck('city','id');
                return json_encode($cities);
    }
    
     public function officeFilter($id)
    {
        $locations = DB::table("locations")
                    ->where("department_id",$id)
                    ->where("status",1)
                    ->select("office_name","id")
                    ->pluck('office_name','id');
                return json_encode($locations);
    }

    
    
}
