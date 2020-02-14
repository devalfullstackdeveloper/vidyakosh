<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreStatesRequest;
use App\Http\Requests\Admin\UpdateStatesRequest;
use App\Models\States;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;




class StatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = States::all();
        
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }
        
        return view('backend.states.index', compact('states','officeLocation'));
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
		
        $states = "";
        $states =States::orderBy('id', 'desc')->get();
	
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


        return DataTables::of($states)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit,$has_publish,$has_unpublish, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.states', 'label' => 'states', 'value' => $q->id]);
                }          

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.states.edit', ['states' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.states.destroy', ['states' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
				
			    if ($has_publish || $has_unpublish) {
						if($q->status == 1){
                    $publish = view('backend.datatable.action-unpublish')
                        ->with(['route' => route('admin.states.unpublish', ['states' => $q->id])])
                        ->render();
                    $view .= $publish;
						}else{
					   $unpublish = view('backend.datatable.action-publish')
                        ->with(['route' => route('admin.states.publish', ['states' => $q->id])])
                        ->render();
                    $view .= $unpublish;		
						}
                }
				

                return $view;

            })
          //  ->editColumn('status', function ($q) {
				
            //    return ($q->status == 1) ? "Enabled" : "Disabled";
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
       return view('backend.states.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStatesRequest $request)
    {
        $states = States::create($request->all());
        $states->save();
        return redirect()->route('admin.states.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $states = States::findOrFail($id);
        return view('backend.states.edit', compact('states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatesRequest $request, $id)
    {
       $states = States::findOrFail($id);
       $states->update($request->all());

       $states->save();
       return redirect()->route('admin.states.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $States = States::findOrFail($id);
        $States->delete();
        return redirect()->route('admin.states.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
	
	
	
	//////////////////////////////////////////////////////////////////////unpublish States
	
   public function unpublish($id)
    {
		$status=0;
	    $states = States::findOrFail($id);
        $states->status = $status;
        $states->update();
        return redirect()->route('admin.states.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish States	
	  public function publish($id)
    {
		$status=1;
	    $states = States::findOrFail($id);
        $states->status = $status;
        $states->update();
        return redirect()->route('admin.states.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
	
	
	
	
	
	
	
	
}
