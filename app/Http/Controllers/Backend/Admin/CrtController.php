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
use App\Models\Track;
use App\Models\Category;
use App\Models\Year;
use App\Models\States;
use App\Models\Cities;
use App\Models\Designations;
use App\Models\InstituteIndustry;
use App\Http\Requests\Admin\StoreCrtRequest;
use App\Http\Requests\Admin\UpdateCrtRequest;
use App\Models\Crttraining;


class CrtController extends Controller
{
    
    public function index()
    { 
        $crttrainings=DB::table('crttrainings')
                     ->join('departments','crttrainings.department_id','=','departments.id')
                     ->join('tracks','crttrainings.track_id','=','tracks.id')
                     ->join('categories','crttrainings.category_id','=','categories.id')
                     ->join('years','crttrainings.year_id','=','years.id')
                     ->join('states','crttrainings.state_id','=','states.id')
                     ->join('cities','crttrainings.city_id','=','cities.id')
                    ->join('venues','crttrainings.venue_id','=','venues.id')
//                    ->join('designations','crttrainings.designation_id','=','designations.id')
                    ->join('institute_industry','crttrainings.corinst_id','=','institute_industry.id')
                    ->select('crttrainings.id','departments.department_name', 'tracks.name as trackname','categories.name as categoryname','years.name as yearname','states.state as statename','cities.city as cityname','venues.address as venu','crttrainings.title as title','crttrainings.description as description','crttrainings.corempcode as coordinatecode','institute_industry.name as coordinateid','crttrainings.resourceempcode as resourceempcode','institute_industry.name as resourceinstituteid','crttrainings.timing as timing')    
                     ->orderBy('crttrainings.id', 'desc')->get();
        
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }
        
