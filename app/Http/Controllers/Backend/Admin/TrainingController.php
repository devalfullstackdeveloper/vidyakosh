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
use PDF;
use App\Models\Tabtrainingstatus; 
use App\Models\Feedback;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;



class TrainingController extends Controller
{
    
   public function getIndex(Request $request){
        $crtid = array();
        $studentid = auth()->user()->id;
        $studentdetail  = Userdetail::where('user_id', $studentid)->first();
	   //dd($studentdetail);die;
        $departmentid =  $studentdetail->department_id;
        $designation_id =  $studentdetail->designation_id;
        $crttrainingsdata  = DB::table('crttrainings')->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')->where('crttrainings.department_id', $departmentid)->where('crt_designations.designation_id', $designation_id)->whereDate('crttrainings.lastnominne', '>=', Carbon::now())->get();
	   //dd($crttrainingsdata);
        foreach ($crttrainingsdata as $crttrainingsdatas) {
            $crtid[] = $crttrainingsdatas->crt_id;
        }
       $list = implode(', ', $crtid);
       $trainings = DB::table("crttrainings")->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')->select('crttrainings.*')->where('crttrainings.department_id', $departmentid)->where('crt_designations.designation_id', $designation_id)
            ->whereNOTIn('crttrainings.id',function($query){
               $query->select('crt_id')->from('tab_training_status');
            })
            ->get();
            
            /****/
            
       $filter = 1;
        $trainingFilter = 1;
        if(isset($request->p)){
            $filt = explode(",", $request->p);
            $filter = $filt[0];
            if(isset($filt[1])){
                $trainingFilter = $filt[1];
            }
        }
        
        if($filter == 1){
            $nextweek = strtotime("+1 week -1 day"); 
            $enddate = date("Y-m-d",$nextweek);
        }elseif($filter == 2){
            $nextMonth = strtotime('+1 month');
            $enddate = date("Y-m-d",$nextMonth);
        }elseif($filter == 3){
            $current_quarter = ceil(date('n') / 3);
            $enddate = date('Y-m-t', strtotime(date('Y') . '-' . (($current_quarter * 3)) . '-1'));
        }elseif($filter == 4){
            $year =strtotime('+1 year');
            $enddate = date("Y-m-d",$year);
        } 
        
        $crtid = array();
        $studentid = auth()->user()->id;
        $studentdetail  = Userdetail::where('user_id', $studentid)->first();
        $departmentid =  $studentdetail->department_id;
        $designation_id =  $studentdetail->designation_id;
        $crttrainingsdata  = DB::table('crttrainings')->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')->where('crttrainings.department_id', $departmentid)->where('crt_designations.designation_id', $designation_id)->whereDate('crttrainings.lastnominne', '>=', Carbon::now())->get();
        foreach ($crttrainingsdata as $crttrainingsdatas) {
            $crtid[] = $crttrainingsdatas->crt_id;
        }
       $list = implode(', ', $crtid);
       //dd($list);
       /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id','state_id')->get();
                $officeLocation = $location[0]->parent_office_id;
                $stateId = $location[0]->state_id;
            }
        }
        
        if($officeLocation == 0){
            if($trainingFilter == 2){
                $office = ["HQ Office"];
            }elseif($trainingFilter == 1){ 
                $office = ["All Office"];
            }else{
                $office = ["HQ Office","All Office"];
            }
            $trainings = DB::table("crttrainings")
                        ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                        ->join('locations', 'user_details.office_id', '=', 'locations.id')
                        ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id','crttrainings.training_for')
                        ->where('crttrainings.department_id', $departmentid)
//                        ->whereIn('crttrainings.training_for', ["HQ Office","All Office"])
                        ->whereIn('crttrainings.training_for', $office)
                        ->where('crt_designations.designation_id', $designation_id)
                        ->where('crttrainings.status', 1)
                        ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                        ->whereDate('crttrainings.start_date', '<=', $enddate)
                        ->whereNOTIn('crttrainings.id',function($query){
                                    $query->select('crt_id')->from('tab_training_status')->where('user_id',auth()->user()->id);
                                    })
                        ->get();
        }else{
            if($trainingFilter == 1){
            
//                $all_trainings = DB::table("crttrainings")
                $trainings = DB::table("crttrainings")
                        ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                        ->join('locations', 'user_details.office_id', '=', 'locations.id')
                        ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id','crttrainings.training_for')
                        ->where('crttrainings.department_id', $departmentid)
                        ->where('crt_designations.designation_id', $designation_id)
                        ->where('crttrainings.status', 1)
                        ->where('crttrainings.training_for', "All Office")
                        ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                        ->whereDate('crttrainings.start_date', '<=', $enddate)
                        ->whereNOTIn('crttrainings.id',function($query){
                                        $query->select('crt_id')->from('tab_training_status')->where('user_id',auth()->user()->id);
                                    })
                        ->distinct()
                        ->get();
                                    
            }elseif($trainingFilter == 2){
                
//                $state_trainings = DB::table("crttrainings")
                $trainings = DB::table("crttrainings")
                        ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                        ->join('locations', 'user_details.office_id', '=', 'locations.id')
                        ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id','crttrainings.training_for')
                        ->where('crttrainings.department_id', $departmentid)
                        ->where('crt_designations.designation_id', $designation_id)
                        ->where('crttrainings.status', 1)
                        ->where('crttrainings.state_id', $stateId)
                        ->where('crttrainings.training_for', "State Office")
                        ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                        ->whereDate('crttrainings.start_date', '<=', $enddate)
                        ->whereNOTIn('crttrainings.id',function($query){
                                        $query->select('crt_id')->from('tab_training_status')->where('user_id',auth()->user()->id);
                                    })
                        ->distinct()
                        ->get();
            }else{
                $all_trainings = DB::table("crttrainings")
                        ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                        ->join('locations', 'user_details.office_id', '=', 'locations.id')
                        ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id','crttrainings.training_for')
                        ->where('crttrainings.department_id', $departmentid)
                        ->where('crt_designations.designation_id', $designation_id)
                        ->where('crttrainings.status', 1)
                        ->where('crttrainings.training_for', "All Office")
                        ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                        ->whereDate('crttrainings.start_date', '<=', $enddate)
                        ->whereNOTIn('crttrainings.id',function($query){
                                        $query->select('crt_id')->from('tab_training_status')->where('user_id',auth()->user()->id);
                                    })
                        ->distinct()
                        ->get();
                                    
                $state_trainings = DB::table("crttrainings")
                        ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                        ->join('locations', 'user_details.office_id', '=', 'locations.id')
                        ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id','crttrainings.training_for')
                        ->where('crttrainings.department_id', $departmentid)
                        ->where('crt_designations.designation_id', $designation_id)
                        ->where('crttrainings.status', 1)
                        ->where('crttrainings.state_id', $stateId)
                        ->where('crttrainings.training_for', "State Office")
                        ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                        ->whereDate('crttrainings.start_date', '<=', $enddate)
                        ->whereNOTIn('crttrainings.id',function($query){
                                        $query->select('crt_id')->from('tab_training_status')->where('user_id',auth()->user()->id);
                                    })
                        ->distinct()
                        ->get();
                                    
                        $trainings = collect(array_merge($all_trainings->toArray(), $state_trainings->toArray()));
                
            }
            
        }
             $trainingArr = array();
            $cnt = 0;
        foreach ($trainings as $key => $value) {
            $trArr = array();
            $trArr['id'] = $value->id;
            $trArr['title'] = $value->title;
            $trArr['start_date'] = $value->start_date;
            $trArr['end_date'] = $value->end_date;
            $trArr['lastnominne'] = $value->lastnominne;
            $trArr['address'] = $value->address;
            
            if($value->training_for == "All Office"){
                $trArr['training_for'] = "All India";
            }elseif($value->training_for == "HQ Office"){
                $trArr['training_for'] = "HQ Only";
            }elseif($value->training_for == "State Office"){
                $trArr['training_for'] = "State Only";
            }
            if($value->parent_office_id == 0){
                $trArr['parent_office_id'] = "Head Office";
            }else{
                $trArr['parent_office_id'] = "State Office";
            }
            $trainingArr[$cnt] = (object) $trArr;
            $cnt++;
        }
        $trainings = collect($trainingArr);
            
           
