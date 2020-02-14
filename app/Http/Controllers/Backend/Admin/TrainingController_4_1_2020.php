<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use App\Models\Departments;
use App\Models\Crt;
use App\Models\Approve;
use App\Models\Track;
use App\Models\Category;
use App\Models\Year;
use App\Models\States;
use App\Models\Auth\User;
use App\Models\Cities;
use App\Models\Designations;
use App\Models\InstituteIndustry;
use App\Http\Requests\Admin\StoreCrtRequest;
use App\Http\Requests\Admin\StoreFeedbackRequest;
use App\Http\Requests\Admin\UpdateCrtRequest;
use App\Http\Requests\Admin\StoreAttendanceRequest;
use App\Models\Crttraining;
use App\Models\Userdetail;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Auth; 
use App\Models\Tabtrainingstatus; 
use App\Models\Feedback;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;



class TrainingController extends Controller
{
    
   public function getIndex(){
        $crtid = array();
        $studentid = auth()->user()->id;
        $studentdetail  = Userdetail::where('user_id', $studentid)->first();
        $departmentid =  $studentdetail->department_id;
        $designation_id =  $studentdetail->designation_id;
        $crttrainingsdata  = DB::table('crttrainings')->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')->where('crttrainings.department_id', $departmentid)->where('crt_designations.designation_id', $designation_id)->whereDate('lastnominne', '>=', Carbon::now())->get();
        foreach ($crttrainingsdata as $crttrainingsdatas) {
            $crtid[] = $crttrainingsdatas->id;
        }
       $list = implode(', ', $crtid);
       $trainings = DB::table("crttrainings")->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')->select('crttrainings.*')->where('crttrainings.department_id', $departmentid)->where('crt_designations.designation_id', $designation_id)
            ->whereNOTIn('crttrainings.id',function($query){
               $query->select('crt_id')->from('tab_training_status');
            })
            ->get();
           

        return view('backend.trainings.index',compact('trainings'));
		/*$crtid = array();
        $studentid = auth()->user()->id;
        $studentdetail  = Userdetail::where('user_id', $studentid)->first();
        $departmentid =  $studentdetail->department_id;
        $crttrainingsdata  = Crttraining::where('department_id', $departmentid)->whereDate('lastnominne', '>=', Carbon::now())->get();
        foreach ($crttrainingsdata as $crttrainingsdatas) {
            $crtid[] = $crttrainingsdatas->id;
        }
       $list = implode(', ', $crtid);
       $trainings = DB::table("crttrainings")->select('*')->whereDate('lastnominne', '>=', Carbon::now())->where('department_id', $departmentid)
            ->whereNOTIn('id',function($query){
               $query->select('crt_id')->from('tab_training_status');
            })
            ->get();
           

        return view('backend.trainings.index',compact('trainings'));*/
    }
        public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $has_publish = false;
        $has_unpublish = false;
        $tracks = "";
        /*$studentid = auth()->user()->id;
        $studentdetail  = Userdetail::where('user_id', $studentid)->first();
        $departmentid =  $studentdetail->department_id;
        $designation_id =  $studentdetail->designation_id;
        $trainings = DB::table("crttrainings")->select('*')->whereDate('lastnominne', '>=', Carbon::now())->where('department_id', $departmentid)->where('designation_id',$designation_id)
            ->whereNOTIn('id',function($query){
               $query->select('crt_id')->from('tab_training_status');
            })
            ->get();*/
			$crtid = array();
        $studentid = auth()->user()->id;
        $studentdetail  = Userdetail::where('user_id', $studentid)->first();
        $departmentid =  $studentdetail->department_id;
        $designation_id =  $studentdetail->designation_id;
        $crttrainingsdata  = DB::table('crttrainings')->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')->where('crttrainings.department_id', $departmentid)->where('crt_designations.designation_id', $designation_id)->whereDate('lastnominne', '>=', Carbon::now())->get();
        foreach ($crttrainingsdata as $crttrainingsdatas) {
            $crtid[] = $crttrainingsdatas->id;
        }
       $list = implode(', ', $crtid);
       $trainings = DB::table("crttrainings")->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')->select('crttrainings.*')->where('crttrainings.department_id', $departmentid)->where('crt_designations.designation_id', $designation_id)
            ->whereNOTIn('crttrainings.id',function($query){
               $query->select('crt_id')->from('tab_training_status');
            })
            ->get();
			

     
            $has_view = true;
            $has_edit = true;
            $has_delete = true;
            $has_publish = true;
            $has_unpublish = true;

      
        return DataTables::of($trainings)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                 if ($request->show_deleted == 1) {
                     return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.trainings', 'label' => 'training', 'value' => $q->id]);
                }          
                 if ($has_edit) {
                     $edit = view('backend.datatable.action_nominate')
                         ->with(['route' => route('admin.trainings.nominate', ['trainings' => $q->id])])
                        ->render();
                     $view .= $edit;
                 }
                   if ($has_delete) {
                       $delete = view('backend.datatable.view')
                           ->with(['route' => route('admin.trainings.view', ['trainings' => $q->id])])
                          ->render();
                       $view .= $delete;
                   }
                return $view;
            })
            ->rawColumns(['actions', 'image'])
            ->make();
    }






   
    public function training_status()
    {

        $status  = DB::table('tab_training_status')
        ->join('crttrainings','tab_training_status.crt_id','=','crttrainings.id')
        ->join('users','users.id','=','tab_training_status.reportingmanager_id')
        ->select('tab_training_status.id','tab_training_status.nominate_date as statusdate','tab_training_status.status as status','crttrainings.title as title','users.first_name as name')->get(); 

        return view('backend.trainings.status',compact('status'));
 
    }
    
    public function approved_training()
    {     
		$userid = Auth::user()->id;  
          $approved  = DB::table('tab_training_status')
			->join('crttrainings','tab_training_status.crt_id','=','crttrainings.id')
			->join('users as usr','usr.id','=','tab_training_status.reportingmanager_id')
			->join('users','users.id','=','tab_training_status.user_id')
			->select('tab_training_status.id','tab_training_status.action_on as statusdate','tab_training_status.nominate_date as nominatedate','tab_training_status.status as status','crttrainings.title as title','users.first_name as name','usr.first_name as reportingname','crttrainings.id as crtid')
			->where('tab_training_status.status','=', 1)
			->get();
		   //$users = User::where('id',$userid)->first();

        return view('backend.trainings.approved_training',compact('approved','users'));
    }

    public function rejected_training()
    {   
         $userid = Auth::user()->id;  
        $rejects  = DB::table('tab_training_status')
        ->join('crttrainings','tab_training_status.crt_id','=','crttrainings.id')
		->join('users as usr','usr.id','=','tab_training_status.reportingmanager_id')
        ->join('users','users.id','=','tab_training_status.user_id')
        ->select('tab_training_status.id','tab_training_status.action_on as statusdate','tab_training_status.nominate_date as nominatedate','tab_training_status.status as status','crttrainings.title as title','users.first_name as name','usr.first_name as reportingname','crttrainings.id as crtid')
        ->where('tab_training_status.status','=', 2)
        ->get();
		
		//dd($rejects);
        //$users = User::where('id',$userid)->first();
        return view('backend.trainings.rejected_training',compact('rejects','users'));
    }

    public function nominate()
    {
    $id =  $_GET['trainings'];
    $userid = Auth::user()->id;
    $reportingmanagerid = DB::table('users')
                          ->join('user_details','users.id','=','user_details.user_id')
                          ->select('user_details.reportingmanager_id')
                          ->where('users.id',$userid)
                          ->first();
    $reportingid = $reportingmanagerid->reportingmanager_id;
    $status = 3;
    DB::table('tab_training_status')->insert(
    ['crt_id' => $id, 'user_id' => $userid,'status' => $status,'reportingmanager_id' => $reportingid]);
    return back();
    }

   public function request_approvel()
   {

     $userid = Auth::user()->id;
     $approval   = DB::table('tab_training_status')
        ->join('crttrainings','tab_training_status.crt_id','=','crttrainings.id')
         ->join('users','tab_training_status.user_id','=','users.id')
        ->select('tab_training_status.id','tab_training_status.nominate_date as statusdate','tab_training_status.status as status','crttrainings.title as title','users.first_name as name')
        ->where('tab_training_status.status','=',3)
        ->where('tab_training_status.reportingmanager_id','=',$userid)
        ->limit(1,1)
        ->get();
        
         return view('backend.trainings.approval_training',compact('approval'));
   }
    

        public function getApproved(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $has_publish = false;
        $has_unpublish = false;
        $tracks = "";
        $userid = Auth::user()->id;
        $studentid = auth()->user()->id;
        $studentdetail  = Userdetail::where('user_id', $studentid)->first();
        $departmentid =  $studentdetail->department_id;
        $approvals   = DB::table('tab_training_status')
        ->join('crttrainings','tab_training_status.crt_id','=','crttrainings.id')
        ->join('users','tab_training_status.user_id','=','users.id')
        ->select('tab_training_status.id','users.first_name as name','tab_training_status.nominate_date as statusdate','tab_training_status.status as status','crttrainings.title as title')
        ->where('tab_training_status.status','=',3)
        ->where('tab_training_status.reportingmanager_id','=',$userid)
        ->get();
            $has_view = true;
            $has_edit = true;
            $has_delete = true;
            $has_publish = true;
            $has_unpublish = true;

      
        return DataTables::of($approvals)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = ""; 
                $delete = "";
                 if ($request->show_deleted == 1) {
                     return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.trainings', 'label' => 'training', 'value' => $q->id]);
                }          
                 if ($has_edit) {
                     $edit = view('backend.datatable.action-approved')
                         ->with(['route' => route('admin.trainings.approved', ['approvals' => $q->id])])
                        ->render();
                     $view .= $edit;
                 }
                   if ($has_delete) {
                       $delete = view('backend.datatable.action-reject')
                          ->with(['route' => route('admin.trainings.reject', ['approvals' => $q->id])])
                         ->render();
                      $view .= $delete;
                   }
                return $view;
            })
            ->rawColumns(['actions', 'image'])
            ->make();
    }




    public function approved()
    {
    $id =  $_GET['approvals'];
    $userid = Auth::user()->id;
    $status = 1;
    $data = Carbon::now('Asia/Calcutta');
    DB::table('tab_training_status')
            ->where('id', $id)
            ->update(['status' => $status,'action_on'=> $data]);
    return back();
    }

    public function reject()
    {
    $id =  $_GET['approvals'];
    $userid = Auth::user()->id; 
    $status = 2;
    $data = Carbon::now('Asia/Calcutta');
    DB::table('tab_training_status')
            ->where('id', $id)
            ->update(['status' => $status,'action_on'=> $data]);
    return back();
    }


     public function training_attended()
    {
        $crtid = array();
        $studentid = auth()->user()->id;
        $studentdetail  = Userdetail::where('user_id', $studentid)->first();
        $departmentid =  $studentdetail->department_id;
        $training_attended  = DB::table('crttrainings')
        ->join('tab_training_status','tab_training_status.crt_id','=','crttrainings.id')
        ->join('users','users.id','=','tab_training_status.user_id')
        ->where('tab_training_status.user_id',$studentid)
        //->where('tab_training_status.department_id',$departmentid)
        ->whereDate('crttrainings.lastnominne', '<=', Carbon::now())
        ->select('users.first_name as name','crttrainings.start_date as start_date','crttrainings.end_date as end_date','crttrainings.lastnominne as lastnominne','crttrainings.title as title')
        ->get();


        // Crttraining::where('department_id', $departmentid)->whereDate('lastnominne', '<=', Carbon::now())->get();
        return view('backend.trainings.training_attended',compact('training_attended'));
    }
    public function attended()
    {   
        $userid = Auth::user()->id;
        $users = DB::table('users')
                    ->join('tab_training_status', 'tab_training_status.user_id', '=', 'users.id')
                    ->where('users.id',$userid)
                    ->where('tab_training_status.status', 1)
                    ->selectRaw('users.first_name as first_name')
                    ->first();
                    //dd($users);
        $crtid = array();
        $studentid = auth()->user()->id;
        $studentdetail  = Userdetail::where('user_id', $studentid)->first();
        $departmentid =  $studentdetail->department_id;
        $attended_training  = Crttraining::where('department_id', $departmentid)->whereDate('end_date', '<', Carbon::now())->get();

      return view('backend.trainings.attended_training',compact('attended_training','users'));
    }

    public function feedback()
    { 

         $studentid = auth()->user()->id; 
        $studentdetail  = Userdetail::where('user_id', $studentid)->first();  
        $departmentid =  $studentdetail->department_id; 
        $attendance  = Crttraining::where('department_id', $departmentid)->whereDate('start_date', '>', Carbon::now('Asia/Calcutta'))->whereDate('end_date', '>', Carbon::now('Asia/Calcutta'))->get();
        // $trainingid = array();
        // $studentid = auth()->user()->id;
        // $studentdetail  = Userdetail::where('user_id', $studentid)->first();
        // $departmentid =  $studentdetail->department_id;
        // $stdid = array();
        // $stdid =  $studentdetail->department_id;
        // $feedbacks  = Feedback::whereNotIn('login_user_id', [$stdid])->get();
        // foreach ($feedbacks as $feedbacksdata){
        //     $trainingid[] =  $feedbacksdata->training_id;
        // }
        // $attendance  = DB::table('crttrainings')
        //               ->join('tab_training_status','crttrainings.id','=','tab_training_status.crt_id')
        //               ->where('crttrainings.department_id', $departmentid)
        //               ->whereDate('crttrainings.start_date', '<=', Carbon::now('Asia/Calcutta'))
        //               ->whereDate('crttrainings.end_date', '>=', Carbon::now('Asia/Calcutta'))
        //               ->where('crttrainings.feedback','yes')
        //               ->where('tab_training_status.user_id',$studentid)
        //               ->whereNotIn('crttrainings.id',$trainingid)
                      //->where('tab_training_status.status',3)
                      // ->select('crttrainings.*')
                      // ->get();
// $query = DB::getQueryLog();
// print_r($query);
// die;
// print_r($latestPosts);
// die;

        //               $attendance = DB::table('feedbacks')
        // ->joinSub($latestPosts, 'latest_posts', function ($join) {
        //     $join->on('feedbacks.training_id', '=', 'latest_posts.id');
        // })->get();

// print_r($attendance);
// die;
         // Crttraining::where('department_id', $departmentid)->whereDate('start_date', '<=', Carbon::now('Asia/Calcutta'))->whereDate('end_date', '>=', Carbon::now('Asia/Calcutta'))->where('feedback','yes')->get();

      //return view('backend.trainings.feedback',compact('attendance'));
        return view('backend.trainings.feedback',compact('attendance'));
    }

