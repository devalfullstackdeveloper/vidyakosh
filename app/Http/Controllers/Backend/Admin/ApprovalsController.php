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
use App\Models\Order;
use App\Models\Course;
use App\Models\Bundle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use DB;
use Auth;


class ApprovalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.approvals.index');
    }
	
	/**
     * Display a listing of Courses via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    
	public function approvedapprovallist()
    {
        return view('backend.approvals.approved');
    }

    public function pendingapprovallist()
    {
        return view('backend.approvals.pending');
    }

    public function getApprovedList(Request $request){
    	$has_view = false;
        $has_delete = false;
        $has_edit = false;
        $has_publish = false;
        $has_unpublish = false;
        $approvedList = "";
        $approvedList = DB::table('courserequest')
                ->leftjoin('tracks', 'tracks.id', '=', 'courserequest.track_id')
                ->leftjoin('categories', 'categories.id', '=', 'courserequest.categoryid')
                ->leftjoin('sub_categories', 'sub_categories.id', '=', 'courserequest.subcategory')
                ->leftjoin('courses', 'courses.id', '=', 'courserequest.coursesid')
                ->leftjoin('users', 'users.id', '=', 'courserequest.userid')
                ->select('courserequest.id', 'tracks.name as track', 'categories.name as category','sub_categories.name as subcategory','courses.title as courses','courserequest.status as status', DB::raw("concat(users.first_name, ' ' , users.last_name) as name"))
                ->where('courserequest.status', '=', '1')
				->get();

		if (auth()->user()->isAdmin() || auth()->user()->is_admin == 1 ) {
            $has_publish = true;
            $has_unpublish = true;
			
    		$approvedList = DB::table('courserequest')
                ->leftjoin('tracks', 'tracks.id', '=', 'courserequest.track_id')
                ->leftjoin('categories', 'categories.id', '=', 'courserequest.categoryid')
                ->leftjoin('sub_categories', 'sub_categories.id', '=', 'courserequest.subcategory')
                ->leftjoin('courses', 'courses.id', '=', 'courserequest.coursesid')
                ->leftjoin('users', 'users.id', '=', 'courserequest.userid')
                ->select('courserequest.id', 'tracks.name as track', 'courserequest.status as status', 'categories.name as category','sub_categories.name as subcategory','courses.title as courses',DB::raw("concat(users.first_name, ' ' , users.last_name) as name"))
                ->where('courserequest.status', '=', '1')
				->get();
        }
        //echo "<pre>"; print_r($approvedList); "<pre>"; die;

        return DataTables::of($approvedList)
            ->addIndexColumn()
			->addColumn('actions', function ($q) use ($has_publish,$has_unpublish, $request) {
                $view = "";
				if ($has_publish || $has_unpublish) {
					if($q->status == 1){
						$publish = view('backend.datatable.action-approve')
							->with(['route' => route('admin.approval.accept', ['resources' => $q->id])])
							->render();
						$unpublish = view('backend.datatable.action-reject')
							->with(['route' => route('admin.approval.reject', ['resources' => $q->id])])
							->render();
						//$view .= $publish;
						//$view .= $unpublish;
							}else{
							$publish = view('backend.datatable.action-approve')
							->with(['route' => route('admin.approval.accept', ['resources' => $q->id])])
							->render();
						   $unpublish = view('backend.datatable.action-reject')
							->with(['route' => route('admin.approval.reject', ['resources' => $q->id])])
							->render();
						//$view .= $publish;
						//$view .= $unpublish;        
					}
				}
				

            })
		    ->editColumn('status', function ($q) {	
			   return ($q->status == 1) ? "Approved" : "Un-Approved";
		    })
            ->rawColumns(['actions', 'approvaltype'])
            ->make();
    }

    public function getPendingList(Request $request){
    	$has_view = false;
        $has_delete = false;
        $has_edit = false;
        $has_publish = false;
        $has_unpublish = false;
        $approvedList = "";
        $approvedList = DB::table('courserequest')
                ->leftjoin('tracks', 'tracks.id', '=', 'courserequest.track_id')
                ->leftjoin('categories', 'categories.id', '=', 'courserequest.categoryid')
                ->leftjoin('sub_categories', 'sub_categories.id', '=', 'courserequest.subcategory')
                ->leftjoin('courses', 'courses.id', '=', 'courserequest.coursesid')
                ->leftjoin('users', 'users.id', '=', 'courserequest.userid')
                ->select('courserequest.id', 'tracks.name as track', 'courserequest.status as status', 'categories.name as category','sub_categories.name as subcategory','courses.title as courses',DB::raw("concat(users.first_name, ' ' , users.last_name) as name"))
                ->where('courserequest.status', '=', '0')
				->get();

		if (auth()->user()->isAdmin() || auth()->user()->is_admin == 1 ) {
            $has_publish = true;
            $has_unpublish = true;
			
    		$approvedList = DB::table('courserequest')
                ->leftjoin('tracks', 'tracks.id', '=', 'courserequest.track_id')
                ->leftjoin('categories', 'categories.id', '=', 'courserequest.categoryid')
                ->leftjoin('sub_categories', 'sub_categories.id', '=', 'courserequest.subcategory')
                ->leftjoin('courses', 'courses.id', '=', 'courserequest.coursesid')
                ->leftjoin('users', 'users.id', '=', 'courserequest.userid')
                ->select('courserequest.id', 'tracks.name as track', 'courserequest.status as status', 'categories.name as category','sub_categories.name as subcategory','courses.title as courses',DB::raw("concat(users.first_name, ' ' , users.last_name) as name"))
                ->where('courserequest.status', '=', '0')
				->get();
        }

        return DataTables::of($approvedList)
            ->addIndexColumn()
            
			->addColumn('actions', function ($q) use ($has_publish,$has_unpublish, $request) {
                $view = "";
				if ($has_publish || $has_unpublish) {
					if($q->status == 1){
						$publish = view('backend.datatable.action-approve')
							->with(['route' => route('admin.approval.accept', ['resources' => $q->id])])
							->render();
						$unpublish = view('backend.datatable.action-reject')
							->with(['route' => route('admin.approval.reject', ['resources' => $q->id])])
							->render();
						$view .= $publish;
						$view .= $unpublish;
							}else{
							$publish = view('backend.datatable.action-approve')
							->with(['route' => route('admin.approval.accept', ['resources' => $q->id])])
							->render();
						   $unpublish = view('backend.datatable.action-reject')
							->with(['route' => route('admin.approval.reject', ['resources' => $q->id])])
							->render();
						$view .= $publish;
						$view .= $unpublish;        
					}
				}
				if (auth()->user()->isAdmin() || auth()->user()->is_admin == 1) {
					return $view;
				} else {
					return "";
				}

            })
		    ->editColumn('status', function ($q) {	
			   return ($q->status == 1) ? "Approved" : "Un-Approved";
		    })
            ->rawColumns(['actions', 'approvaltype'])
            ->make();
    }

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
    
	public function reject($id)
    { 
		if (auth()->user()->isAdmin() || auth()->user()->is_admin == 1) {
			$status=2;
			DB::table('courserequest')
				->where('id', $id)
				->update(['status' => $status, 'updated_at' => date("Y-m-d h:i:s"), 'modified_by' => Auth::user()->id]);
			return redirect()->route('admin.approvals.pendingapprovallist')->withFlashSuccess(trans('alerts.backend.general.updated'));
		} else {
			return redirect()->route('admin.approvals.pendingapprovallist')->withFlashSuccess(trans('alerts.backend.general.un_authorized'));
		}
    }

	///////////////////////////////////////////////////////////////////////publish Designations 
    public function accept($id)
    {
        if (auth()->user()->isAdmin() || auth()->user()->is_admin == 1) {
			$status=1;
			DB::table('courserequest')
				->where('id', $id)
				->update(['status' => $status, 'updated_at' => date("Y-m-d h:i:s"), 'modified_by' => Auth::user()->id]);
			$courserequestdata = DB::table('courserequest')->where('id', $id)->first();
			$this->getNow($courserequestdata->userid, $courserequestdata->coursesid);

			return redirect()->route('admin.approvals.pendingapprovallist')->withFlashSuccess(trans('alerts.backend.general.updated'));
		} else {
			return redirect()->route('admin.approvals.pendingapprovallist')->withFlashSuccess(trans('alerts.backend.general.un_authorized'));
		}
    }

    public function getNow($user_id, $course_id)
    {
        $order = new Order();
        $order->user_id = $user_id;
        $order->reference_no = str_random(8);
        $order->amount = 0;
        $order->status = 1;
        $order->payment_type = 0;
        $order->save();
        //Getting and Adding items
        if ($course_id) {
            $type = Course::class;
            $id = $course_id;
        } else {
            $type = Bundle::class;
            $id = $request->bundle_id;

        }
        $order->items()->create([
            'item_id' => $id,
            'item_type' => $type,
            'price' => 0
        ]);

        foreach ($order->items as $orderItem) {
            //Bundle Entries
            if ($orderItem->item_type == Bundle::class) {
                foreach ($orderItem->item->courses as $course) {
                    $course->students()->attach($order->user_id);
                }
            }
            $orderItem->item->students()->attach($order->user_id);
        }
        
        return true;

    }

}
