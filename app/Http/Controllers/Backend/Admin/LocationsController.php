<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreLocationsRequest;
use App\Http\Requests\Admin\UpdateLocationsRequest;
use App\Models\Locations;
use App\Models\Ministry;
use App\Models\Departments;
use App\Models\States;
use App\Models\Cities;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;


class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = locations::all();
        
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }
        
        return view('backend.locations.index', compact('locations','officeLocation'));
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
        $locations = "";
        $locations =Locations::orderBy('id', 'desc')->get();
	
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


        return DataTables::of($locations)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.locations', 'label' => 'locations', 'value' => $q->id]);
                }          

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.locations.edit', ['locations' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.locations.destroy', ['locations' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
				
			 if ($has_publish || $has_unpublish) {
						if($q->status == 1){
                    $publish = view('backend.datatable.action-publish')
                        ->with(['route' => route('admin.locations.unpublish', ['locations' => $q->id])])
                        ->render();
                    $view .= $publish;
						}else{
					   $unpublish = view('backend.datatable.action-unpublish')
                        ->with(['route' => route('admin.locations.publish', ['locations' => $q->id])])
                        ->render();
                    $view .= $unpublish;		
						}
                }

                return $view;

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
            $parent_office_id = DB::table("locations")->where('status', 1)->where("department_id",$deptId)->select("office_name","id")->pluck('office_name','id')->prepend('Please select', '');
                    
            if(count($parent_office_id) == 0){
                $parent_office_id = array("" => "Please select","0" => "Main/HQ Office");
            }
        }else{
            $departments = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
            $parent_office_id = array("" => "Please select");
        }
	  $states = States::where('status', '=', 1)->pluck('state', 'id')->prepend('Please select', '');
	  $locations =Locations::orderBy('id', 'desc')->get();
      return view('backend.locations.create',compact('ministry','departments','states','cities','locations','parent_office_id'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocationsRequest $request)
    {
    $locations = Locations::create($request->all());
    $locations->save();
	return redirect()->route('admin.locations.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Locations  $locations
     * @return \Illuminate\Http\Response
     */
    public function show(Locations $locations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Locations  $locations
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
            $locationListing = Locations::where('status', '=', 1)->where('department_id', '=', $deptId)->pluck('office_name', 'id')->prepend('Please select', '');
        }else{
            $departments = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
            $locationListing = Locations::where('status', '=', 1)->pluck('office_name', 'id')->prepend('Please select', '');
        }
        $locations = Locations::findOrFail($id);
//        $departments = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
        $state = States::where('status', '=', 1)->pluck('state', 'id')->prepend('Please select', '');
        $city = Cities::where('status', '=', 1)->pluck('city', 'id')->prepend('Please select', '');
        
        
        return view('backend.locations.edit', compact('locations', 'departments', 'state', 'city','locationListing'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Locations  $locations
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLocationsRequest $request, $id)
    {
       $locations = Locations::findOrFail($id);
       $locations->update($request->all());
       $locations->save();
	   
       return redirect()->route('admin.locations.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Locations  $locations
     * @return \Illuminate\Http\Response
     */
   public function destroy($id)
    {
        $ministry = Locations::findOrFail($id);
        $ministry->delete();
        return redirect()->route('admin.locations.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
	
	
	
	//////////////////////////////////////////////////////////////////////unpublish locations
	
   public function unpublish($id)
    {
		$status=0;
	    $locations = Locations::findOrFail($id);
        $locations->status = $status;
        $locations->update();
        return redirect()->route('admin.locations.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish locations	
	  public function publish($id)
    {
		$status=1;
	    $locations = Locations::findOrFail($id);
        $locations->status = $status;
        $locations->update();
        return redirect()->route('admin.locations.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
	
	
	
	
	
	
	
	
	
	

////////////////////////////////////////////////////////////////////////////Filter-function-mqr


      public function departmentFilter($id)
    {
        $departments = DB::table("locations")
                    ->where("department_id",$id)
                    ->where('status', 1)
                    ->select("office_name","id")
                    ->pluck('office_name','id');
                    
        if(count($departments) > 0){
            return json_encode($departments);
        }else{
            $arr = array("0" => "Main/HQ Office");
            return json_encode($arr);
        }
    }


      public function citiesFilter($id)
    {
        $cities = DB::table("cities")
                    ->where("state_id",$id)
                    ->where('status', 1)
                    ->select("city","id")
                    ->pluck('city','id');
                return json_encode($cities);
    }
}

//////////////////////////////////////////////////////////////////////////////