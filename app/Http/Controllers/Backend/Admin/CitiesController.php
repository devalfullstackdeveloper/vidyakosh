<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreCitiesRequest;
use App\Http\Requests\Admin\UpdateCitiesRequest;
use App\Models\Cities;
use App\Models\States;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;


class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = Cities::all();
        
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }
        
        return view('backend.cities.index', compact('cities','officeLocation'));
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
        $cities = "";
		$cities=DB::table('cities')
                     ->join('states','states.id','=','cities.state_id')
                     ->select('cities.id','cities.city','cities.status','states.state')	
					 ->orderBy('cities.id', 'desc')->get();
		
		//$cities =Cities::orderBy('id', 'desc')->get();
                
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }
		
        if (auth()->user()->isAdmin()  || (auth()->user()->is_admin == 1 && $officeLocation == 0)) {
            $has_view = true;
            $has_edit = true;
            $has_delete = true;
			$has_publish = true;
		    $has_unpublish = true;
        }


        return DataTables::of($cities)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.cities', 'label' => 'cities', 'value' => $q->id]);
                }          

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.cities.edit', ['cities' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.cities.destroy', ['cities' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
					 if ($has_publish || $has_unpublish) {
						if($q->status == 1){
                    $publish = view('backend.datatable.action-unpublish')
                        ->with(['route' => route('admin.cities.unpublish', ['cities' => $q->id])])
                        ->render();
                    $view .= $publish;
						}else{
					   $unpublish = view('backend.datatable.action-publish')
                        ->with(['route' => route('admin.cities.publish', ['cities' => $q->id])])
                        ->render();
                    $view .= $unpublish;		
						}
                }
				

                return $view;

            })
           // ->editColumn('status', function ($q) {
				
           //     return ($q->status == 1) ? "Enabled" : "Disabled";
          //  })
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
        $states = States::where('status', '=', 1)->pluck('state', 'id')->prepend('Please select', '');	
        return view('backend.cities.create',compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCitiesRequest $request)
    {
    
        $cities = Cities::create($request->all());
        $cities->save();
	return redirect()->route('admin.cities.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cities  $cities
     * @return \Illuminate\Http\Response
     */
    public function show(Cities $cities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cities  $cities
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cities = Cities::findOrFail($id);
        $states = States::where('status', '=', 1)->pluck('state', 'id')->prepend('Please select', '');  
        return view('backend.cities.edit', compact('cities','states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cities  $cities
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCitiesRequest $request, $id)
    {
       $cities = Cities::findOrFail($id);
       $cities->update($request->all());
       $cities->save();
       return redirect()->route('admin.cities.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cities  $cities
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        DB::table('cities')->delete($id);
        return redirect()->route('admin.cities.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
	
	 //////////////////////////////////////////////////////////////////////unpublish Cities
	
   public function unpublish($id)
    {
		$status=0;
	    $cities = Cities::findOrFail($id);
        $cities->status = $status;
        $cities->update();
        return redirect()->route('admin.cities.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish Cities	
	  public function publish($id)
    {
		$status=1;
	    $cities = Cities::findOrFail($id);
        $cities->status = $status;
        $cities->update();
        return redirect()->route('admin.cities.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
	
}
