<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreInstituteRequest;
use App\Http\Requests\Admin\UpdateInstituteRequest;
use App\Models\InstituteIndustry;
use App\Models\Departments;
use App\Models\Ministry;
use App\Models\TrainingType;
use App\Models\M_InstitutesIndustries;
use App\Models\D_InstitutesIndustries;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;



class TrainingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('backend.training-type.index'); 
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
        $institute_industries = "";
		$institute_industries =InstituteIndustry::orderBy('id', 'desc')->get();
		
        if (auth()->user()->isAdmin()) {
            $has_view = true;
            $has_edit = true;
            $has_delete = true;
			$has_publish = true;
		    $has_unpublish = true;
        }


        return DataTables::of($institute_industries)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.institutes-industries', 'label' => 'institutes-industries', 'value' => $q->id]);
                }          

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.institutes-industries.edit', ['institutes-industries' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.institutes-industries.destroy', ['institutes-industries' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
				if ($has_publish || $has_unpublish) {
						if($q->status == 1){
                    $publish = view('backend.datatable.action-publish')
                        ->with(['route' => route('admin.institutes-industries.unpublish', ['institutes-industries' => $q->id])])
                        ->render();
                    $view .= $publish;
						}else{
					   $unpublish = view('backend.datatable.action-unpublish')
                        ->with(['route' => route('admin.institutes-industries.publish', ['institutes-industries' => $q->id])])
                        ->render();
                    $view .= $unpublish;		
						}
                }

                return $view;

            })
			->editColumn('type_id', function ($q) {
				
             return ($q->type_id == 1) ? "Institute" : "Industry";
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
       return view('backend.institute-industry.create',compact('ministry','departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInstituteRequest $request)
    {
    $institute_industries = InstituteIndustry::create($request->all());
    $institute_industries->save();
	$insertedId = $institute_industries->id;
		
		$ministry_id = array_filter((array)$request->input('ministry_id'));	
       foreach ($ministry_id as $key) {
        $m_institutes_industries = new M_InstitutesIndustries;
        $m_institutes_industries->ministry_id=$key;
        $m_institutes_industries->institute_industry_id=$insertedId;
        $m_institutes_industries->save();
        }
		$department_id = array_filter((array)$request->input('department_id'));
		 foreach ($department_id as $key) {
        $d_institutesindustries = new D_InstitutesIndustries;
        $d_institutesindustries->department_id=$key;
        $d_institutesindustries->institute_industry_id=$insertedId;
        $d_institutesindustries->save();
        }
	
	return redirect()->route('admin.institutes-industries.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InstituteIndustry  $instituteIndustry
     * @return \Illuminate\Http\Response
     */
    public function show(InstituteIndustry $instituteIndustry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InstituteIndustry  $instituteIndustry
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $instituteindustries = InstituteIndustry::findOrFail($id);
		$departments = Departments::where('status', '=', 1)->pluck('department_name', 'id');
        return view('backend.institute-industry.edit', compact('instituteindustries','departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InstituteIndustry  $instituteIndustry
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstituteRequest $request, $id)
    {
       $instituteindustries = InstituteIndustry::findOrFail($id);
       $instituteindustries->update($request->all());
       $instituteindustries->save();
       return redirect()->route('admin.institutes-industries.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InstituteIndustry  $instituteIndustry
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $InstituteIndustry = InstituteIndustry::findOrFail($id);
        $InstituteIndustry->delete();
        return redirect()->route('admin.institutes-industries.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
	
	
	//////////////////////////////////////////////////////////////////////unpublish InstituteIndustry
	
   public function unpublish($id)
    {
		$status=0;
	    $instituteindustries = InstituteIndustry::findOrFail($id);
        $instituteindustries->status = $status;
        $instituteindustries->update();
        return redirect()->route('admin.institutes-industries.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish InstituteIndustry	
	  public function publish($id)
    {
		$status=1;
	    $instituteindustries = InstituteIndustry::findOrFail($id);
        $instituteindustries->status = $status;
        $instituteindustries->update();
        return redirect()->route('admin.institutes-industries.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
	
}
