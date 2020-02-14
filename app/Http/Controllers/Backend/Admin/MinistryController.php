<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreMinistryRequest;
use App\Http\Requests\Admin\UpdateMinistryRequest;
use App\Models\Ministry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;



class MinistryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
		 //if (request('show_deleted') == 1) {
        //    $ministry = Ministry::onlyTrashed()->get();
       // }
		
        $ministry = Ministry::all();
        return view('backend.ministry.index', compact('ministry'));
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
        $ministry = "";
		
		
	    //if (request('show_deleted') == 1) {

          //  $ministry = Ministry::onlyTrashed()->orderBy('id', 'desc')->get();
        //} else {
           $ministry =Ministry::orderBy('id', 'desc')->get();
        //}
	
		
        if (auth()->user()->isAdmin()) {
            $has_view = true;
            $has_edit = true;
            $has_delete = true;
			$has_publish = true;
			$has_unpublish = true;
        }


        return DataTables::of($ministry)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.ministry', 'label' => 'ministry', 'value' => $q->id]);
                }          

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.ministry.edit', ['ministry' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.ministry.destroy', ['ministry' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
				
				 if ($has_publish || $has_unpublish) {
						if($q->status == 1){
                    $publish = view('backend.datatable.action-unpublish')
                        ->with(['route' => route('admin.ministry.unpublish', ['ministry' => $q->id])])
                        ->render();
                    $view .= $publish;
						}else{
					   $unpublish = view('backend.datatable.action-publish')
                        ->with(['route' => route('admin.ministry.publish', ['ministry' => $q->id])])
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
         return view('backend.ministry.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMinistryRequest $request)
    {
		
	$ministry = Ministry::create($request->all());
    $ministry->save();
	return redirect()->route('admin.ministry.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }
	


    /**
     * Display the specified resource.
     *
     * @param  \App\Ministry  $ministry
     * @return \Illuminate\Http\Response
     */
    public function show(Ministry $ministry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ministry  $ministry
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
    {
        $ministry = Ministry::findOrFail($id);
        return view('backend.ministry.edit', compact('ministry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ministry  $ministry
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMinistryRequest $request, $id)
    {
       $ministry = Ministry::findOrFail($id);
       $ministry->update($request->all());

       $ministry->save();
        return redirect()->route('admin.ministry.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ministry  $ministry
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        $ministry = Ministry::findOrFail($id);
        $ministry->delete();
        return redirect()->route('admin.ministry.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
	

//////////////////////////////////////////////////////////////////////unpublish ministry
	
   public function unpublish($id)
    {
		$status=0;
	    $ministry = Ministry::findOrFail($id);
        $ministry->status = $status;
        $ministry->update();
        return redirect()->route('admin.ministry.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish ministry	
	  public function publish($id)
    {
		$status=1;
	    $ministry = Ministry::findOrFail($id);
        $ministry->status = $status;
        $ministry->update();
        return redirect()->route('admin.ministry.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
	
	
	
	
	
	
	
	
}