//dd($trainings);
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
        
        $filter = 1;
        $trainingFilter = 1;
        if(isset($request->filter)){
            $filt = explode(",", $request->filter);
            $filter = $filt[0];
            if(isset($filt[1])){
                $trainingFilter = $filt[1];
            }
        }
        
        if($filter == 1){
            $nextweek = strtotime("+1 week -1 day"); 
            $enddate = date("Y-m-d",$nextweek);
        }elseif($filter == 2){
            $nextMonth = strtotime('+1 month');
            $enddate = date("Y-m-d",$nextMonth);
        }elseif($filter == 3){
            $current_quarter = ceil(date('n') / 3);
            $enddate = date('Y-m-t', strtotime(date('Y') . '-' . (($current_quarter * 3)) . '-1'));
        }elseif($filter == 4){
            $year =strtotime('+1 year');
            $enddate = date("Y-m-d",$year);
        }
        
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
        $crttrainingsdata  = DB::table('crttrainings')->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')->where('crttrainings.department_id', $departmentid)->where('crt_designations.designation_id', $designation_id)->whereDate('crttrainings.lastnominne', '>=', Carbon::now())->get();
        foreach ($crttrainingsdata as $crttrainingsdatas) {
            $crtid[] = $crttrainingsdatas->crt_id;
        }
       $list = implode(', ', $crtid);
       //dd($list);
       /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id','state_id')->get();
                $officeLocation = $location[0]->parent_office_id;
                $stateId = $location[0]->state_id;
            }
        }
        
        if($officeLocation == 0){
            if($trainingFilter == 2){
                $office = ["HQ Office"];
            }elseif($trainingFilter == 1){
                $office = ["All Office"];
            }else{
                $office = ["HQ Office","All Office"];
            }
            $trainings = DB::table("crttrainings")
                        ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                        ->join('locations', 'user_details.office_id', '=', 'locations.id')
                        ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id','crttrainings.training_for')
                        ->where('crttrainings.department_id', $departmentid)
//                        ->whereIn('crttrainings.training_for', ["HQ Office","All Office"])
                        ->whereIn('crttrainings.training_for', $office)
                        ->where('crt_designations.designation_id', $designation_id)
                        ->where('crttrainings.status', 1)
                        ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                        ->whereDate('crttrainings.start_date', '<=', $enddate)
                        ->whereNOTIn('crttrainings.id',function($query){
                                    $query->select('crt_id')->from('tab_training_status')->where('user_id',auth()->user()->id);
                                    })
                        ->get();
        }else{
            if($trainingFilter == 1){
            
//                $all_trainings = DB::table("crttrainings")
                $trainings = DB::table("crttrainings")
                        ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                        ->join('locations', 'user_details.office_id', '=', 'locations.id')
                        ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id','crttrainings.training_for')
                        ->where('crttrainings.department_id', $departmentid)
                        ->where('crt_designations.designation_id', $designation_id)
                        ->where('crttrainings.status', 1)
                        ->where('crttrainings.training_for', "All Office")
                        ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                        ->whereDate('crttrainings.start_date', '<=', $enddate)
                        ->whereNOTIn('crttrainings.id',function($query){
                                        $query->select('crt_id')->from('tab_training_status')->where('user_id',auth()->user()->id);
                                    })
                        ->distinct()
                        ->get();
                                    
            }elseif($trainingFilter == 2){
                
//                $state_trainings = DB::table("crttrainings")
                $trainings = DB::table("crttrainings")
                        ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                        ->join('locations', 'user_details.office_id', '=', 'locations.id')
                        ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id','crttrainings.training_for')
                        ->where('crttrainings.department_id', $departmentid)
                        ->where('crt_designations.designation_id', $designation_id)
                        ->where('crttrainings.status', 1)
                        ->where('crttrainings.state_id', $stateId)
                        ->where('crttrainings.training_for', "State Office")
                        ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                        ->whereDate('crttrainings.start_date', '<=', $enddate)
                        ->whereNOTIn('crttrainings.id',function($query){
                                        $query->select('crt_id')->from('tab_training_status')->where('user_id',auth()->user()->id);
                                    })
                        ->distinct()
                        ->get();
            }else{
                $all_trainings = DB::table("crttrainings")
                        ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                        ->join('locations', 'user_details.office_id', '=', 'locations.id')
                        ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id','crttrainings.training_for')
                        ->where('crttrainings.department_id', $departmentid)
                        ->where('crt_designations.designation_id', $designation_id)
                        ->where('crttrainings.status', 1)
                        ->where('crttrainings.training_for', "All Office")
                        ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                        ->whereDate('crttrainings.start_date', '<=', $enddate)
                        ->whereNOTIn('crttrainings.id',function($query){
                                        $query->select('crt_id')->from('tab_training_status')->where('user_id',auth()->user()->id);
                                    })
                        ->distinct()
                        ->get();
                                    
                $state_trainings = DB::table("crttrainings")
                        ->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')
                        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                        ->join('locations', 'user_details.office_id', '=', 'locations.id')
                        ->select('crttrainings.id','crttrainings.title', 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.lastnominne', 'venues.address', 'locations.parent_office_id','crttrainings.training_for')
                        ->where('crttrainings.department_id', $departmentid)
                        ->where('crt_designations.designation_id', $designation_id)
                        ->where('crttrainings.status', 1)
                        ->where('crttrainings.state_id', $stateId)
                        ->where('crttrainings.training_for', "State Office")
                        ->whereDate('crttrainings.start_date', '>=', Carbon::now())
                        ->whereDate('crttrainings.start_date', '<=', $enddate)
                        ->whereNOTIn('crttrainings.id',function($query){
                                        $query->select('crt_id')->from('tab_training_status')->where('user_id',auth()->user()->id);
                                    })
                        ->distinct()
                        ->get();
                                    
                        $trainings = collect(array_merge($all_trainings->toArray(), $state_trainings->toArray()));
                
            }
                
//                $trainings = collect(array_merge($all_trainings->toArray(), $state_trainings->toArray()));       
                
//            }
            
        }
        /*    $crttrainingsdata  = DB::table('crttrainings')->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')->where('crttrainings.department_id', $departmentid)->where('crt_designations.designation_id', $designation_id)->whereDate('crttrainings.lastnominne', '>=', Carbon::now())->get();
	   //dd($crttrainingsdata);
        foreach ($crttrainingsdata as $crttrainingsdatas) {
            $crtid[] = $crttrainingsdatas->crt_id;
        }
       $list = implode(', ', $crtid);
       $trainings = DB::table("crttrainings")->join('crt_designations', 'crt_designations.crt_id', '=', 'crttrainings.id')->select('crttrainings.*')->where('crttrainings.department_id', $departmentid)->where('crt_designations.designation_id', $designation_id)
            ->whereNOTIn('crttrainings.id',function($query){
               $query->select('crt_id')->from('tab_training_status');
            })
            ->get();*/
       
            $has_view = true;
            $has_edit = true;
            $has_delete = true;
            $has_publish = true;
            $has_unpublish = true;

            
            $trainingArr = array();
            $cnt = 0;
        foreach ($trainings as $key => $value) {
            $trArr = array();
            $trArr['id'] = $value->id;
            $trArr['title'] = $value->title;
            $trArr['start_date'] = $value->start_date;
            $trArr['end_date'] = $value->end_date;
            $trArr['lastnominne'] = $value->lastnominne;
            $trArr['address'] = $value->address;
            
            if($value->training_for == "All Office"){
                $trArr['training_for'] = "All India";
            }elseif($value->training_for == "HQ Office"){
                $trArr['training_for'] = "HQ Only";
            }elseif($value->training_for == "State Office"){
                $trArr['training_for'] = "State Only";
            }
            
            if($value->parent_office_id == 0){
                $trArr['parent_office_id'] = "Head Office";
            }else{
                $trArr['parent_office_id'] = "State Office";
            }
            $trainingArr[$cnt] = (object) $trArr;
            $cnt++;
        }
        $trainings = collect($trainingArr);
      
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
//                     $edit = view('backend.datatable.action_nominate')
//                         ->with(['route' => route('admin.trainings.nominate', ['trainings' => $q->id])])
//                        ->render();
                     $edit = '<a href="javascript:void(0);" class="btn btn-xs btn-success mb-1" onclick="checkNomination('.$q->id.');">Request for Nomination</a>';
                     $view .= $edit;
                 }
                   if ($has_delete) {
//                       $delete = view('backend.datatable.view')
//                           ->with(['route' => route('admin.trainings.view', ['trainings' => $q->id])])
//                          ->render();
                       $delete = '<a href="javascript:void(0);" class="btn btn-xs btn-warning mb-1 viewDetails" data-id="'.$q->id.'" onclick="viewDetails('.$q->id.');">View Details</a>';
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
        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
        ->join('locations', 'user_details.office_id', '=', 'locations.id')
        ->where('tab_training_status.user_id',auth()->user()->id)
        ->where('crttrainings.status', 1)
        ->select('crttrainings.id AS crtId','tab_training_status.id','tab_training_status.nominate_date as statusdate','tab_training_status.status as status','crttrainings.title as title','users.first_name as name','tab_training_status.crt_id','tab_training_status.user_id','locations.parent_office_id', 'venues.address','crttrainings.training_for')        
        ->get(); 
        
            $trainingArr = array();
            $cnt = 0;
            foreach ($status as $key => $value) {
                $trArr = array();
                $trArr['id'] = $value->id;
                $trArr['crtId'] = $value->crtId;
                $trArr['statusdate'] = $value->statusdate;
                $trArr['status'] = $value->status;
                $trArr['title'] = $value->title;
                $trArr['name'] = $value->name;
                $trArr['crt_id'] = $value->crt_id;
                $trArr['user_id'] = $value->user_id;
                $trArr['address'] = $value->address;
                
                if($value->training_for == "All Office"){
                    $trArr['training_for'] = "All India";
                }elseif($value->training_for == "HQ Office"){
                    $trArr['training_for'] = "HQ Only";
                }elseif($value->training_for == "State Office"){
                    $trArr['training_for'] = "State Only";
                }
                
                if($value->parent_office_id == 0){
                    $trArr['parent_office_id'] = "Head Office";
                }else{
                    $trArr['parent_office_id'] = "State Office";
                }
                $trainingArr[$cnt] = (object) $trArr;
                $cnt++;
            }
            $status = collect($trainingArr);
        $statusArr = array();
        $cnt = 0;
        foreach ($status as $key => $value) {
            $matchArr = array("crt_id" => $value->crt_id, "user_id" => $value->user_id);
            $result = array(); 
            if(count($statusArr) > 0){
                foreach ($statusArr as $key1 => $value1) { 
                    foreach ($matchArr as $k => $v) { 
                        if (!isset($value1[$k]) || $value1[$k] != $v) 
                        { 
                            continue 2; 
                        } 
                    } 
                    $result[] = $value1;
                } 
            }
            if(count($result) == 0){
                $statusArr[$cnt]['id']=$value->id;
                $statusArr[$cnt]['crtId']=$value->crtId;
                $statusArr[$cnt]['statusdate']=$value->statusdate;
                $statusArr[$cnt]['status']=$value->status;
                $statusArr[$cnt]['title']=$value->title;
                $statusArr[$cnt]['name']=$value->name;
                $statusArr[$cnt]['crt_id']=$value->crt_id;
                $statusArr[$cnt]['user_id']=$value->user_id;
                $statusArr[$cnt]['address']=$value->address;
                $statusArr[$cnt]['parent_office_id']=$value->parent_office_id;
                $statusArr[$cnt]['training_for']=$value->training_for;
                $cnt = $cnt + 1;
            }   
        }
        
        $status = array();
        foreach ($statusArr as $skey => $sValue) {
            $status[] = (object)$sValue;
        }
        $status = collect($status);
        return view('backend.trainings.status',compact('status'));
 
    }
    
    public function approved_training()
    {     
		$userid = Auth::user()->id;  
          $approved  = DB::table('tab_training_status')
			->join('crttrainings','tab_training_status.crt_id','=','crttrainings.id')
			->join('users as usr','usr.id','=','tab_training_status.reportingmanager_id')
			->join('users','users.id','=','tab_training_status.user_id')
                        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                        ->join('locations', 'user_details.office_id', '=', 'locations.id')
			->select('tab_training_status.id','tab_training_status.action_on as statusdate','tab_training_status.nominate_date as nominatedate','tab_training_status.status as status','crttrainings.title as title','users.first_name as name','usr.first_name as reportingname','crttrainings.id as crtid','locations.parent_office_id','venues.address','crttrainings.training_for')
			->where('tab_training_status.status','=', 1)
                        ->where('crttrainings.status', 1)
			->get();
          
		   //$users = User::where('id',$userid)->first();
          $trainingArr = array();
            $cnt = 0;
            foreach ($approved as $key => $value) {
                $trArr = array();
                $trArr['id'] = $value->id;
                $trArr['statusdate'] = $value->statusdate;
                $trArr['nominatedate'] = $value->nominatedate;
                $trArr['status'] = $value->status;
                $trArr['title'] = $value->title;
                $trArr['name'] = $value->name;
                $trArr['reportingname'] = $value->reportingname;
                $trArr['crtid'] = $value->crtid;
                $trArr['address'] = $value->address;
                
                if($value->training_for == "All Office"){
                    $trArr['training_for'] = "All India";
                }elseif($value->training_for == "HQ Office"){
                    $trArr['training_for'] = "HQ Only";
                }elseif($value->training_for == "State Office"){
                    $trArr['training_for'] = "State Only";
                }
                
                if($value->parent_office_id == 0){
                    $trArr['parent_office_id'] = "Head Office";
                }else{
                    $trArr['parent_office_id'] = "State Office";
                }
                $trainingArr[$cnt] = (object) $trArr;
                $cnt++;
            }
            $approved = collect($trainingArr);

        return view('backend.trainings.approved_training',compact('approved','users'));
    }

    public function rejected_training()
    {   
         $userid = Auth::user()->id;  
        $rejects  = DB::table('tab_training_status')
        ->join('crttrainings','tab_training_status.crt_id','=','crttrainings.id')
        ->join('users as usr','usr.id','=','tab_training_status.reportingmanager_id')
        ->join('users','users.id','=','tab_training_status.user_id')
        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
        ->join('locations', 'user_details.office_id', '=', 'locations.id')
        ->select('tab_training_status.id','tab_training_status.action_on as statusdate','tab_training_status.nominate_date as nominatedate','tab_training_status.status as status','crttrainings.title as title','users.first_name as name','usr.first_name as reportingname','crttrainings.id as crtid','locations.parent_office_id','venues.address','crttrainings.training_for')
        ->where('tab_training_status.status','=', 2)
        ->where('crttrainings.status', 1)
        ->get();
        
        $trainingArr = array();
        $cnt = 0;
        foreach ($rejects as $key => $value) {
            $trArr = array();
            $trArr['id'] = $value->id;
            $trArr['statusdate'] = $value->statusdate;
            $trArr['nominatedate'] = $value->nominatedate;
            $trArr['status'] = $value->status;
            $trArr['title'] = $value->title;
            $trArr['name'] = $value->name;
            $trArr['reportingname'] = $value->reportingname;
            $trArr['crtid'] = $value->crtid;
            $trArr['address'] = $value->address;
            
            if($value->training_for == "All Office"){
                $trArr['training_for'] = "All India";
            }elseif($value->training_for == "HQ Office"){
                $trArr['training_for'] = "HQ Only";
            }elseif($value->training_for == "State Office"){
                $trArr['training_for'] = "State Only";
            }
            
            if($value->parent_office_id == 0){
                $trArr['parent_office_id'] = "Head Office";
            }else{
                $trArr['parent_office_id'] = "State Office";
            }
            $trainingArr[$cnt] = (object) $trArr;
            $cnt++;
        }
        $rejects = collect($trainingArr);
		//dd($rejects);
        //$users = User::where('id',$userid)->first();
        return view('backend.trainings.rejected_training',compact('rejects','users'));
    }

    public function nominate()
    {
        $id = $_GET['trainings'];
        $userid = Auth::user()->id;
        $reportingmanagerid = DB::table('users')
                ->join('user_details', 'users.id', '=', 'user_details.user_id')
                ->select('user_details.reportingmanager_id')
                ->where('users.id', $userid)
                ->first();
        $reportingid = $reportingmanagerid->reportingmanager_id;
        if ($reportingid != "") {
            $status = 3;

            DB::table('tab_training_status')->insert(
            ['crt_id' => $id, 'user_id' => $userid, 'status' => $status, 'reportingmanager_id' => $reportingid]);
        } else {
            $status = 3;
            DB::table('tab_training_status')->insert(
            ['crt_id' => $id, 'user_id' => $userid, 'status' => $status, 'reportingmanager_id' => $userid]);
        }

        return back();
    }

   public function request_approvel()
   {

     $userid = Auth::user()->id;
     $approval   = DB::table('tab_training_status')
        ->join('crttrainings','tab_training_status.crt_id','=','crttrainings.id')
         ->join('users','tab_training_status.user_id','=','users.id')
        ->select('tab_training_status.id','tab_training_status.nominate_date as statusdate','tab_training_status.status as status','crttrainings.title as title','users.first_name as name','crttrainings.training_for')
        ->where('tab_training_status.status','=',3)
        ->where('tab_training_status.reportingmanager_id','=',$userid)
        ->where('crttrainings.status', 1)
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
        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
        ->join('locations', 'user_details.office_id', '=', 'locations.id')
        ->select('tab_training_status.id','users.first_name as name','tab_training_status.nominate_date as statusdate','tab_training_status.status as status','crttrainings.title as title','locations.parent_office_id','venues.address','crttrainings.training_for','crttrainings.id AS crtId')
        ->where('tab_training_status.status','=',3)
        ->where('tab_training_status.reportingmanager_id','=',$userid)
        ->where('crttrainings.status', 1)
        ->get();
        
        $trainingArr = array();
        $cnt = 0;
        foreach ($approvals as $key => $value) {
            $trArr = array();
            $trArr['id'] = $value->id;
            $trArr['crtId'] = $value->crtId;
            $trArr['name'] = $value->name;
            $trArr['statusdate'] = $value->statusdate;
            $trArr['status'] = $value->status;
            $trArr['title'] = $value->title;
            $trArr['address'] = $value->address;
            
            if($value->training_for == "All Office"){
                $trArr['training_for'] = "All India";
            }elseif($value->training_for == "HQ Office"){
                $trArr['training_for'] = "HQ Only";
            }elseif($value->training_for == "State Office"){
                $trArr['training_for'] = "State Only";
            }
            
            if($value->parent_office_id == 0){
                $trArr['parent_office_id'] = "Head Office";
            }else{
                $trArr['parent_office_id'] = "State Office";
            }
            $trainingArr[$cnt] = (object) $trArr;
            $cnt++;
        }
        $approvals = collect($trainingArr);
        
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
//                 $delete = view('backend.datatable.view')
//                           ->with(['route' => route('admin.trainings.view', ['trainings' => $q->id])])
//                          ->render();
                 $delete = '<a href="javascript:void(0);" class="btn btn-xs btn-warning mb-1 viewDetails" data-id="'.$q->crtId.'" onclick="viewDetails('.$q->crtId.');">View Detail</a>';
                       $view .= $delete;
                return $view;
            })
            ->rawColumns(['actions', 'image'])
            ->make();
    }




    public function approved()
    {
        $id = $_GET['approvals'];
    $userid = Auth::user()->id;
    $status = 1;
    $data = Carbon::now('Asia/Calcutta');

        /* For Office Location */
        $officeLocation = 1;
        if (isset(auth()->user()->id)) {
            $user = DB::table('user_details')->where('user_id', auth()->user()->id)->select('office_id')->get();
            if (count($user) > 0) {
                $location = DB::table('locations')->where('id', $user[0]->office_id)->select('parent_office_id', 'state_id')->get();
                $officeLocation = $location[0]->parent_office_id;
                $stateId = $location[0]->state_id;
            }
        }
        
        $crt = DB::table('tab_training_status')
                ->join('crttrainings', 'tab_training_status.crt_id', 'crttrainings.id')
                ->where('tab_training_status.id', $id)
                ->where('crttrainings.status', 1)
                ->select('crttrainings.training_for', 'crttrainings.id', 'tab_training_status.user_id', 'tab_training_status.nominate_date')
                ->first();
        
                $nominateDate = $crt->nominate_date;

        if ($crt->training_for == "State Office") {
            if ($officeLocation != 0 && auth()->user()->is_admin != 1 && !auth()->user()->isAdmin()) {
                $status = 3;
                $stateAdmin = DB::table('user_details')
                                ->join('users', 'user_details.user_id', 'users.id')
                                ->where('office_id', $user[0]->office_id)
                                ->where('users.is_admin', 1)
                                ->select('user_details.user_id')->get();

                foreach ($stateAdmin as $key => $value) {
                    DB::table('tab_training_status')->insert(
                    ['crt_id' => $crt->id, 'user_id' => $crt->user_id, 'status' => $status, 'reportingmanager_id' => $value->user_id, 'nominate_date' => $nominateDate,'action_on'=> $data]);
                }
                DB::table('tab_training_status')->where('id', '=', $id)->delete();
            } else {

                $getStatus = DB::table('tab_training_status')
                        ->where('crt_id', $crt->id)
                        ->where('user_id', $crt->user_id)
                        ->select('id')
                        ->get();

                if (count($getStatus) > 0) {
                    foreach ($getStatus as $skey => $sval) {
                        DB::table('tab_training_status')->where('id', '=', $sval->id)->delete();
            }
                }
                DB::table('tab_training_status')->insert(
                ['crt_id' => $crt->id, 'user_id' => $crt->user_id, 'status' => 1, 'reportingmanager_id' => auth()->user()->id, 'nominate_date' => $nominateDate, 'action_on'=> $data]);
            }
        } elseif ($crt->training_for == "All Office") {
            if ($officeLocation != 0 && auth()->user()->is_admin != 1 && !auth()->user()->isAdmin()) {
                $status = 3;
                $stateAdmin = DB::table('user_details')
                                ->join('users', 'user_details.user_id', 'users.id')
                                ->where('office_id', $user[0]->office_id)
                                ->where('users.is_admin', 1)
                                ->select('user_details.user_id')->get();
                
                foreach ($stateAdmin as $key => $value) {
                    DB::table('tab_training_status')->insert(
                    ['crt_id' => $crt->id, 'user_id' => $crt->user_id, 'status' => $status, 'reportingmanager_id' => $value->user_id, 'nominate_date' => $nominateDate, 'action_on'=> $data]);
                }
                DB::table('tab_training_status')->where('id', '=', $id)->delete();
            } else {
                if ($officeLocation == 0) {

                    $getStatus = DB::table('tab_training_status')
                            ->where('crt_id', $crt->id)
                            ->where('user_id', $crt->user_id)
                            ->select('id')
                            ->get();

                    if (count($getStatus) > 0) {
                        foreach ($getStatus as $skey => $sval) {
                            DB::table('tab_training_status')->where('id', '=', $sval->id)->delete();
                        }
                    }
                    DB::table('tab_training_status')->insert(
                    ['crt_id' => $crt->id, 'user_id' => $crt->user_id, 'status' => 1, 'reportingmanager_id' => auth()->user()->id, 'nominate_date' => $nominateDate, 'action_on'=> $data]);
                } else {
                    $status = 3;
                    $locationHQ = DB::table('locations')->where('id', $officeLocation)->select('parent_office_id', 'state_id')->get();
                    $officeLocationHQ = $locationHQ[0]->parent_office_id;
                    if ($officeLocationHQ == 0) {
                        $HqAdmin = DB::table('user_details')
                                ->join('users', 'user_details.user_id', 'users.id')
                                ->where('office_id', $officeLocation)
                                ->where('users.is_admin', 1)
                                ->select('user_details.user_id')->get();
                        
                    foreach ($HqAdmin as $key => $value) {
                        DB::table('tab_training_status')->insert(
                            ['crt_id' => $crt->id, 'user_id' => $crt->user_id, 'status' => $status, 'reportingmanager_id' => $value->user_id, 'nominate_date' => $nominateDate, 'action_on'=> $data]);
                    }
                    DB::table('tab_training_status')->where('id', '=', $id)->delete();
                    }
                }
            }
        }

//    DB::table('tab_training_status')
//            ->where('id', $id)
//            ->update(['status' => $status,'action_on'=> $data]);
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
        ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
        ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
        ->join('locations', 'user_details.office_id', '=', 'locations.id')
        ->where('tab_training_status.user_id',$studentid)
        ->where('crttrainings.status', 1)
        //->where('tab_training_status.department_id',$departmentid)
        ->whereDate('crttrainings.lastnominne', '<=', Carbon::now())
        ->select('crttrainings.id','users.first_name as name','crttrainings.start_date as start_date','crttrainings.end_date as end_date','crttrainings.lastnominne as lastnominne','crttrainings.title as title','venues.address','locations.parent_office_id','crttrainings.training_for')
        ->get();
        
        $trainingArr = array();
        $cnt = 0;
        foreach ($training_attended as $key => $value) {
            $trArr = array();
            $trArr['id'] = $value->id;
            $trArr['name'] = $value->name;
            $trArr['start_date'] = $value->start_date;
            $trArr['end_date'] = $value->end_date;
            $trArr['lastnominne'] = $value->lastnominne;
            $trArr['title'] = $value->title;
            $trArr['address'] = $value->address;
            if($value->training_for == "All Office"){
                $trArr['training_for'] = "All India";
            }elseif($value->training_for == "HQ Office"){
                $trArr['training_for'] = "HQ Only";
            }elseif($value->training_for == "State Office"){
                $trArr['training_for'] = "State Only";
            }
            if($value->parent_office_id == 0){
                $trArr['parent_office_id'] = "Head Office";
            }else{
                $trArr['parent_office_id'] = "State Office";
            }
            $trainingArr[$cnt] = (object) $trArr;
            $cnt++;
        }
        $training_attended = collect($trainingArr);

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
//        $attended_training  = Crttraining::where('department_id', $departmentid)->whereDate('end_date', '<', Carbon::now())->get();
        $attended_training  = DB::table("crttrainings")
                            ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                            ->join('user_details', 'crttrainings.created_by', '=', 'user_details.user_id')
                            ->join('locations', 'user_details.office_id', '=', 'locations.id')
                            ->where('crttrainings.department_id', $departmentid)->whereDate('crttrainings.end_date', '<', Carbon::now())
                            ->where('crttrainings.status', 1)
                            ->select('crttrainings.id','crttrainings.title','venues.address AS venue','crttrainings.end_date','locations.parent_office_id','crttrainings.training_for')
                            ->get();
        $trainingArr = array();
        $cnt = 0;
        foreach ($attended_training as $key => $value) {
            $trArr = array();
            $trArr['id'] = $value->id;
            $trArr['title'] = $value->title;
            $trArr['venue'] = $value->venue;
            $trArr['end_date'] = $value->end_date;
            
            if($value->training_for == "All Office"){
                $trArr['training_for'] = "All India";
            }elseif($value->training_for == "HQ Office"){
                $trArr['training_for'] = "HQ Only";
            }elseif($value->training_for == "State Office"){
                $trArr['training_for'] = "State Only";
            }
            
            if($value->parent_office_id == 0){
                $trArr['parent_office_id'] = "Head Office";
            }else{
                $trArr['parent_office_id'] = "State Office";
            }
            $trainingArr[$cnt] = (object) $trArr;
            $cnt++;
        }
        $attended_training = collect($trainingArr);
            return view('backend.trainings.attended_training',compact('attended_training','users'));
    }

    public function feedback()
    {

        $studentid = auth()->user()->id;
        $studentdetail = Userdetail::where('user_id', $studentid)->first();
        $departmentid = $studentdetail->department_id;
        $training_id_arr = array();
        $feedbacks = Feedback::where('department_id', $departmentid)->where('login_user_id', $studentid)->pluck('training_id');
        if ($feedbacks) {
            foreach ($feedbacks as $feedback) {
                $training_id_arr[] = $feedback;
            }
        }
        //$attendance  = Crttraining::where('department_id', $departmentid)->whereDate('start_date', '>', Carbon::now('Asia/Calcutta'))->whereDate('end_date', '>', Carbon::now('Asia/Calcutta'))->get();
        $attendance = Crttraining::join('attendances','crttrainings.id','attendances.training_id')
                ->join('training_attendance_by_day','attendances.id','training_attendance_by_day.attendance_id')
//                ->whereDate('start_date', '<', Carbon::now('Asia/Calcutta'))
                ->where('crttrainings.department_id', $departmentid)
                ->whereDate('crttrainings.end_date', '<', Carbon::now('Asia/Calcutta'))
                ->where('crttrainings.feedback', 'Good')
                ->where('training_attendance_by_day.present', 1)
                ->where('attendances.user_id', $studentid)
                ->whereNotIn('crttrainings.id', $training_id_arr)
                ->select('crttrainings.title')
                ->get();
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
        return view('backend.trainings.feedback', compact('attendance'));
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
                     ->join('crt_designations','crt_designations.crt_id','=','crttrainings.id')  
                     ->leftjoin('departments','crttrainings.department_id','=','departments.id')  
                     ->leftjoin('tracks','crttrainings.track_id','=','tracks.id') 
                     ->leftjoin('categories','crttrainings.category_id','=','categories.id')  
                     ->leftjoin('years','crttrainings.year_id','=','years.id')  
                     ->leftjoin('states','crttrainings.state_id','=','states.id') 
                     ->leftjoin('cities','crttrainings.city_id','=','cities.id')  
                    ->leftjoin('venues','crttrainings.venue_id','=','venues.id')  
                    ->leftjoin('designations','crt_designations.designation_id','=','designations.id')  
                    ->leftjoin('institute_industry','crttrainings.corinst_id','=','institute_industry.id')  
                    ->where('crttrainings.id',$id)  
                    ->select('crttrainings.id','crttrainings.title','crttrainings.start_date as startdate','crttrainings.end_date as enddate','crttrainings.lastnominne as nominationdate','departments.department_name', 'tracks.name as trackname','categories.name as categoryname','years.name as yearname','states.state as statename','cities.city as cityname','venues.address as venu','designations.designation as designationname','crttrainings.title as title','crttrainings.description as description','crttrainings.corempcode as coordinatecode','institute_industry.name as coordinateid','crttrainings.resourceempcode as resourceempcode','institute_industry.name as resourceinstituteid','crttrainings.timing as timing')     
                     ->orderBy('crttrainings.id', 'desc')->first(); 
	 // dd($crttrainings);
                     return view('backend.trainings.training_view',compact('crttrainings'));  
}