// public function view()
// {
//   $id =  $_GET['trainings'];
//   $crttrainings = DB::table('crttrainings')
//                     ->join('departments','crttrainings.department_id','=','departments.id')
//                     ->join('tracks','crttrainings.track_id','=','tracks.id')
//                     ->join('categories','crttrainings.category_id','=','categories.id')
//                     ->join('years','crttrainings.year_id','=','years.id')
//                      ->join('states','crttrainings.state_id','=','states.id')
//                      ->join('cities','crttrainings.city_id','=','cities.id')
//                     ->join('venues','crttrainings.venue_id','=','venues.id')
//                     ->join('designations','crttrainings.designation_id','=','designations.id')

//                     ->where('crttrainings.id',$id)
//                     ->select('crttrainings.id','crttrainings.start_date as startdate','crttrainings.end_date as enddate','crttrainings.lastnominne as nominationdate','departments.department_name', 'tracks.name as trackname','categories.name as categoryname','years.name as yearname','states.state as statename','cities.city as cityname','venues.address as venu','designations.designation as designationname','crttrainings.title as title','crttrainings.description as description','crttrainings.timing as timing')
//                      ->orderBy('crttrainings.id', 'desc')->first();
//                      return view('backend.trainings.training_view',compact('crttrainings'));
// }

  public function view()  
{ 
  $id =  $_GET['trainings']; 

   // $crttrainings=DB::table('crttrainings') 
   //                   ->join('departments','crttrainings.department_id','=','departments.id')
   //                   ->join('tracks','crttrainings.track_id','=','tracks.id')
   //                   ->join('categories','crttrainings.category_id','=','categories.id') 
   //                   ->join('years','crttrainings.year_id','=','years.id')
   //                  ->where('crttrainings.id',$id)  
   //                  ->select('crttrainings.id','crttrainings.title as title','crttrainings.start_date as startdate','crttrainings.end_date as enddate','crttrainings.lastnominne as nominationdate','departments.department_name','crttrainings.timing as timing','tracks.name as trackname','categories.name as categoryname','years.name as yearname')     
   //                    ->first(); 
   //                    print_r($crttrainings);
   //                    die();

  $crttrainings=DB::table('crttrainings') 
                     ->join('departments','crttrainings.department_id','=','departments.id')  
                     ->join('tracks','crttrainings.track_id','=','tracks.id') 
                     ->join('categories','crttrainings.category_id','=','categories.id')  
                     ->join('years','crttrainings.year_id','=','years.id')  
                     ->join('states','crttrainings.state_id','=','states.id') 
                     ->join('cities','crttrainings.city_id','=','cities.id')  
                    ->join('venues','crttrainings.venue_id','=','venues.id')  
                    ->join('designations','crttrainings.designation_id','=','designations.id')  
                    ->join('institute_industry','crttrainings.corinst_id','=','institute_industry.id')  
                    ->where('crttrainings.id',$id)  
                    ->select('crttrainings.id','crttrainings.title as title','crttrainings.start_date as startdate','crttrainings.end_date as enddate','crttrainings.lastnominne as nominationdate','departments.department_name', 'tracks.name as trackname','categories.name as categoryname','years.name as yearname','states.state as statename','cities.city as cityname','venues.address as venu','designations.designation as designationname','crttrainings.title as title','crttrainings.description as description','crttrainings.corempcode as coordinatecode','institute_industry.name as coordinateid','crttrainings.resourceempcode as resourceempcode','institute_industry.name as resourceinstituteid','crttrainings.timing as timing')     
                     ->orderBy('crttrainings.id', 'desc')->first(); 
                     return view('backend.trainings.training_view',compact('crttrainings'));  
}

