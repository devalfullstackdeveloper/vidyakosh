<?php
/**
* @author: Jitender
* @created: 28-Dec-2019
* @description: resources management
*/
namespace App\Http\Controllers\Backend\Admin;

use App\Models\Auth\User; 
use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Auth;

class PeercompController extends Controller
{
    public function __construct()
    {

        $path = 'frontend';
        if (session()->has('display_type')) {
            if (session('display_type') == 'rtl') {
                $path = 'frontend-rtl';
            } else {
                $path = 'frontend';
            }
        } else if (config('app.display_type') == 'rtl') {
            $path = 'frontend-rtl';
        }
        $this->path = $path;
    }

    /**
     * Get certificates lost for purchased courses.
     */
    public function getpeercompstatus()
    {
        return view('backend.peercomstatus.index', compact('certificates'));
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
		$userdetail  = DB::table('user_details')->where('user_id', Auth::user()->id)->first();
        $resources = DB::table('users')
                ->join('user_details', 'user_details.user_id', '=', 'users.id')
                ->join('locations', 'locations.id', '=', 'user_details.office_id')
                ->select('users.id', DB::raw("concat(users.first_name, ' ' , users.last_name) as first_name"), 'users.email', 'locations.office_name')
                ->where('user_details.designation_id', '=', $userdetail->designation_id)
				->get();
  		
        return DataTables::of($resources)->addIndexColumn()
            ->addIndexColumn()
			->addColumn('no_course', function ($q) use ($has_publish,$has_unpublish, $request) {
                return '<a href="#" data-toggle="modal" data-element="'.$q->id.'" onclick="javascript: oncourse_count_click(this)" data-target="#myModal">' . DB::table('orders')->where('user_id', $q->id)->count() . '</a>';

            })
            ->rawColumns(['no_course'])
            ->make();;
    }
	
	
	///////////////////////////////////////////////////////////
	public function courseFilter($id)
    {
        $courses_list = DB::table('orders')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->join('courses', 'courses.id', '=', 'order_items.item_id')
                ->select('courses.title')
                ->where('orders.user_id', '=', $id)
				->get();
        return json_encode($courses_list);
    }
	
}