public function attendance()
{
        $userid = Auth::user()->id;
        $users = User::where('id', $userid)->first();
        $crtid = array();
        $studentid = auth()->user()->id;
        $studentdetail = Userdetail::where('user_id', $studentid)->first();
        $departmentid = $studentdetail->department_id;
        // $attendance  = Crttraining::where('department_id', $departmentid)->whereDate('start_date', '<=', Carbon::now('Asia/Calcutta'))->whereDate('end_date', '>=', Carbon::now('Asia/Calcutta'))->get();
        //$attendance  = Crttraining::where('department_id', $departmentid)->whereDate('start_date', '>', Carbon::now('Asia/Calcutta'))->whereDate('end_date', '>', Carbon::now('Asia/Calcutta'))->get();
        $attendance = Crttraining::where('department_id', $departmentid)
//                        ->whereDate('end_date', '>=', Carbon::now('Asia/Calcutta'))
                        ->whereDate('start_date', '<=', Carbon::now('Asia/Calcutta'))
                        ->whereDate('end_date', '>=', Carbon::now('Asia/Calcutta'))
                        ->where('status', 1)
                        ->select('start_date', 'end_date', 'id', 'title')
                        ->get();
        $student = DB::table('tab_training_status')
                        ->join('users', 'tab_training_status.user_id', '=', 'users.id')
                        ->join('user_details', 'users.id', '=', 'user_details.user_id')
                        ->join('designations', 'user_details.designation_id', '=', 'designations.id')
                        ->select('tab_training_status.id', 'users.first_name', 'users.id as user_id', 'designations.designation', 'designations.id as designation_id')
                        ->where('tab_training_status.status', '=', 1)->get();
        // print_r($student);
        // die;

        return view('backend.trainings.attendance', compact('attendance', 'student', 'departmentid'));
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
        $students = DB::table('tab_training_status')
                    ->join('users','tab_training_status.user_id','=','users.id')
                    ->join('user_details','users.id','=','user_details.user_id')
                    ->join('designations','user_details.designation_id','=','designations.id')
                    ->select('tab_training_status.id','tab_training_status.crt_id as crtid','users.first_name','users.id as user_id','designations.designation','designations.id as designation_id')
                    ->where('tab_training_status.status','=', 1)
			              ->where('tab_training_status.crt_id','=', $id)
                    ->where('tab_training_status.reportingmanager_id','=', $reportingmanagerid)  
			              ->get();
		if( $students) {
			foreach( $students as  $student) {
				$user_id = $student->user_id;
				$curDate = new \DateTime();
				$cur_day = $curDate->format("Y-m-d");
				$aid = DB::table('attendances')
							->leftJoin('training_attendance_by_day','training_attendance_by_day.attendance_id','=','attendances.id')
			                ->where('attendances.user_id','=',  $user_id)
							->where('attendances.training_id','=', $id)
                    		->where('attendances.created_by','=', $reportingmanagerid) 
							->where('training_attendance_by_day.day','=', $cur_day) 
							->select('training_attendance_by_day.present')
			                ->value('training_attendance_by_day.resent');
				if((int)$aid == 0)  $aid = 0;			
				$student->present = $aid;					
	}
		}			
		return json_encode($students);
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
        $department_id = $_GET['department_id'];
        $user_id = $_GET['user_id'];
        $designation_id = $_GET['designation_id'];
        //$present        =  $_GET['attendance'];  
        $attendance = $_GET['attendance'];
        $designation = $_GET['designation'];
        $name = $_GET['name'];
        $userid = Auth::user()->id;
        //DB::table('attendances')->insert(array('training_id' => $request->training_id, 'user_id' => $user_id,'designation_id' => $designation_id,'created_by' => $userid));  
        for ($i = 0; $i < count($user_id); $i++) {
            $id = DB::table('attendances')->select('id')->where('training_id', '=', $request->training_id)
                    ->where('user_id', '=', $user_id[$i])
                    ->where('designation_id', '=', $designation_id[$i])
                    ->where('department_id', '=', $department_id)
                    ->value('id');
            if ((int) $id == 0) {
                $attendanceid = DB::table('attendances')->insertGetId(
                        array('department_id' => $department_id, 'training_id' => $request->training_id, 'user_id' => $user_id[$i], 'designation_id' => $designation_id[$i], 'name' => $name[$i], 'designation' => $designation[$i], 'created_by' => $userid)
                );
                $id = DB::table('training_attendance_by_day')->insertGetId(
                        array('attendance_id' => $attendanceid, 'day' => Carbon::now('Asia/Calcutta'), 'present' => $attendance[$i])
                );
            }
            if ((int) $id > 0) {
                DB::table('attendances')->where('id', $id)->update(array('department_id' => $department_id, 'training_id' => $request->training_id, 'user_id' => $user_id[$i], 'designation_id' => $designation_id[$i], 'name' => $name[$i], 'designation' => $designation[$i], 'created_by' => $userid));
                $curDate = new \DateTime();
                $cur_day = $curDate->format("Y-m-d");
                $dayid = DB::table('training_attendance_by_day')->select('id')->where('attendance_id', '=', $id)
                        ->where('day', '=', $cur_day)
                        ->value('id');
                if ((int) $dayid == 0) {
                    DB::table('training_attendance_by_day')->insert(
                            array('attendance_id' => $id, 'day' => $cur_day, 'present' => $attendance[$i])
                    );
                }
                if ((int) $dayid > 0) {
                    DB::table('training_attendance_by_day')->where('id', $dayid)->update(array('present' => $attendance[$i]));
                }
            }
        }
        return Redirect::back();
    }
      
      public function crtDetailsFilter($id)
 {
          
          $crt = DB::table('crttrainings')
                ->join('departments', 'crttrainings.department_id', 'departments.id')
                ->join('tracks', 'crttrainings.track_id', 'tracks.id')
                ->join('categories', 'crttrainings.category_id', 'categories.id')
                ->join('years', 'crttrainings.year_id', 'years.id')
                ->join('states', 'crttrainings.state_id', 'states.id')
                ->join('cities', 'crttrainings.city_id', 'cities.id')
                ->join('venues', 'crttrainings.venue_id', 'venues.id')
                ->join('training_types', 'crttrainings.training_type', 'training_types.id')
                ->where('crttrainings.id', $id)
                ->select('crttrainings.id','crttrainings.title', 'departments.department_name', 'crttrainings.description', 'tracks.name AS track', 'categories.name AS category'
                        , 'years.year', 'states.state', 'cities.city', 'venues.address AS venue', 'crttrainings.timing', 'crttrainings.training_for', 'training_types.title AS training_type', 'crttrainings.lastnominne'
                        , 'crttrainings.start_date', 'crttrainings.end_date', 'crttrainings.feedback')
                ->first();
        /* Designation */
        $desgArr = array();
        $designation = DB::table('crt_designations')->join('designations', 'crt_designations.designation_id', 'designations.id')->where('crt_id', $id)->select('designations.designation')->get()->toArray();
        foreach ($designation as $desgkey => $desgval) {
            $desgArr[] = $desgval->designation;
        }
        /* Designation */
        $officeArr = array();
        $crt_nomination_office = DB::table('crt_nomination_office')->join('locations', 'crt_nomination_office.office_id', 'locations.id')->where('crt_id', $id)->select('locations.office_name')->get()->toArray();
        foreach ($crt_nomination_office as $officekey => $officeval) {
            $officeArr[] = $officeval->office_name;
        }
        /*Agenda*/
        $agenda = DB::table('agenda')->where('crt_id', $id)->get()->toArray();
        
        $agendaArr = array();
        foreach ($agenda as $agendakey => $agendaval) {
            $agArr = array();
            $agArr['session_duration_from'] = $agendaval->session_duration_from;
            $agArr['session_duration_to'] = $agendaval->session_duration_to;
            if($agendaval->type == 0){
                $agArr['type'] = "Lecture";
            }else{
                $agArr['type'] = "Break";
            }
            $agArr['title'] = $agendaval->title;
            if($agendaval->speaker == 0){
                $agArr['speaker'] = "Internal";
                $resoursePerson = DB::table('users')->select('first_name')->where('emp_code', $agendaval->resourse_person)->first();
                $resPerson = $resoursePerson->first_name;
            }else{
                $agArr['speaker'] = "External";
                $resoursePerson = DB::table('faculty')->select('name')->where('id', $agendaval->resourse_person)->first();
                $resPerson = $resoursePerson->name;
            }
            $agArr['resourse_person'] = $resPerson;
            $agendaArr[$agendaval->agenda_date][]=$agArr;
        }
        $agendaHtml = "";
        $agendaHtml .= '<table class="table table-bordered table-striped">
                            <tr>
                                <td>Sr No.</td>
                                <td>Agenda Date</td>
                                <td>Agenda</td>
                                <td>Documents</td>
                            </tr>';
        $cnt = 1;
        foreach ($agendaArr as $date => $agenda) {
            $agendaHtml .= '<tr>
                                <td>'.$cnt.'</td>
                                <td>'.$date.'</td>
                                <td>';
            
                $agendaHtml .= '<table>
                                    <tr>
                                    <td>Title</td>
                                    <td>From</td>
                                    <td>To</td>
                                    <td>Type</td>
                                    <td>Speaker</td>
                                    <td>Resourse Person</td>
                                    </tr>';
            foreach ($agenda as $key => $value) {
                $agendaHtml .= '<tr>
                                    <td>'.$value['title'].'</td>
                                    <td>'.$value['session_duration_from'].'</td>
                                    <td>'.$value['session_duration_to'].'</td>
                                    <td>'.$value['type'].'</td>
                                    <td>'.$value['speaker'].'</td>
                                    <td>'.$value['resourse_person'].'</td>
                                </tr>';
            }
            $agendaHtml .= '</table>';
            $agendaHtml .= '</td>
                            <td>';
                            $documents = DB::table('documents')->where('crt_id', $id)->get()->toArray();
                            $path = public_path() . '/storage/uploads/';
                            foreach ($documents as $dkey => $dval) {
                                $agendaHtml .= '<a href="'.url('/storage/uploads/'.$dval->file).'" download>'.$dval->description.'</a>';
                            }
            $agendaHtml .= '</td>
                           </tr>';
            $cnt = $cnt + 1;
        }
        $agendaHtml .= '</tbody><table>';
        
        $returnArr = array();
        $returnArr['id'] = $crt->id;
        $returnArr['title'] = $crt->title;
        $returnArr['department_name'] = $crt->department_name;
        $returnArr['description'] = $crt->description;
        $returnArr['track'] = $crt->track;
        $returnArr['category'] = $crt->category;
        $returnArr['year'] = $crt->year;
        $returnArr['state'] = $crt->state;
        $returnArr['city'] = $crt->city;
        $returnArr['venue'] = $crt->venue;
        $returnArr['designation'] = implode(", ", $desgArr);
        $returnArr['timing'] = $crt->timing;
        /* Training For */
        if ($crt->training_for == "All Office") {
            $returnArr['training_for'] = "All India";
        } elseif ($crt->training_for == "HQ Office") {
            $returnArr['training_for'] = "HQ Only";
        } elseif ($crt->training_for == "State Office") {
            $returnArr['training_for'] = "State Only";
        }
        $returnArr['training_type'] = $crt->training_type;
        $returnArr['lastnominne'] = $crt->lastnominne;
        $returnArr['start_date'] = $crt->start_date;
        $returnArr['end_date'] = $crt->end_date;
        $returnArr['nomination_office'] = implode(", ", $officeArr);
        $returnArr['feedback'] = $crt->feedback;
        $returnArr['agenda'] = $agendaHtml;
        return json_encode($returnArr, TRUE);
    }
    
    public function checkNominationFilter($id){
        $userid = Auth::user()->id;
        $crtId = $id;
        
        $nominationQry = DB::table('crttrainings')
                            ->where('id',$crtId)
                            ->select('lastnominne')
                            ->first();
        
        $lastDateNomination = $nominationQry->lastnominne;
        
        $crt = DB::table('crttrainings')
                ->join('tab_training_status','crttrainings.id','tab_training_status.crt_id')
                ->where('tab_training_status.user_id',$userid)
                ->where('tab_training_status.status',1)
                ->whereDate('crttrainings.lastnominne','<',$lastDateNomination)
                ->whereDate('crttrainings.end_date','>',$lastDateNomination)
                ->count();
        
        return $crt;
    }
}