public function attendance()
{
   $userid = Auth::user()->id;
        $users = User::where('id',$userid)->first();
        $crtid = array();
        $studentid = auth()->user()->id;
        $studentdetail  = Userdetail::where('user_id', $studentid)->first();
        $departmentid =  $studentdetail->department_id;
        // $attendance  = Crttraining::where('department_id', $departmentid)->whereDate('start_date', '<=', Carbon::now('Asia/Calcutta'))->whereDate('end_date', '>=', Carbon::now('Asia/Calcutta'))->get();
        $attendance  = Crttraining::where('department_id', $departmentid)->whereDate('start_date', '>', Carbon::now('Asia/Calcutta'))->whereDate('end_date', '>', Carbon::now('Asia/Calcutta'))->get();
        $student = DB::table('tab_training_status')
                     ->join('users','tab_training_status.user_id','=','users.id')
                    ->join('user_details','users.id','=','user_details.user_id')
                    ->join('designations','user_details.designation_id','=','designations.id')
                     ->select('tab_training_status.id','users.first_name','users.id as user_id','designations.designation','designations.id as designation_id')
                     ->where('tab_training_status.status','=',1)->get();
          // print_r($student);
          // die;

        return view('backend.trainings.attendance',compact('attendance','student'));
}

      public function feedbacksave(StoreFeedbackRequest $request)
      {
        $feedbacks = Feedback::create($request->all());
        $feedbacks->save();
        Session::flash('message', "Your Feedback Saved Successfully!");
        return Redirect::back();
      }
	public function userattandence($id)
	{
     $reportingmanagerid = auth()->user()->id;
     $student = DB::table('tab_training_status')
                    ->join('users','tab_training_status.user_id','=','users.id')
                    ->join('user_details','users.id','=','user_details.user_id')
                    ->join('designations','user_details.designation_id','=','designations.id')
                    ->select('tab_training_status.id','tab_training_status.crt_id as crtid','users.first_name','users.id as user_id','designations.designation','designations.id as designation_id')
                    ->where('tab_training_status.status','=', 1)
			              ->where('tab_training_status.crt_id','=', $id)
                    ->where('tab_training_status.reportingmanager_id','=', $reportingmanagerid)  
			              ->get();
		return json_encode($student);
	}

