<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\storeSubjectRequest;
use App\Http\Requests\Admin\UpdateSubjectRequest;
use App\Models\Designations;
use App\Models\Ministry;
use App\Models\Subject;
use App\Models\InstituteIndustry;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use App\Models\Departments;

class SubjectController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $subject = DB::table('subject')->get();
        
        /*For Office Location*/
        $officeLocation = 1;
        if(isset(auth()->user()->id)){
            $user = DB::table('user_details')->where('user_id',auth()->user()->id)->select('office_id')->get();
            if(count($user) > 0){
                $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
    }
        }
        return view('backend.subject.index', compact('subject','officeLocation'));
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
        //$departments =Departments::orderBy('id', 'desc')->get();
        $subject = DB::table('subject')
                        ->orderBy('id', 'desc')->get();

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

        return DataTables::of($subject)
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
        ->with(['route' => route('admin.subject.edit', ['subject' => $q->id])])
        ->render();
        $view .= $edit;
        }

        if ($has_delete) {
        $delete = view('backend.datatable.action-delete')
        ->with(['route' => route('admin.subject.destroy', ['subject' => $q->id])])
        ->render();
        $view .= $delete;
        }

        if ($has_publish || $has_unpublish) {
        if($q->status == 1){
        $publish = view('backend.datatable.action-unpublish')
        ->with(['route' => route('admin.subject.unpublish', ['subject' => $q->id])])
        ->render();
        $view .= $publish;
        } else{
        $unpublish = view('backend.datatable.action-publish')
        ->with(['route' => route('admin.subject.publish', ['subject' => $q->id])])
        ->render();
        $view .= $unpublish;
        }
        }

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
        return view('backend.subject.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeSubjectRequest $request) {
        $subject = new Subject();
        $subject->name = $request->name;
        $subject->status = $request->status;
        $subject->save();

        return redirect()->route('admin.subject.index')->withFlashSuccess(trans('alerts.backend.general.created'));
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
        $subject = DB::table('subject')->where('id', $id)->first();
        return view('backend.subject.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubjectRequest $request, $id) {
        
        $name = $request->name;
        $status = $request->status;

        DB::table('subject')
                ->where('id', $id)
                ->update(array(
                    'name' => $name,
                    'status' => $status
                ));

        return redirect()->route('admin.subject.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        DB::table('subject')->where('id', $id)->delete();
        return redirect()->route('admin.subject.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
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
