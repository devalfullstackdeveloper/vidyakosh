<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\UpdateSectionRequest;
use App\Http\Requests\Admin\StoreSectionRequest;
use App\Models\Designations;
use App\Models\Auth\User;
use App\Models\Venue;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use App\Models\Departments;
use App\Models\Sectionofficer;


class SectionofficerController extends Controller
{
    
    public function index()
    { 
        $sectionofficers = DB::table('sectionofficers')->get();
        return view('backend.sectionofficers.index', compact('sectionofficers'));
    }
        public function getData(Request $request)
    {   
        $has_view = true;
        $has_delete = true;
        $has_edit = true;
        $has_publish = true;
        $has_unpublish = true;
        $tracks = "";
        $sectionofficers=DB::table('sectionofficers')
                     ->join('departments','sectionofficers.department_id','=','departments.id')
                     ->join('users','sectionofficers.officer_id','=','users.id')
                     ->select('sectionofficers.id','sectionofficers.status','users.first_name','departments.department_name')    
                     ->orderBy('sectionofficers.id', 'desc')->get();
                     
        if (auth()->user()->isAdmin()) {
            $has_view = true;
            $has_edit = true;
            $has_delete = true;
            $has_publish = true;
            $has_unpublish = true;
        }
        return DataTables::of($sectionofficers)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.sectionofficer', 'label' => 'sectionofficer', 'value' => $q->id]);
                }          
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.section.edit', ['sectionofficers' => $q->id])])
                        ->render();
                    $view .= $edit;
                }
                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.section.destroy', ['sectionofficers' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                
             if ($has_publish || $has_unpublish) {
                         if($q->status == 1){
                     $publish = view('backend.datatable.action-publish')
                         ->with(['route' => route('admin.section.unpublish', ['sectionofficers' => $q->id])])
                         ->render();
                     $view .= $publish;
                         }else{
                        $unpublish = view('backend.datatable.action-unpublish')
                         ->with(['route' => route('admin.section.publish', ['sectionofficers' => $q->id])])
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
     
    public function create()
    {
       $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
        $users = User::pluck('first_name', 'id as officer_id')->prepend('Please select', '');
       return view('backend.sectionofficers.create',compact('department','users'));
    }

    public function store(StoreSectionRequest $request)
    {
    $sectionofficers = Sectionofficer::create($request->all());
    $sectionofficers->save();
    return redirect()->route('admin.section.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    public function edit($id)
    {
        $department = Departments::where('status', '=', 1)->pluck('department_name', 'id')->prepend('Please select', '');
        $users = User::pluck('first_name', 'id as officer_id')->prepend('Please select', '');
        $sectionofficers = DB::table('sectionofficers')
        ->join('departments','sectionofficers.department_id','=','departments.id')
        ->join('users','sectionofficers.officer_id','=','users.id')
        ->select('sectionofficers.id','sectionofficers.officer_id as deptname','sectionofficers.officer_id as firstname')
        ->where('sectionofficers.id',$id)
        ->first();
        return view('backend.sectionofficers.edit', compact('sectionofficers','department','users'));
    }

   
    public function update(UpdateSectionRequest $request, $id)
    {
         $department_id = $request->department_id;
         $officer_id = $request->officer_id;
       
        DB::table('sectionofficers')
        ->where('id', $id)  
        ->update(array('department_id' => $department_id,'officer_id'=>$officer_id));
        return redirect()->route('admin.section.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    
    public function destroy($id)
    {
       DB::table('sectionofficers')->where('id', $id)->delete(); 
       return redirect()->route('admin.section.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }



    public function unpublish($id)
    {
        $status=0;
        DB::table('sectionofficers')
        ->where('id', $id)  
        ->update(array('status' => $status));
        return redirect()->route('admin.section.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


///////////////////////////////////////////////////////////////////////publish Designations 
      public function publish($id)
    {
        $status=1;
       DB::table('sectionofficers')
        ->where('id', $id)  
        ->update(array('status' => $status));
        return redirect()->route('admin.section.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }
    
}