        return view('backend.crts.index', compact('crttrainings','officeLocation'));
    }
        public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $has_publish = false;
        $has_unpublish = false;
        $tracks = "";
        
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id','state_id')->get();
                $officeLocation = $location[0]->parent_office_id;
                $state_id = $location[0]->state_id;
            }
        }
        
        if($officeLocation == 0){
        $crttrainings=DB::table('crttrainings')
                     ->leftjoin('departments','crttrainings.department_id','=','departments.id')
                     ->leftjoin('tracks','crttrainings.track_id','=','tracks.id')
                     ->leftjoin('categories','crttrainings.category_id','=','categories.id')
                     ->leftjoin('years','crttrainings.year_id','=','years.id')
                     ->leftjoin('states','crttrainings.state_id','=','states.id')
                     ->leftjoin('cities','crttrainings.city_id','=','cities.id')
                     ->leftjoin('venues','crttrainings.venue_id','=','venues.id')
//                    ->where('crttrainings.created_by',auth()->user()->id)
                    ->whereIn('crttrainings.training_for',["HQ Office","All Office"])
                     ->select('crttrainings.id','departments.department_name', 'tracks.name as trackname','categories.name as categoryname','years.year as yearname','states.state as statename','cities.city as cityname','venues.address as venu','crttrainings.title as title','crttrainings.description as description','crttrainings.corempcode as coordinatecode','crttrainings.resourceempcode as resourceempcode','crttrainings.timing as timing','crttrainings.status','crttrainings.training_for','crttrainings.start_date','crttrainings.end_date')    
                     ->orderBy('crttrainings.id', 'desc')->get();
        }elseif(isset($state_id) && $officeLocation != 0){
            $crttrainings=DB::table('crttrainings')
                     ->leftjoin('departments','crttrainings.department_id','=','departments.id')
                     ->leftjoin('tracks','crttrainings.track_id','=','tracks.id')
                     ->leftjoin('categories','crttrainings.category_id','=','categories.id')
                     ->leftjoin('years','crttrainings.year_id','=','years.id')
                     ->leftjoin('states','crttrainings.state_id','=','states.id')
                     ->leftjoin('cities','crttrainings.city_id','=','cities.id')
                     ->leftjoin('venues','crttrainings.venue_id','=','venues.id')
                     ->where('crttrainings.state_id',$state_id)
//                     ->where('crttrainings.created_by',auth()->user()->id)
                     ->where('crttrainings.training_for',"State Office")
                     ->select('crttrainings.id','departments.department_name', 'tracks.name as trackname','categories.name as categoryname','years.year as yearname','states.state as statename','cities.city as cityname','venues.address as venu','crttrainings.title as title','crttrainings.description as description','crttrainings.corempcode as coordinatecode','crttrainings.resourceempcode as resourceempcode','crttrainings.timing as timing','crttrainings.status','crttrainings.training_for','crttrainings.start_date','crttrainings.end_date')    
                     ->orderBy('crttrainings.id', 'desc')->get();
        }else{
            $crttrainings=DB::table('crttrainings')
                     ->leftjoin('departments','crttrainings.department_id','=','departments.id')
                     ->leftjoin('tracks','crttrainings.track_id','=','tracks.id')
                     ->leftjoin('categories','crttrainings.category_id','=','categories.id')
                     ->leftjoin('years','crttrainings.year_id','=','years.id')
                     ->leftjoin('states','crttrainings.state_id','=','states.id')
                     ->leftjoin('cities','crttrainings.city_id','=','cities.id')
                     ->leftjoin('venues','crttrainings.venue_id','=','venues.id')
                     ->select('crttrainings.id','departments.department_name', 'tracks.name as trackname','categories.name as categoryname','years.year as yearname','states.state as statename','cities.city as cityname','venues.address as venu','crttrainings.title as title','crttrainings.description as description','crttrainings.corempcode as coordinatecode','crttrainings.resourceempcode as resourceempcode','crttrainings.timing as timing','crttrainings.status','crttrainings.training_for','crttrainings.start_date','crttrainings.end_date')    
                     ->orderBy('crttrainings.id', 'desc')->get();
            }
        $crtArr = array();
            $cnt = 0;
        foreach ($crttrainings as $key => $value) {
            $trArr = array();
            $trArr['id'] = $value->id;
            $trArr['department_name'] = $value->department_name;
            $trArr['trackname'] = $value->trackname;
            $trArr['categoryname'] = $value->categoryname;
            $trArr['yearname'] = $value->yearname;
//            $trArr['statename'] = $value->statename;
//            $trArr['cityname'] = $value->cityname;
//            $trArr['venu'] = $value->venu;
        
            $trArr['state_city_venue'] = $value->statename."/".$value->cityname."/".$value->venu;
            $trArr['title'] = $value->title;
            $trArr['description'] = $value->description;
            $trArr['coordinatecode'] = $value->coordinatecode;
            $trArr['resourceempcode'] = $value->resourceempcode;
            $trArr['timing'] = $value->timing;
            $trArr['status'] = $value->status;
        
            if($value->training_for == "All Office"){
                $trArr['training_for'] = "All India";
            }elseif($value->training_for == "HQ Office"){
                $trArr['training_for'] = "HQ Only";
            }elseif($value->training_for == "State Office"){
                $trArr['training_for'] = "State Only";
            }
            $trArr['duration'] = $value->start_date." - ".$value->end_date;
        
            $crtArr[$cnt] = (object) $trArr;
            $cnt++;
        }
        $crttrainings = collect($crtArr);
        
        if (auth()->user()->isAdmin() || (auth()->user()->is_admin == 1)) {
            $has_view = true;
            $has_edit = true;
            $has_delete = true;
            $has_publish = true;
            $has_unpublish = true;
        }
        
        return DataTables::of($crttrainings)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                 if ($request->show_deleted == 1) {
                     return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.crt', 'label' => 'crt', 'value' => $q->id]);
                }          
                 if ($has_edit) {
                     $edit = view('backend.datatable.action-edit')
                         ->with(['route' => route('admin.crt.edit', ['crttrainings' => $q->id])])
                        ->render();
                     $view .= $edit;
                 }
                 if ($has_delete) {
                     $delete = view('backend.datatable.action-delete')
                         ->with(['route' => route('admin.crt.destroy', ['crttrainings' => $q->id])])
                         ->render();
                     $view .= $delete;
                 }
                 if ($has_publish || $has_unpublish) {
                    if($q->status == 1){
                        $publish = view('backend.datatable.action-unpublish')
                        ->with(['route' => route('admin.crt.unpublish', ['crttrainings' => $q->id])])
                        ->render();
                        $view .= $publish;
                    } else{
                        $unpublish = view('backend.datatable.action-publish')
                        ->with(['route' => route('admin.crt.publish', ['crttrainings' => $q->id])])
                        ->render();
                        $view .= $unpublish;
                    }
                }
                $agenda = '<a href="'.url('/user/agenda?crt='.$q->id).'" class="btn btn-xs btn-warning mb-1">Agenda</a>';
                       $view .= $agenda;
                return $view;
            })
            ->rawColumns(['actions', 'image'])
            ->make();
    }
    
    public function create()
    {
        $blankArr = array("" => "Please select");
        $category =  $blankArr;
        $states =  $blankArr;
        $cities =  $blankArr;
        
        /*For Office Location*/
        $officeLocation = 1;
        $stateId = 0;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id','state_id')->get();
                $officeLocation = $location[0]->parent_office_id;
                $stateId = $location[0]->state_id;
            }
        }
        
        if(auth()->user()->isAdmin()){
            $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
            $tracks =  $blankArr;
            $years =  $blankArr;
            $venues =  $blankArr;
            $designations =  array();
            $instituteIndustry =  $blankArr;
            $faculty =  $blankArr;
            $training_types =  $blankArr;
            $office_location =  $blankArr;
        }else{
            $userId = auth()->user()->id;
            $userdetails = DB::table('user_details')->where('user_id', '=', $userId)->get();
            $deptId = $userdetails[0]->department_id;
            $department = Departments::where('id', '=', $deptId)->pluck('department_name', 'id');
            $tracks =  DB::table('tracks')->select('name','id as track_id')->where('department_id', '=', $deptId)->where('status', '=', 1)->pluck('name','track_id')->prepend('Please select', '');
            $years = DB::table('years')->select('year','id as year_id')->where('department_id', '=', $deptId)->where('status', '=', 1)->pluck('year','year_id')->prepend('Please select', '');
            $venues = DB::table('venues')->select('address','id as venue_id')->where('department_id', '=', $deptId)->pluck('address','venue_id')->prepend('Please select', '');
            $designations = Designations::where('status', '=', 1)->where('department_id', '=', $deptId)->pluck('designation', 'id as designation_id')->prepend('Please select', '');
            $instituteIndustry =  DB::table('institute_industry')->select('name','id as venue_id')->where('department_id', '=', $deptId)->pluck('name', 'venue_id')->prepend('Please select', '');
            
            if($officeLocation != 0){
                $office_location =  DB::table('locations')->select('office_name','id as office_id')->where('department_id', '=', $deptId)->where('state_id', '=', $stateId)->pluck('office_name', 'office_id');
            }else{
            $office_location =  DB::table('locations')->select('office_name','id as office_id')->where('department_id', '=', $deptId)->pluck('office_name', 'office_id')->prepend('All Office', '0');
            }
            
//            $faculty =  DB::table('faculty')->select('name','id')->where('department_id', '=', $deptId)->pluck('name', 'id')->prepend('Please select', '');
            $faculty =  $blankArr;
            $training_types =  DB::table('training_types')->select('title','id')->where('department_id', '=', $deptId)->pluck('title', 'id')->prepend('Please select', '');
        }
      $states = States::where('status', '=', 1)->pluck('state', 'id as state_id')->prepend('Please select', '');
    
    return view('backend.crts.create',compact('department','tracks', 'category','years','states','cities','venues','designations','instituteIndustry','faculty','training_types','office_location'));
    }
 
    public function store(StoreCrtRequest $request)
    {
        $intArr = array();
        if(count($request->cooExternal) > 0)  {
            foreach ($request->cooExternal as $key => $value) {
                $keys = str_replace("'", "", $key);
                if($keys == "instituteIndustry" && $value != ""){
                    $intArr['instituteIndustry'] = $value;
                }
                if($keys == "faculty" && $value != ""){
                    $intArr['faculty'] = $value;
                }
            }
        }
        $recArr = array();
        if(count($request->resourceExternal) > 0)  {
            foreach ($request->resourceExternal as $key => $value) {
                $keys = str_replace("'", "", $key);
                if($keys == "instituteIndustry" && $value != ""){
                    $recArr['instituteIndustry'] = $value;
                }
                if($keys == "faculty" && $value != ""){
                    $recArr['faculty'] = $value;
                }
            }
        }
        $slot = "";
        if(isset($request->slot) && $request->slot != ""){
            $slot = $request->slot;
        }
        $training_type = "";
        if(isset($request->training_type) && $request->training_type != ""){
            $training_type = $request->training_type;
        }
    $crts =  new Crttraining;
    $crts->department_id = $request->department_id;
    $crts->track_id = $request->track_id;
    $crts->category_id = $request->category_id;
    $crts->year_id = $request->year_id;
    $crts->state_id = $request->state_id;
    $crts->city_id = $request->city_id;
    $crts->venue_id = $request->venue_id;
    $crts->title = $request->title;
    $crts->description = $request->description;
    $crts->corempcode = "";
    $crts->corinst_id = "0";
    $crts->resourceempcode = "";
    $crts->resourceinst_id = "0";
    $crts->timing = $request->timing;
    $crts->slot = $slot;
    $crts->training_for = $request->training_for;
    $crts->training_type = $training_type;
    $crts->start_date = date('Y-m-d', strtotime($request->start_date));
    $crts->end_date = date('Y-m-d', strtotime($request->end_date));
    $crts->lastnominne = date('Y-m-d', strtotime($request->lastnominne));
    $crts->feedback = $request->feedback;
    $crts->created_by = $request->created_by;
    $crts->status = $request->status;
//    $crts = Crttraining::create($request->all());
    $crts->save();
    
    $insertedId = $crts->id;
    /*Nomination From Office*/
    foreach ($request->nomintation_from_office as $officeId) {
        if($officeId != ""){
            $crt_office = DB::table('crt_nomination_office')->insert(
                [
                'crt_id' => $insertedId, 
                'office_id' => $officeId, 
                ]
            );
        }
    }
    
    foreach ($request->designation_id as $designationId) {
            if($designationId != ""){
                $faculty_subject = DB::table('crt_designations')->insert(
                    [
                    'crt_id' => $insertedId, 
                    'designation_id' => $designationId, 
                    ]
                );
            }
        }
    
    /*For Insert Coordinator*/
    /*Internal*/
    if(count($request->cooInternal) > 0)  {
            foreach ($request->cooInternal as $key => $value) {
                DB::table('coordinator')->insert(
                [
                'crt_training_id' => $crts->id,
                'internalexternal' => 0,
                'emp_code' => $value,
                'inst_ind_id' => "",
                'faculty_id' => "",
                'status' => "1",
                ]
                );
            }
        }
    /*External*/
        if(count($intArr) > 0)  {
            foreach ($intArr['instituteIndustry'] as $keyCoo => $valueCoo) {
                DB::table('coordinator')->insert(
                [
                'crt_training_id' => $crts->id,
                'internalexternal' => 1,
                'emp_code' => "",
                'inst_ind_id' => $valueCoo,
                'faculty_id' => $intArr['faculty'][$keyCoo],
                'status' => "1",
                ]
                );
            }
        }
    /*For Insert Resource*/
    /*Internal*/
    if(count($request->resourceInternal) > 0)  {
            foreach ($request->resourceInternal as $key => $value) {
                DB::table('resource_person')->insert(
                [
                'crt_training_id' => $crts->id,
                'internalexternal' => 0,
                'emp_code' => $value,
                'inst_ind_id' => "",
                'faculty_id' => "",
                'status' => "1",
                ]
                );
            }
        }
    /*External*/
        if(count($recArr) > 0)  {
            foreach ($recArr['instituteIndustry'] as $keyRec => $valueRec) {
                DB::table('resource_person')->insert(
                [
                'crt_training_id' => $crts->id,
                'internalexternal' => 1,
                'emp_code' => "",
                'inst_ind_id' => $valueRec,
                'faculty_id' => $recArr['faculty'][$keyRec],
                'status' => "1",
                ]
                );
            }
        }
        
        
   
    return redirect()->route('admin.crt.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    public function edit($id)
    {

        $crttrainings = DB::table('crttrainings')
                ->join('departments', 'crttrainings.department_id', '=', 'departments.id')
                ->join('tracks', 'crttrainings.track_id', '=', 'tracks.id')
                ->join('categories', 'crttrainings.category_id', '=', 'categories.id')
                ->join('years', 'crttrainings.year_id', '=', 'years.id')
                ->join('states', 'crttrainings.state_id', '=', 'states.id')
                ->join('cities', 'crttrainings.city_id', '=', 'cities.id')
                ->join('venues', 'crttrainings.venue_id', '=', 'venues.id')
                ->join('training_types', 'crttrainings.training_type', '=', 'training_types.id')
                ->where('crttrainings.id', $id)
                ->select('crttrainings.id', 'crttrainings.slot', 'crttrainings.training_for', 'crttrainings.training_type', 'departments.department_name', 'departments.id as deptId', 'tracks.name as trackname', 'categories.name as categoryname','categories.id as categoryId', 'years.name as yearname', 'states.state as statename', 'cities.city as cityname', 'venues.address as venu', 'crttrainings.title as title', 'crttrainings.description as description', 'crttrainings.corempcode as coordinatecode', 'crttrainings.resourceempcode as resourceempcode', 'crttrainings.timing as timing', 'crttrainings.start_date as startdate', 'crttrainings.end_date as enddate', 'crttrainings.lastnominne as lastnominne', 'crttrainings.department_id as deptid', 'crttrainings.track_id as trackid', 'crttrainings.category_id as categoryid', 'crttrainings.year_id as yearid', 'crttrainings.state_id as stateid', 'crttrainings.city_id as cityid', 'crttrainings.venue_id as venuid', 'crttrainings.corinst_id as corinstid', 'crttrainings.training_type', 'crttrainings.status')
                ->first();
        
            $blankArr = array("" => "Please select");
            $category =  $blankArr;
            $states =  $blankArr;
            $cities =  $blankArr;
            
        /*For Office Location*/
        $officeLocation = 1;
        $stateId = 0;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id','state_id')->get();
                $officeLocation = $location[0]->parent_office_id;
                $stateId = $location[0]->state_id;
            }
        }
            
//        if(auth()->user()->is_admin == 1 && $officeLocation == 0){
//            $userId = auth()->user()->id;
//            $userdetails = DB::table('user_details')->where('user_id', '=', $userId)->get();
//            $deptId = $userdetails[0]->department_id;
//            $department = Departments::where('id', '=', $deptId)->pluck('department_name', 'id');
//            $tracks =  DB::table('tracks')->select('name','id as track_id')->where('department_id', '=', $deptId)->where('status', '=', 1)->pluck('name','track_id')->prepend('Please select', '');
//            $category = Category::where('status', '=', 1)->where('department_id', '=', $deptId)->pluck('name', 'id as  category_id')->prepend('Please select', '');
//            $years = DB::table('years')->select('year','id as year_id')->where('department_id', '=', $deptId)->where('status', '=', 1)->pluck('year','year_id')->prepend('Please select', '');
//            $venues = DB::table('venues')->select('address','id as venue_id')->where('department_id', '=', $deptId)->pluck('address','venue_id')->prepend('Please select', '');
//            $designations = Designations::where('status', '=', 1)->where('department_id', '=', $deptId)->pluck('designation', 'id as designation_id')->prepend('Please select', '');
//            $instituteIndustry =  DB::table('institute_industry')->select('name','id as venue_id')->where('department_id', '=', $deptId)->pluck('name', 'venue_id')->prepend('Please select', '');
//            $faculty =  DB::table('faculty')->select('name','id')->where('department_id', '=', $deptId)->pluck('name', 'id')->prepend('Please select', '');
//            $training_types =  DB::table('training_types')->select('title','id')->where('department_id', '=', $deptId)->pluck('title', 'id')->prepend('Please select', '');
//            $office_location =  DB::table('locations')->select('office_name','id as office_id')->where('department_id', '=', $deptId)->pluck('office_name', 'office_id')->prepend('All Office', '0');
//        }else{
//            $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
//            $tracks = DB::table('tracks')->select('name', 'id as track_id')->where('status', '=', 1)->pluck('name', 'track_id')->prepend('Please select', '');
//            $category = Category::where('status', '=', 1)->pluck('name', 'id as  category_id')->prepend('Please select', '');
//            $years = DB::table('years')->select('year', 'id as year_id')->where('status', '=', 1)->pluck('year', 'year_id')->prepend('Please select', '');
//            $venues = DB::table('venues')->select('address', 'id as venue_id')->pluck('address', 'venue_id')->prepend('Please select', '');
//            $designations = Designations::where('status', '=', 1)->pluck('designation', 'id as designation_id')->prepend('Please select', '');
//            $instituteIndustry = DB::table('institute_industry')->select('name', 'id')->where('department_id', '=', $crttrainings->deptId)->pluck('name', 'id')->prepend('Please select', '');
//            $faculty = DB::table('faculty')->select('name', 'id')->where('department_id', '=', $crttrainings->deptId)->pluck('name', 'id')->prepend('Please select', '');
//            $training_types =  DB::table('training_types')->select('title','id')->pluck('title', 'id')->prepend('Please select', '');
//            $office_location =  DB::table('locations')->select('office_name','id as office_id')->pluck('office_name', 'office_id')->prepend('All Office', '0');
//        }
        if(auth()->user()->isAdmin()){
            $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
            $tracks = DB::table('tracks')->select('name', 'id as track_id')->where('status', '=', 1)->pluck('name', 'track_id')->prepend('Please select', '');
            $category = Category::where('status', '=', 1)->pluck('name', 'id as  category_id')->prepend('Please select', '');
            $years = DB::table('years')->select('year', 'id as year_id')->where('status', '=', 1)->pluck('year', 'year_id')->prepend('Please select', '');
            $venues = DB::table('venues')->select('address', 'id as venue_id')->pluck('address', 'venue_id')->prepend('Please select', '');
            $designations = Designations::where('status', '=', 1)->pluck('designation', 'id as designation_id')->prepend('Please select', '');
            $instituteIndustry = DB::table('institute_industry')->select('name', 'id')->where('department_id', '=', $crttrainings->deptId)->pluck('name', 'id')->prepend('Please select', '');
            $faculty = DB::table('faculty')->select('name', 'id')->where('department_id', '=', $crttrainings->deptId)->pluck('name', 'id')->prepend('Please select', '');
            $training_types =  DB::table('training_types')->select('title','id')->pluck('title', 'id')->prepend('Please select', '');
            $office_location =  DB::table('locations')->select('office_name','id as office_id')->pluck('office_name', 'office_id')->prepend('All Office', '0');
        }else{
            $userId = auth()->user()->id;
            $userdetails = DB::table('user_details')->where('user_id', '=', $userId)->get();
            $deptId = $userdetails[0]->department_id;
            $department = Departments::where('id', '=', $deptId)->pluck('department_name', 'id');
            $tracks =  DB::table('tracks')->select('name','id as track_id')->where('department_id', '=', $deptId)->where('status', '=', 1)->pluck('name','track_id')->prepend('Please select', '');
            $category = Category::where('status', '=', 1)->where('department_id', '=', $deptId)->pluck('name', 'id as  category_id')->prepend('Please select', '');
            $years = DB::table('years')->select('year','id as year_id')->where('department_id', '=', $deptId)->where('status', '=', 1)->pluck('year','year_id')->prepend('Please select', '');
            $venues = DB::table('venues')->select('address','id as venue_id')->where('department_id', '=', $deptId)->pluck('address','venue_id')->prepend('Please select', '');
            $designations = Designations::where('status', '=', 1)->where('department_id', '=', $deptId)->pluck('designation', 'id as designation_id')->prepend('Please select', '');
            $instituteIndustry =  DB::table('institute_industry')->select('name','id as venue_id')->where('department_id', '=', $deptId)->pluck('name', 'venue_id')->prepend('Please select', '');
            $faculty =  DB::table('faculty')->select('name','id')->where('department_id', '=', $deptId)->pluck('name', 'id')->prepend('Please select', '');
            $training_types =  DB::table('training_types')->select('title','id')->where('department_id', '=', $deptId)->pluck('title', 'id')->prepend('Please select', '');
//            $office_location =  DB::table('locations')->select('office_name','id as office_id')->where('department_id', '=', $deptId)->pluck('office_name', 'office_id')->prepend('All Office', '0');
            if($officeLocation != 0){
                $office_location =  DB::table('locations')->select('office_name','id as office_id')->where('department_id', '=', $deptId)->where('state_id', '=', $stateId)->pluck('office_name', 'office_id');
            }else{
            $office_location =  DB::table('locations')->select('office_name','id as office_id')->where('department_id', '=', $deptId)->pluck('office_name', 'office_id')->prepend('All Office', '0');
        }
        }
        
        $crt_designationData = DB::table("crt_designations")->where('crt_id',$id)->select("designation_id")->get();
        $crt_designation = array();
        foreach ($crt_designationData as $key => $value) {
            $crt_designation[] = $value->designation_id;
        }
        $crt_nomination_office = DB::table('crt_nomination_office')->select('office_id')->where('crt_id', '=', $id)->get();
        $nomination_office = array();
        foreach ($crt_nomination_office as $key => $value) {
            $nomination_office[] = $value->office_id;
        }
        
        $states = States::where('status', '=', 1)->pluck('state', 'id as state_id')->prepend('Please select', '');
        $cities = Cities::where('status', '=', 1)->pluck('city', 'id as city_id')->prepend('Please select', '');
        $coordinator = DB::table('coordinator')->select('id','internalexternal','emp_code','inst_ind_id','faculty_id')->where('crt_training_id', '=', $id)->get();
        $resource = DB::table('resource_person')->select('id','internalexternal','emp_code','inst_ind_id','faculty_id')->where('crt_training_id', '=', $id)->get();

        $cooFacultyArr = array();
        foreach ($coordinator as $cooKey => $cooValue) {
            if($cooValue->internalexternal == 1){
                $cooFaculty = DB::table('faculty')->select('name', 'id')->where('institute_industry_id', '=', $cooValue->inst_ind_id)->pluck('name', 'id')->prepend('Please select', '');
                $cooFacultyArr[$cooValue->inst_ind_id] = $cooFaculty;        
            }
        }
        $recFacultyArr = array();
        foreach ($resource as $recKey => $recValue) {
            if($recValue->internalexternal == 1){
                $cooFaculty = DB::table('faculty')->select('name', 'id')->where('institute_industry_id', '=', $recValue->inst_ind_id)->pluck('name', 'id')->prepend('Please select', '');
                $recFacultyArr[$recValue->inst_ind_id] = $cooFaculty;        
            }
        }
        return view('backend.crts.edit', compact('crttrainings', 'department', 'tracks', 'category', 'years', 'states', 'cities', 'venues', 'designations', 'instituteIndustry', 'coordinator', 'resource', 'faculty', 'training_types','crt_designation','cooFacultyArr','recFacultyArr','nomination_office','office_location'));
    }
   
    public function update(UpdateCrtRequest $request, $id)
    {
        DB::table('coordinator')->where('crt_training_id', '=', $id)->delete();
        DB::table('resource_person')->where('crt_training_id', '=', $id)->delete();
        
        $intArr = array();
        if(count($request->cooExternal) > 0)  {
            foreach ($request->cooExternal as $key => $value) {
                $keys = str_replace("'", "", $key);
                if($keys == "instituteIndustry" && $value != ""){
                    $intArr['instituteIndustry'] = $value;
                }
                if($keys == "faculty" && $value != ""){
                    $intArr['faculty'] = $value;
                }
            }
        }
        $recArr = array();
        if(count($request->resourceExternal) > 0)  {
            foreach ($request->resourceExternal as $key => $value) {
                $keys = str_replace("'", "", $key);
                if($keys == "instituteIndustry" && $value != ""){
                    $recArr['instituteIndustry'] = $value;
                }
                if($keys == "faculty" && $value != ""){
                    $recArr['faculty'] = $value;
                }
            }
        }
        
        /*Nomination From Office*/
    DB::table('crt_nomination_office')->where('crt_id', '=', $id)->delete();
    foreach ($request->nomintation_from_office as $officeId) {
        if($officeId != ""){
            $crt_office = DB::table('crt_nomination_office')->insert(
                [
                'crt_id' => $id, 
                'office_id' => $officeId, 
                ]
            );
        }
    }
        
        /*For Insert Coordinator*/
    /*Internal*/
    if(count($request->cooInternal) > 0)  {
            foreach ($request->cooInternal as $key => $value) {
                DB::table('coordinator')->insert(
                [
                'crt_training_id' => $id,
                'internalexternal' => 0,
                'emp_code' => $value,
                'inst_ind_id' => "",
                'faculty_id' => "",
                'status' => "1",
                ]
                );
            }
        }
    /*External*/
        if(count($intArr) > 0)  {
            foreach ($intArr['instituteIndustry'] as $keyCoo => $valueCoo) {
                DB::table('coordinator')->insert(
                [
                'crt_training_id' => $id,
                'internalexternal' => 1,
                'emp_code' => "",
                'inst_ind_id' => $valueCoo,
                'faculty_id' => $intArr['faculty'][$keyCoo],
                'status' => "1",
                ]
                );
            }
        }
    /*For Insert Resource*/
    /*Internal*/
    if(count($request->resourceInternal) > 0)  {
            foreach ($request->resourceInternal as $key => $value) {
                DB::table('resource_person')->insert(
                [
                'crt_training_id' => $id,
                'internalexternal' => 0,
                'emp_code' => $value,
                'inst_ind_id' => "",
                'faculty_id' => "",
                'status' => "1",
                ]
                );
            }
        }
    /*External*/
        if(count($recArr) > 0)  {
            foreach ($recArr['instituteIndustry'] as $keyRec => $valueRec) {
                DB::table('resource_person')->insert(
                [
                'crt_training_id' => $id,
                'internalexternal' => 1,
                'emp_code' => "",
                'inst_ind_id' => $valueRec,
                'faculty_id' => $recArr['faculty'][$keyRec],
                'status' => "1",
                ]
                );
            }
        }
        $department_id = $request->department_id;
        $track_id = $request->track_id;
        $category_id = $request->category_id;
        $year_id = $request->year_id;
        $state_id = $request->state_id;
        $city_id = $request->city_id;
        $venue_id = $request->venue_id;
        $title = $request->title;
        $description = $request->description;
        $timing = $request->timing;
        $slot = isset($request->slot) ? $request->slot : '';
        $training_for = isset($request->training_for) ? $request->training_for : '';
        $training_type = isset($request->training_type) ? $request->training_type : '';
        $start_date = $request->start_date;   
        $end_date = $request->end_date;  
        $lastnominne = $request->lastnominne;      
        $feedback = $request->feedback; 
        $status = $request->status;
        DB::table('crttrainings')
        ->where('id', $id)  
        ->update(array( 'department_id' => $department_id,
                        'track_id'=>$track_id,
                        'category_id'=>$category_id,
                        'year_id'=>$year_id,
                        'state_id'=>$state_id,
                        'city_id'=>$city_id,
                        'venue_id'=>$venue_id,
                        'title'=>$title,
                        'description'=>$description,
                        'timing'=>$timing,
                        'slot'=>$slot,
                        'training_for'=>$training_for,
                        'training_type'=>$training_type,
                        'start_date'=>$start_date,
                        'end_date'=>$end_date,
                        'lastnominne'=>$lastnominne,
                        'status'=>$status,));
        
        DB::table('crt_designations')->where('crt_id', '=', $id)->delete();
        foreach ($request->designation_id as $designationId) {
            if($designationId != ""){
                $faculty_subject = DB::table('crt_designations')->insert(
                    [
                    'crt_id' => $id, 
                    'designation_id' => $designationId, 
                    ]
                );
            }
        }
        
        return redirect()->route('admin.crt.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    public function destroy($id)
    {
       DB::table('crttrainings')->where('id', $id)->delete(); 
       return redirect()->route('admin.crt.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
    
    public function officeFilter($id)
    {
        $departmentChangeArr = array();
        /* For Tracks */
        $tracks = DB::table("tracks")
                    ->where("department_id",$id)
                    ->select("name","id")
                    ->pluck('name','id');
        
        /* For Years */
        $years = DB::table("years")
                    ->where("department_id",$id)
                    ->where("status",1)
                    ->select("name","id")
                    ->pluck('name','id');
        
        /* For Venues */
        $venues = DB::table("venues")
                    ->where("department_id",$id)
                    ->select("address","id")
                    ->pluck('address','id');
        
        /* For Designations (Level)*/
        $level = DB::table("designations")
                    ->where("department_id",$id)
                    ->select("designation","id")
                    ->pluck('designation','id');
        
        /* For institute_industry */
        $institute_industry = DB::table("institute_industry")
                    ->where("department_id",$id)
                    ->select("name","id")
                    ->pluck('name','id');
        
        /* For institute_industry */
        $faculty = DB::table("faculty")
                    ->where("department_id",$id)
                    ->select("name","id")
                    ->pluck('name','id');
        
        /* For Training Types */
        $training_types = DB::table("training_types")
                    ->where("department_id",$id)
                    ->select("title","id")
                    ->pluck('title','id');
        
        /* For Office Location*/
        $office_location = DB::table("locations")
                    ->where("department_id",$id)
                    ->select("office_name","id")
                    ->pluck('office_name','id')
                    ->prepend('All Office', 0);
        
        $departmentChangeArr['tracks'] = $tracks;
        $departmentChangeArr['years'] = $years;
        $departmentChangeArr['venues'] = $venues;
        $departmentChangeArr['level'] = $level;
        $departmentChangeArr['institute_industry'] = $institute_industry;
        $departmentChangeArr['faculty'] = $faculty;
        $departmentChangeArr['training_types'] = $training_types;
        $departmentChangeArr['office_location'] = $office_location;
        
//        return json_encode($locations);
        return json_encode($departmentChangeArr);
    }
    
    public function categoryFilter($id)
    {
        /* For Categories */
        $categories = DB::table("categories")
                    ->where("track_id",$id)
                    ->select("name","id")
                    ->pluck('name','id');
        
        return json_encode($categories);
    }
    public function facultyFilter($id)
    {
        /* For faculty */
        $faculty = DB::table("faculty")
                    ->where("institute_industry_id",$id)
                    ->select("name","id")
                    ->pluck('name','id');
        
        return json_encode($faculty);
    }
    
    public function cityFilter($id)
    {
        /* For City */
        $city = DB::table("cities")
                    ->where("state_id",$id)
                    ->select("city","id")
                    ->pluck('city','id');
        
        return json_encode($city);
    }
    
    public function trainingForFilter($id)
    {
        $returnArr =array();
        if($id == "1"){
            $returnArr = array("HQ Office", "All Office");
        }else{
            $user_details = DB::table("user_details")
                    ->where("user_id",$id)
                    ->get();
            $location = DB::table("locations")
                    ->where("id",$user_details[0]->office_id)
                    ->get();
            
            if($location[0]->parent_office_id == "0"){
                $returnArr = array("HQ Office", "All Office");
            }else{
                $returnArr = array("State Office");
            }
    }
                
        return json_encode($returnArr);
    }
    
    	//////////////////////////////////////////////////////////////////////unpublish ministry
	
   public function unpublish($id)
    {
        $status=0;
        $crts = Crttraining::findOrFail($id);
        $crts->status = $status;
        $crts->update();
        return redirect()->route('admin.crt.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish ministry	
	  public function publish($id)
    {
        $status=1;
        $crts = Crttraining::findOrFail($id);
        $crts->status = $status;
        $crts->update();
        return redirect()->route('admin.crt.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
    
}
