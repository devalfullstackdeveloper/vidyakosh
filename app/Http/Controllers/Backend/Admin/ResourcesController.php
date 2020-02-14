<?php
/**
* @author: Jitender
* @created: 27-Dec-2019
* @description: resources management
*/
namespace App\Http\Controllers\Backend\Admin;

use App\Models\Auth\User;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreResourcesRequest;
use App\Http\Requests\Admin\UpdateResourcesRequest;
use App\Models\Resources;
use App\Models\Track;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use DB;
use Auth;


class ResourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.resources.index');
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
        $resources = "";
        $resources = DB::table('resources')
                ->leftjoin('tracks', 'tracks.id', '=', 'resources.track_id')
                ->leftjoin('categories', 'categories.id', '=', 'resources.category_id')
                ->leftjoin('users', 'users.id', '=', 'resources.user_id')
                ->select('resources.id', 'resources.published', 'tracks.name as track', 'categories.name as category',DB::raw("concat(users.first_name, ' ' , users.last_name) as first_name"), 'resources.resource_title', 'resources.resourcetype as rstype', 'resources.suggested_link')
                ->where('resources.published', '=', '1')
				->get();
        if (auth()->user()->isAdmin() || auth()->user()->is_admin == 1 ) {
            $has_publish = true;
            $has_unpublish = true;
			
			 $resources = DB::table('resources')
                ->leftjoin('tracks', 'tracks.id', '=', 'resources.track_id')
                ->leftjoin('categories', 'categories.id', '=', 'resources.category_id')
                ->leftjoin('users', 'users.id', '=', 'resources.user_id')
                ->select('resources.id', 'resources.published', 'tracks.name as track', 'categories.name as category',DB::raw("concat(users.first_name, ' ' , users.last_name) as first_name"), 'resources.resource_title', 'resources.resourcetype as rstype', 'resources.suggested_link')
                ->get();
        }
		
        return DataTables::of($resources)
            ->addIndexColumn()
            ->addColumn('resourcetype', function ($q) use ($has_publish,$has_unpublish, $request) {
				$view = "";
				if($q->rstype == 2){
                    $resourcelink = view('backend.datatable.action-document')
                        ->with(['route' => $q->suggested_link])
                        ->render();
                    $view .= $resourcelink;
				}else{
				   $resourcelink = view('backend.datatable.action-video')
					->with(['route' => $q->suggested_link])
					->render();
                    $view .= $resourcelink;        
				}
				return $view;
            })
			->addColumn('actions', function ($q) use ($has_publish,$has_unpublish, $request) {
                $view = "";
				if ($has_publish || $has_unpublish) {
					if($q->published == 1){
						$publish = view('backend.datatable.action-unpublish')
							->with(['route' => route('admin.resources.unpublish', ['resources' => $q->id])])
							->render();
						$view .= $publish;
							}else{
						   $unpublish = view('backend.datatable.action-publish')
							->with(['route' => route('admin.resources.publish', ['resources' => $q->id])])
							->render();
						$view .= $unpublish;        
					}
				}
				if (auth()->user()->isAdmin() || auth()->user()->is_admin == 1) {
					return $view;
				} else {
					return "";
				}

            })
		    ->editColumn('published', function ($q) {	
			   return ($q->published == 1) ? "Published" : "Un-Published";
		    })
            ->rawColumns(['actions', 'resourcetype'])
            ->make();
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function submitsuggestion()
    {
		
		$department_id = 0;

 	    $userdetail  = DB::table('user_details')->where('user_id', Auth::user()->id)->first();
        $resourcetrack = DB::table('tracks')->where('status', '=', '1')->where('department_id', '=', $userdetail->department_id)->pluck('name', 'id')->prepend('Please select', '');
		$resourcecat = array("Please Select");
        return view('backend.resources.submitsuggestion', compact('resources', 'resourcecat', 'resourcetrack'));
    }
	
	/**
     * Store a newly created Resources in storage.
     *
     * @param  \App\Http\Requests\StoreResourcesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResourcesRequest $request)
    {
        $resourcetrack = $request->input('resourcetrack');
        $resourcecat = $request->input('resourcecat');
        $resourcetype = $request->input('resourcetype');
		
		$resourcetitle = $request->input('resourcetitle');
		$resourcesuggested_link = $request->input('resourcesuggested_link');
		
		$rs_data = new Resources;
		$rs_data->track_id = $resourcetrack;
		$rs_data->category_id = $resourcecat;
		$rs_data->resourcetype = $resourcetype;
		$rs_data->resource_title = $resourcetitle;
		$rs_data->suggested_link = $resourcesuggested_link;
		$rs_data->user_id = Auth::user()->id;
		$rs_data->created_at = date("Y-m-d h:i:s");

		$rs_data->save();
		return redirect()->route('admin.resources.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }
	
	///////////////////////////////////////////////////////////
	public function categoryFilter($id)
    {
        $resourcetrack = DB::table('categories')->where('status', '=', '1')->where('track_id', '=', $id)->pluck('name', 'id')->prepend('Please select', '');
        return json_encode($resourcetrack);
    }
	//////////////////////////////////////////////////////////////////////unpublish Designations
    
	public function unpublish($id)
    { 
		if (auth()->user()->isAdmin() || auth()->user()->is_admin == 1) {
			$status=0;
			DB::table('resources')
				->where('id', $id)
				->update(['published' => $status, 'updated_at' => date("Y-m-d h:i:s"), 'modified_by' => Auth::user()->id]);
			return redirect()->route('admin.resources.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
		} else {
			return redirect()->route('admin.resources.index')->withFlashSuccess(trans('alerts.backend.general.un_authorized'));
		}
    }


	///////////////////////////////////////////////////////////////////////publish Designations 
    public function publish($id)
    {
        if (auth()->user()->isAdmin() || auth()->user()->is_admin == 1) {
			$status=1;
			DB::table('resources')
				->where('id', $id)
				->update(['published' => $status, 'updated_at' => date("Y-m-d h:i:s"), 'modified_by' => Auth::user()->id]);
			return redirect()->route('admin.resources.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
		} else {
			return redirect()->route('admin.resources.index')->withFlashSuccess(trans('alerts.backend.general.un_authorized'));
		}
    }
}
