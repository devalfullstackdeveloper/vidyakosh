<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreBannersRequest;
use App\Http\Requests\Admin\UpdateBannersRequest;
use App\Models\Ministry;
use App\Models\Departments;
use App\Models\Banners;
use App\Models\MinistryBanner;
use App\Models\DepartmentsBanner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;


class BannersController extends Controller
{
	
	 use FileUploadTrait;
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banners::all();
        return view('backend.banner.index', compact('banners'));
    }
	
	
	
	    public function getData(Request $request)
    {
		
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $has_publish = false;
        $has_unpublish = false;
        $banners = "";
		
	    $banners =Banners::orderBy('id', 'desc')->get();
      
        if (auth()->user()->isAdmin()) {
            $has_view = true;
            $has_edit = false;
            $has_delete = true;
            $has_publish = true;
            $has_unpublish = true;
        }


        return DataTables::of($banners)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $has_publish,
            $has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.banners', 'label' => 'banners', 'value' => $q->id]);
                }

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.banners.edit', ['banners' => $q->id])])
                        ->render();
                    $view .= $edit;
                }				

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.banners.destroy', ['banners' => $q->id])])
                        ->render();
                    $view .= $delete;
                }

                if ($has_publish || $has_unpublish) {
                         if($q->status == 1){
                     $publish = view('backend.datatable.action-unpublish')
                         ->with(['route' => route('admin.banners.unpublish', ['signs' => $q->id])])
                         ->render();
                     $view .= $publish;
                         }else{
                        $unpublish = view('backend.datatable.action-publish')
                         ->with(['route' => route('admin.banners.publish', ['sectionofficers' => $q->id])])
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
		 $ministry = Ministry::where('status', '=', 1)->pluck('ministry_name', 'id');
		 $departments = Departments::where('status', '=', 1)->pluck('department_name', 'id');
         return view('backend.banner.create',compact('ministry','departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBannersRequest $request)
    {
        $ministry_id = array_filter((array)$request->input('ministry_id'));
        $department_id = array_filter((array)$request->input('department_id'));

        
		$title = $request->input('title');
		$image = $request->file('banner_image');
		$status = $request->input('status');
		
    	if($image){
    		$image_name = str_random(20);
    		$ext = strtolower($image->getClientOriginalExtension());
    		$image_full_name = $image_name.'.'.$ext;
    		$upload_path = 'banners/';
    		$image_url = $upload_path.$image_full_name;
    		$success = $image->move($upload_path,$image_full_name);
		
		}
		$banners = new Banners;
        $banners->title=$title;
        $banners->banner_image=$image_full_name;
		$banners->status=$status;
		$banners->save();
		$insertedId = $banners->id;
		
		if(!empty($ministry_id)){	
		foreach ($ministry_id as $key) {
        $ministrybanner = new MinistryBanner;
        $ministrybanner->ministry_id=$key;
        $ministrybanner->banner_id=$insertedId;
        $ministrybanner->save();
        }		
		}
		
		if(!empty($department_id)){	
		foreach ($department_id as $key) {
        $departmentsbanner = new DepartmentsBanner;
        $departmentsbanner->department_id=$key;
        $departmentsbanner->banner_id=$insertedId;
        $departmentsbanner->save();
        }		
		}
	   return redirect()->route('admin.banners.index')->withFlashSuccess(trans('alerts.backend.general.created'));	
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function show(Banners $banners)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Banners  $banners
     * @return \Illuminate\Http\Response
     */
   public function edit($id)
    {
        $banners = Banners::findOrFail($id);
		//echo "<pre>";
		//print_r($banners); exit;
        return view('backend.banner.edit', compact('banners'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banners $banners)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Banners = Banners::findOrFail($id);
        $Banners->delete();
        return redirect()->route('admin.banners.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    //////////////////////////////////////////////////////////////////////unpublish Designations
    
   public function unpublish($id)
    {
        $status=0;
        $designations = Banners::findOrFail($id);
        $designations->status = $status;
        $designations->update();
        return redirect()->route('admin.banners.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish Designations 
      public function publish($id)
    {
        $status=1;
        $designations = Banners::findOrFail($id);
        $designations->status = $status;
        $designations->update();
        return redirect()->route('admin.banners.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
}
