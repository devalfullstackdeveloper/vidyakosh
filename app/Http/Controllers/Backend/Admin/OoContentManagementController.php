<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\storeDocsRequest;
use App\Http\Requests\Admin\UpdateDocsRequest;
use App\Models\Designations;
use App\Models\Ministry;
use App\Models\OfficeorderCm;
use App\Models\InstituteIndustry;
use DB;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use App\Models\Departments;

class OoContentManagementController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        /* For Office Location */
        $officeLocation = 1;
        if (isset(auth()->user()->id)) {
            $user = DB::table('user_details')->where('user_id', auth()->user()->id)->select('office_id')->get();
            if (count($user) > 0) {
                $location = DB::table('locations')->where('id', $user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
    }
        }
        return view('backend.officeorder_cm.index', compact('officeLocation'));
    }

    /**
     * Display a listing of Courses via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request) {

        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $has_publish = false;
        $has_unpublish = false;
        //$departments =Departments::orderBy('id', 'desc')->get();
        $OfficeorderCm = DB::table('officeorder_content_management')
                ->orderBy('id','desc')
                ->get();

        /* For Office Location */
        $officeLocation = 1;
        if (isset(auth()->user()->id)) {
            $user = DB::table('user_details')->where('user_id', auth()->user()->id)->select('office_id')->get();
            if (count($user) > 0) {
                $location = DB::table('locations')->where('id', $user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }

        if (auth()->user()->isAdmin() || (auth()->user()->is_admin == 1 && $officeLocation == 0)) {
            $has_view = true;
            $has_edit = true;
            $has_delete = true;
            $has_publish = true;
            $has_unpublish = true;
        }

        return DataTables::of($OfficeorderCm)
        ->addIndexColumn()
        ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $has_publish, $has_unpublish, $request) {
        $view = "";
        $edit = "";
        $delete = "";
        if ($request->show_deleted == 1) {
        return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.officeorder_content_management', 'label' => 'Office Order Content Management', 'value' => $q->id]);
        }

        if ($has_edit) {
        $edit = view('backend.datatable.action-edit')
        ->with(['route' => route('admin.officeorder_content_management.edit', ['documents' => $q->id])])
        ->render();
        $view .= $edit;
        }

        if ($has_delete) {
        $delete = view('backend.datatable.action-delete')
        ->with(['route' => route('admin.officeorder_content_management.destroy', ['documents' => $q->id])])
        ->render();
        $view .= $delete;
        }

//        if ($has_publish || $has_unpublish) {
//        if($q->status == 1){
//        $publish = view('backend.datatable.action-unpublish')
//        ->with(['route' => route('admin.subject.unpublish', ['subject' => $q->id])])
//        ->render();
//        $view .= $publish;
//        } else{
//        $unpublish = view('backend.datatable.action-publish')
//        ->with(['route' => route('admin.subject.publish', ['subject' => $q->id])])
//        ->render();
//        $view .= $unpublish;
//        }
//        }

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
    public function create() {
        return view('backend.officeorder_cm.create', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
        $OfficeorderCm = new OfficeorderCm();
        $OfficeorderCm->title = $request->title;
        $OfficeorderCm->description = $request->description;
        $OfficeorderCm->status = $request->status;
        $OfficeorderCm->save();

        return redirect()->route('admin.officeorder_content_management.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function show(Year $designations) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $officeorderCm = DB::table('officeorder_content_management')->where('id', $id)->first();
        return view('backend.officeorder_cm.edit', compact('officeorderCm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $title = $request->title;
        $description = $request->description;
        $status = $request->status;
        
        DB::table('officeorder_content_management')
                ->where('id', $id)
                ->update(array(
                        'title' => $title,
                        'description' => $description,
                        'status' => $status
                ));
        return redirect()->route('admin.officeorder_content_management.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $docs = DB::table('documents')->where('id', $id)->first();
        $crt = $docs->crt_id;
        $date = $docs->agenda_date;
        DB::table('documents')->where('id', $id)->delete();
        return redirect()->route('admin.officeorder_cm.index',["date"=>$date,"crt"=>$crt])->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

//////////////////////////////////////////////////////////////////////unpublish Designations

//    public function unpublish($id) {
//        $status = 0;
//        DB::table('subject')
//        ->where('id', $id)
//        ->update(['status' => $status]);
//        return redirect()->route('admin.officeorder_cm.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
//    }
//
/////////////////////////////////////////////////////////////////////////publish Designations 
//    public function publish($id) {
//        $status = 1;
//        DB::table('subject')
//        ->where('id', $id)
//        ->update(['status' => $status]);
//        return redirect()->route('admin.officeorder_cm.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
//    }

}
