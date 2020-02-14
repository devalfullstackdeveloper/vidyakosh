<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreNewsFlashRequest;
use App\Http\Requests\Admin\UpdateNewsFlashRequest;
use App\Models\NewsFlash;
use App\Models\Ministry;
use App\Models\Departments;
use App\Models\MinistriesNewsflash;
use App\Models\DepartmentsNewsflash;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;


class NewsFlashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newsflash = newsflash::all();
        return view('backend.newsflash.index', compact('newsflash'));
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
		
        $newsflash = "";
		$newsflash =newsflash::orderBy('id', 'desc')->get();
        if (auth()->user()->isAdmin()) {
            $has_view = true;
            $has_edit = true;
            $has_delete = true;
			$has_publish = true;
			$has_unpublish = true;
        }


        return DataTables::of($newsflash)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.newsflash', 'label' => 'newsflash', 'value' => $q->id]);
                }          

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.newsflash.edit', ['newsflash' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.newsflash.destroy', ['newsflash' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
				 if ($has_publish || $has_unpublish) {
						if($q->status == 1){
                    $publish = view('backend.datatable.action-unpublish')
                        ->with(['route' => route('admin.newsflash.unpublish', ['newsflash' => $q->id])])
                        ->render();
                    $view .= $publish;
						}else{
					   $unpublish = view('backend.datatable.action-publish')
                        ->with(['route' => route('admin.newsflash.publish', ['newsflash' => $q->id])])
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
        if(auth()->user()->is_admin == 1){  
            $userId = auth()->user()->id;   
            $userdetails = DB::table('user_details')->where('user_id', '=', $userId)->get();    
            $deptId = $userdetails[0]->department_id;   
            $departments = Departments::where('id', '=', $deptId)->pluck('department_name', 'id');  
        }else{  
            $departments = Departments::where('status', '=', 1)->pluck('department_name', 'id');    
        }   
        $ministry = Ministry::where('status', '=', 1)->pluck('ministry_name', 'id');    
//        $departments = Departments::where('status', '=', 1)->pluck('department_name', 'id');  
        return view('backend.newsflash.create',compact('ministry','departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewsFlashRequest $request)
    {
		
    $newsflash = NewsFlash::create($request->all());
    $newsflash->save();
	$insertedId = $newsflash->id;
		$ministry_id = array_filter((array)$request->input('ministry_id'));	
       foreach ($ministry_id as $key) {
        $ministriesnewsflash = new MinistriesNewsflash;
        $ministriesnewsflash->ministry_id=$key;
        $ministriesnewsflash->news_id=$insertedId;
        $ministriesnewsflash->save();
        }
		$department_id = array_filter((array)$request->input('department_id'));
		 foreach ($department_id as $key) {
        $departmentsnewsflash = new DepartmentsNewsflash;
        $departmentsnewsflash->department_id=$key;
        $departmentsnewsflash->news_id=$insertedId;
        $departmentsnewsflash->save();
        }
	return redirect()->route('admin.newsflash.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NewsFlash  $newsFlash
     * @return \Illuminate\Http\Response
     */
    public function show(NewsFlash $newsFlash)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NewsFlash  $newsFlash
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->is_admin == 1){  
            $userId = auth()->user()->id;   
            $userdetails = DB::table('user_details')->where('user_id', '=', $userId)->get();    
            $deptId = $userdetails[0]->department_id;   
            $departments = Departments::where('id', '=', $deptId)->pluck('department_name', 'id');  
        }else{  
            $departments = Departments::where('status', '=', 1)->pluck('department_name', 'id');    
        }   
        $newsflash = NewsFlash::findOrFail($id);    
        $ministry = Ministry::where('status', '=', 1)->pluck('ministry_name', 'id');    
            
        $ministries_newsflash = DB::table("ministries_newsflash")->where('news_id',$id)->select("ministry_id")->get();  
        $ministryArr = array(); 
        foreach ($ministries_newsflash as $key => $value) { 
            $ministryArr[] = $value->ministry_id;   
        }   
            
        $departments_newsflash = DB::table("departments_newsflash")->where('news_id',$id)->select("department_id")->get();  
        $deptArr = array(); 
        foreach ($departments_newsflash as $key => $value) {    
            $deptArr[] = $value->department_id; 
        }   
        return view('backend.newsflash.edit', compact('newsflash','ministry','departments','ministryArr','deptArr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NewsFlash  $newsFlash
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewsFlashRequest $request, $id)
    {
       $newsflash = NewsFlash::findOrFail($id);
       $newsflash->update($request->all());

       $newsflash->save();
       return redirect()->route('admin.newsflash.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NewsFlash  $newsFlash
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $NewsFlash = NewsFlash::findOrFail($id);
        $NewsFlash->delete();
        return redirect()->route('admin.newsflash.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
	
	
	 //////////////////////////////////////////////////////////////////////unpublish NewsFlash
	
   public function unpublish($id)
    {
		$status=0;
	    $newsflash = NewsFlash::findOrFail($id);
        $newsflash->status = $status;
        $newsflash->update();
        return redirect()->route('admin.newsflash.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish NewsFlash	
	  public function publish($id)
    {
		$status=1;
	    $newsflash = NewsFlash::findOrFail($id);
        $newsflash->status = $status;
        $newsflash->update();
        return redirect()->route('admin.newsflash.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
}
