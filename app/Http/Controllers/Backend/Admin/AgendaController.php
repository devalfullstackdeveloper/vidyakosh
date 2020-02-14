<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreAgendaRequest;
use App\Http\Requests\Admin\UpdateAgendaRequest;
use App\Models\Designations;
use App\Models\Ministry;
use App\Models\Agenda;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use App\Models\Departments;

class AgendaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $crt = $request->crt;
        $years = DB::table('years')->get();
        /* For Office Location */
        $officeLocation = 1;
        if (isset(auth()->user()->id)) {
            $user = DB::table('user_details')->where('user_id', auth()->user()->id)->select('office_id')->get();
            if (count($user) > 0) {
                $location = DB::table('locations')->where('id', $user[0]->office_id)->select('parent_office_id')->get();
                $officeLocation = $location[0]->parent_office_id;
            }
        }

        return view('backend.agenda.index', compact('crt', 'officeLocation'));
    }
    
            /**
     * Display a listing of Courses via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request) {
        $crtId = $request->crt;
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $has_publish = false;
        $has_unpublish = false;
        $agenda = "";
        $agenda = DB::table('agenda')
                ->where('crt_id', $crtId)
                     ->select('agenda_date')
                     ->groupBy('agenda_date')
                ->get();
        
        $agendaArr = array();
            $cnt = 0;
        foreach ($agenda as $key => $value) {
            $trArr = array();
            $trArr['crt_id'] = $crtId;
            $trArr['agenda_date'] = $value->agenda_date;
            $agendaArr[$cnt] = (object) $trArr;
            $cnt++;
        }
        $agenda = collect($agendaArr);
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

        return DataTables::of($agenda)
            ->addIndexColumn()
        ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $has_publish, $has_unpublish, $request) {
                $view = "";
                $edit = "";
                $delete = "";

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
        ->with(['route' => route('admin.agenda.edit', ['date' => $q->agenda_date, 'crt' => $q->crt_id])])
                        ->render();
                    $view .= $edit;
                }

                    $document = '<a href="'.url('/user/documents?date='.$q->agenda_date.'&crt='.$q->crt_id).'" class="btn btn-xs btn-warning mb-1">Related Documents</a>';
                    $view .= $document;
                
                return $view;

            })
            ->rawColumns(['actions', 'image'])
            ->make();
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $crts = DB::table('crttrainings')->where('id', $request->crt)->select('start_date', 'end_date')->first();
       return view('backend.agenda.create', compact('crts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAgendaRequest $request) {
        $cnt = count($request->input('session_duration_from'));
        $crtId = $request->input('crt_id');
        $agenda_date = $request->input('agenda_date');
        $session_duration_from = $request->input('session_duration_from');
        $session_duration_to = $request->input('session_duration_to');
        $type = $request->input('type');
        $title = $request->input('title');
        $speaker = $request->input('speaker');
        $resourse_person = $request->input('resource_person');


        for ($i = 0; $i < $cnt; $i++) {

        $agenda = new Agenda;
            $agenda->crt_id = $crtId;
            $agenda->agenda_date = $agenda_date;
            $agenda->session_duration_from = $session_duration_from[$i];
            $agenda->session_duration_to = $session_duration_to[$i];
            $agenda->type = $type[$i];
            $agenda->title = $title[$i];
            $agenda->speaker = $speaker[$i];
            $agenda->resourse_person = $resourse_person[$i];
        $agenda->save();
    }

        return redirect()->route('admin.agenda.index', ["crt" => $crtId])->withFlashSuccess(trans('alerts.backend.general.created'));
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
    public function edit(Request $request, $id) {
        $crtId = $request->crt;
        $agendaDate = $id;
        $agenda = DB::table('agenda')
                ->where('agenda_date', $id)
                ->where('crt_id', $crtId)
                        ->get();
        $crts = DB::table('crttrainings')->where('id', $request->crt)->select('start_date', 'end_date')->first();
            
        return view('backend.agenda.edit', compact('agenda', 'crtId', 'crts', 'agendaDate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAgendaRequest $request, $id) {
        $cnt = count($request->input('session_duration_from'));
        $agendaId = $request->input('agendaId');
        $crtId = $request->input('crt_id');
        $agenda_date = $request->input('agenda_date');
        $session_duration_from = $request->input('session_duration_from');
        $session_duration_to = $request->input('session_duration_to');
        $type = $request->input('type');
        $title = $request->input('title');
        $speaker = $request->input('speaker');
        $resourse_person = $request->input('resource_person');
        
        $agendaArr = array();
        for ($i = 0; $i < $cnt; $i++) {
            if (!in_array($agendaId[$i], $agendaArr)) {
        DB::table('agenda')
                        ->where('id', $agendaId[$i])
        ->update(array('agenda_date' => $agenda_date, 
                            'session_duration_from' => $session_duration_from[$i],
                            'session_duration_to' => $session_duration_to[$i],
                            'type' => $type[$i],
                            'title' => $title[$i],
                            'speaker' => $speaker[$i],
                            'resourse_person' => $resourse_person[$i]
                    ));
                $agendaArr[] = $agendaId[$i];
            } else {
                $agenda = new Agenda;
                $agenda->crt_id = $crtId;
                $agenda->agenda_date = $agenda_date;
                $agenda->session_duration_from = $session_duration_from[$i];
                $agenda->session_duration_to = $session_duration_to[$i];
                $agenda->type = $type[$i];
                $agenda->title = $title[$i];
                $agenda->speaker = $speaker[$i];
                $agenda->resourse_person = $resourse_person[$i];
                $agenda->save();
    }
    }
        return redirect()->route('admin.agenda.index', ["crt" => $crtId])->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    public function speakerFilter($id) {
     $ids = explode(",", $id);
     $intExt = $ids[0];
     $crtId = $ids[1];
     
        if ($intExt == 0) {
         $resource_person = DB::table("resource_person")
                    ->join('users', 'resource_person.emp_code', 'users.emp_code')
                    ->where("resource_person.crt_training_id", $crtId)
                    ->where("resource_person.internalexternal", 0)
                    ->select("users.first_name", "users.id")
                    ->pluck('first_name', 'id');
                return json_encode($resource_person); 
        } else {
        $resource_person = DB::table("resource_person")
                    ->join('faculty', 'resource_person.faculty_id', 'faculty.id')
                    ->where("resource_person.crt_training_id", $crtId)
                    ->where("resource_person.internalexternal", 1)
                    ->select("faculty.name", "faculty.id")
                    ->pluck('name', 'id');
                return json_encode($resource_person); 
     }
    }
    
    }
