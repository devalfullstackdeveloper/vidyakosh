<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreYearRequest;
use App\Http\Requests\Admin\UpdateYearRequest;
use App\Models\Designations;
use App\Models\Ministry;
use App\Models\Year;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use App\Models\Departments;


class YearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $years = DB::table('years')->get();

        return view('backend.years.index', compact('years'));
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
        $years = "";
        //$departments =Departments::orderBy('id', 'desc')->get();
        $years=DB::table('years')
                     ->join('departments','years.department_id','=','departments.id')
                     ->select('years.id','years.name','years.year','years.status','departments.department_name')    
                     ->orderBy('years.id', 'desc')->get();
                     // dd($years);
        if (auth()->user()->isAdmin()) {
            $has_view = true;
            $has_edit = true;
            $has_delete = true;
            $has_publish = true;
            $has_unpublish = true;
        }


        return DataTables::of($years)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.year', 'label' => 'year', 'value' => $q->id]);
                }          

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.year.edit', ['years' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.year.destroy', ['years' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                
               // if ($has_publish || $has_unpublish) {
               //          if($q->status == 1){
               //      $publish = view('backend.datatable.action-publish')
               //          ->with(['route' => route('admin.year.unpublish', ['years' => $q->id])])
               //          ->render();
               //      $view .= $publish;
               //          }else{
               //         $unpublish = view('backend.datatable.action-unpublish')
               //          ->with(['route' => route('admin.year.publish', ['years' => $q->id])])
               //          ->render();
               //      $view .= $unpublish;        
               //          }
               //  }

                return $view;

            })
          //  ->editColumn('status', function ($q) {
                
              //  return ($q->status == 1) ? "Enabled" : "Disabled";
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
       $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
       return view('backend.years.create',compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreYearRequest $request)
    {
    $years = $request->input('year');
    if($request->input('year2') != "" && $request->input('year2') != "0000"){
        $years = $request->input('year')." - ".$request->input('year2');
    }
    $designations = new Year;
    $designations->department_id = $request->input('department_id');
    $designations->name = $request->input('name');
    $designations->year = $years;
    $designations->status = $request->input('status');

//    $designations = Year::create($request->all());
    $designations->save();
    return redirect()->route('admin.year.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function show(Year $designations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {           
//        $crttrainings=DB::table('crttrainings')
//                     ->join('departments','crttrainings.department_id','=','departments.id')
//                     ->join('tracks','crttrainings.track_id','=','tracks.id')
//                     ->join('categories','crttrainings.category_id','=','categories.id')
//                     ->join('years','crttrainings.year_id','=','years.id')
//                     ->join('states','crttrainings.state_id','=','states.id')
//                     ->join('cities','crttrainings.city_id','=','cities.id')
//                    ->join('venues','crttrainings.venue_id','=','venues.id')
//                    ->join('designations','crttrainings.designation_id','=','designations.id')
//                    ->join('institute_industry','crttrainings.corinst_id','=','institute_industry.id')
//                    ->where('crttrainings.id',$id)
//                    ->select('crttrainings.id','departments.department_name', 'tracks.name as trackname','categories.name as categoryname','years.name as yearname','states.state as statename','cities.city as cityname','venues.address as venu','designations.designation as designationname','crttrainings.title as title','crttrainings.description as description','crttrainings.corempcode as coordinatecode','institute_industry.name as coordinateid','crttrainings.resourceempcode as resourceempcode','institute_industry.name as resourceinstituteid','crttrainings.timing as timing','crttrainings.start_date as startdate','crttrainings.end_date as enddate','crttrainings.lastnominne as lastnominne','crttrainings.department_id as deptid','crttrainings.track_id as trackid','crttrainings.category_id as categoryid','crttrainings.year_id as yearid','crttrainings.state_id as stateid','crttrainings.city_id as cityid','crttrainings.venue_id as venuid','crttrainings.designation_id as designationid','crttrainings.corinst_id as corinstid')    
//                       ->first();
        
        $years = DB::table('years')
                ->join('departments','years.department_id','=','departments.id')
                ->where('years.id',$id)
                ->select('years.id','years.year','departments.department_name','years.name as yearname','years.department_id as deptid')
                ->first();
        $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
        return view('backend.years.edit', compact('years', 'department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateYearRequest $request, $id)
    {
        $years = $request->input('year');
        if($request->input('year2') != "" && $request->input('year2') != "0000"){
            $years = $request->input('year')." - ".$request->input('year2');
        }
        $department_id = $request->department_id;
        $name = $request->name;
        $year = $years;
        $status = $request->status;
        DB::table('years')
        ->where('id', $id)  
        ->update(array('department_id' => $department_id, 
                        'name' => $name,
                        'year' => $year,
                        'status' => $status
                    ));
        return redirect()->route('admin.year.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       DB::table('years')->where('id', $id)->delete(); 
       return redirect()->route('admin.year.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
    



//////////////////////////////////////////////////////////////////////unpublish Designations
    
   public function unpublish($id)
    {
        $status=0;
        $designations = Year::findOrFail($id);
        $designations->status = $status;
        $designations->update();
        return redirect()->route('admin.year.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish Designations 
      public function publish($id)
    {
        $status=1;
        $designations = Year::findOrFail($id);
        $designations->status = $status;
        $designations->update();
        return redirect()->route('admin.year.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
    










    
 public function departmentFilter($id)
    {
        $departments = DB::table("departments")
                    ->where("ministry_id",$id)
                    ->select("department_name","id")
                    ->pluck('department_name','id');
                return json_encode($departments);
    }
    
     public function officeFilter($id)
    {
        $locations = DB::table("locations")
                    ->where("department_id",$id)
                    ->select("office_name","id")
                    ->pluck('office_name','id');
                return json_encode($locations);
    }

    
    
}
