<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\storeSubjectRequest;
use App\Http\Requests\Admin\UpdateSubjectRequest;
use App\Models\Designations;
use App\Models\Ministry;
use App\Models\Documents;
use App\Models\InstituteIndustry;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use App\Models\Departments;

class DocumentController extends Controller {

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
        return view('backend.documents.index', compact('officeLocation'));
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
        $subject = "";
        $param = explode(",", $request->param);
        $date = $param[0];
        $crt = $param[1];
        //$departments =Departments::orderBy('id', 'desc')->get();
        $documents = DB::table('documents')
                ->join('documents_type', 'documents.type', 'documents_type.id')
                ->where('documents.crt_id', $crt)
                ->where('documents.agenda_date', $date)
                ->select('documents.id', 'documents.agenda_date', 'documents_type.type', 'documents.description', 'documents.file', 'documents.status')
                ->orderBy('documents.id','desc')
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

        return DataTables::of($documents)
        ->addIndexColumn()
        ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $has_publish, $has_unpublish, $request) {
        $view = "";
        $edit = "";
        $delete = "";
        if ($request->show_deleted == 1) {
        return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.subject', 'label' => 'subject', 'value' => $q->id]);
        }

        if ($has_edit) {
        $edit = view('backend.datatable.action-edit')
        ->with(['route' => route('admin.documents.edit', ['documents' => $q->id])])
        ->render();
        $view .= $edit;
        }

        if ($has_delete) {
        $delete = view('backend.datatable.action-delete')
        ->with(['route' => route('admin.documents.destroy', ['documents' => $q->id])])
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
        $type = DB::table('documents_type')->where('status', '1')->select('type', 'id')->pluck('type', 'id')->prepend('Please select', '');
        return view('backend.documents.create', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $date = $request->agenda_date;
        $crt = $request->crt_id;
        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $filename = time() . '-' . $file->getClientOriginalName();
            $size = $file->getSize() / 1024;
            $path = public_path() . '/storage/uploads/';
            $file->move($path, $filename);
        }

        $documents = new Documents();
        $documents->crt_id = $request->crt_id;
        $documents->agenda_date = $request->agenda_date;
        $documents->type = $request->type;
        $documents->description = $request->description;
        $documents->file = $filename;
        $documents->save();

        return redirect()->route('admin.documents.index',["date"=>$date,"crt"=>$crt])->withFlashSuccess(trans('alerts.backend.general.created'));
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
        $documents = DB::table('documents')->where('id', $id)->first();
        $type = DB::table('documents_type')->select('type','id')->pluck('type','id')->prepend('Please select','');
        return view('backend.documents.edit', compact('documents', 'type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $date = $request->agenda_date;
        $crt = $request->crt_id;
        $filename = "";
        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $filename = time() . '-' . $file->getClientOriginalName();
            $size = $file->getSize() / 1024;
            $path = public_path() . '/storage/uploads/';
            $file->move($path, $filename);
        }
        $type = $request->type;
        $description = $request->description;

        if ($filename != "") {
            DB::table('documents')
                ->where('id', $id)
                ->update(array(
                        'crt_id' => $crt,
                        'agenda_date' => $date,
                        'type' => $type,
                        'description' => $description,
                        'file' => $filename
                ));
        }else{
            DB::table('documents')
                    ->where('id', $id)
                    ->update(array(
                        'crt_id' => $crt,
                        'agenda_date' => $date,
                        'type' => $type,
                        'description' => $description
                    ));
        }

        return redirect()->route('admin.documents.index', ["date" => $date, "crt" => $crt])->withFlashSuccess(trans('alerts.backend.general.updated'));
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
        return redirect()->route('admin.documents.index',["date"=>$date,"crt"=>$crt])->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

//////////////////////////////////////////////////////////////////////unpublish Designations

    public function unpublish($id) {
        $status = 0;
        DB::table('subject')
        ->where('id', $id)
        ->update(['status' => $status]);
        return redirect()->route('admin.subject.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

///////////////////////////////////////////////////////////////////////publish Designations 
    public function publish($id) {
        $status = 1;
        DB::table('subject')
        ->where('id', $id)
        ->update(['status' => $status]);
        return redirect()->route('admin.subject.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    public function departmentFilter($id) {
        $departments = DB::table("departments")
                ->where("ministry_id", $id)
                ->select("department_name", "id")
                ->pluck('department_name', 'id');
        return json_encode($departments);
    }

    public function officeFilter($id) {
        $locations = DB::table("institute_industry")
                ->where("department_id", $id)
                ->select("name", "id")
                ->pluck('name', 'id');
        return json_encode($locations);
    }

}