// public function attendancesave(StoreAttendanceRequest $request)
//       {   
//           $reportingmanager = Auth::user()->id;
//           $studentdetail  = Userdetail::where('user_id', $reportingmanager)->first();
//           $departmentid =  $studentdetail->department_id;
//           $con = count($_GET['user_id']);
//           for($i=0;$i<$con;$i++)
//           {
//             $userid = $_GET['user_id'][$i];
//             $designation_id =  $_GET['designation_id'][$i];
//             $present =  $_GET['attendance'][$i];
//             $training_id =  $_GET['training_id'];
//           DB::table('attendances')->insert(
//        ['department_id'=>$departmentid,'training_id' => $training_id, 'user_id' => $userid,'designation_id' => $designation_id,'created_by' => $reportingmanager,'present' =>$present]);
//        Session::flash('message', "Attendance Saved Successfully!");
//           } 
//         return Redirect::back();
         
//       }
   public function attendancesave(Request $request) 
      { 
	  

          //$department_id =  $_GET['department_id']; 
          $user_id =  $_GET['user_id']; 
          $designation_id =  $_GET['designation_id']; 
          $present =  $_GET['attendance'];  
          $attendance =  $_GET['attendance'];  
          $userid = Auth::user()->id; 
          //DB::table('attendances')->insert(array('training_id' => $request->training_id, 'user_id' => $user_id,'designation_id' => $designation_id,'created_by' => $userid));  
			for($i = 0; $i<count($user_id); $i++){
			  
				DB::table('attendances')->insert(
					array('training_id' => $request->training_id, 'user_id' => $user_id[$i],'present' => $attendance[$i],'designation_id' => $designation_id[$i],'created_by' => $userid[$i])
				);
			}
		   
		   return Redirect::back(); 
      }

}
