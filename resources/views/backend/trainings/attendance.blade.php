@extends('backend.layouts.app')

@section('title', __('labels.backend.attandences.title').' | '.app_name())
@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
	 <script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
    <style>
        .select2-container--default .select2-selection--single {
            height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
        }

        .bootstrap-tagsinput {
            width: 100% !important;
            display: inline-block;
        }

        .bootstrap-tagsinput .tag {
            line-height: 1;
            margin-right: 2px;
            background-color: #2f353a;
            color: white;
            padding: 3px;
            border-radius: 3px; 
        }

    </style>

@endpush

@section('content')
    {{ html()->form('get', route('admin.trainings.attendancesave'))->acceptsFiles()->class('form-horizontal')->open() }}
    <div class="card">
         <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.attandences.create')</h3>
			 @if (Session::has('message'))
                <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
            <!--<div class="float-right">
                <a href="{{ route('admin.crt.index') }}"
                   class="btn btn-success">@lang('labels.backend.crts.view')</a>
            </div>-->
        </div> 
        <div class="card-body">
            <div class="row">
                <div class="col-12">
				
			  <div class="form-group row">   
               <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('z',trans('labels.backend.attandences.fields.training_id'), ['class' => 'control-label']) !!}
                    <select class="form-control select2" name= "training_id">
                        @foreach($attendance as $attendancedata)
                        <option value="{{$attendancedata->id}}">{{$attendancedata->title}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="department_id" id="department_id" value="{{$departmentid}}">
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="myTable"
                               class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th>@lang('labels.general.sr_no')</th>
                                <th>@lang('labels.backend.attandences.fields.name')</th>
                                <th>@lang('labels.backend.attandences.fields.designation')</th>
                                <th>@lang('labels.backend.attandences.fields.present')</th>
                              
                             
                            </tr>
                            </thead>
                            
                            <tbody>
								
							</tbody>
                                    
                        </table>
                    </div>
                </div>



				</div>

                    <div class="form-group row justify-content-center">
                        <div class="col-4">
                        {{ form_submit(__('buttons.general.crud.submit')) }}
                        </div>
                    </div><!--col-->
                </div>
            </div>
        </div>
    </div>
    {{ html()->form()->close() }}
 <script type="text/javascript">
    $(document).ready(function() {
        $('select[name="training_id"]').on('change', function() {
            var trainingID = $(this).val();

            if(trainingID) {
				var table = $("#myTable");
                $.ajax({
                    url: 'userattandence/'+trainingID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        console.log(data);
						$("#myTable > tbody").html("");
						var num = 1;

						$.each(data, function(a,b) {
							var pselected = "";
							var aselected = "";
							if(b.present == 1) {
								pselected = "selected=selected";
							}
							if(b.present == 0) {
								aselected = "selected=selected";
							}
							var sel = '<select name="attendance[]"><option value="1" '+pselected+'>Present</option><option value="0" '+aselected+'>Absent</option></select>';
							$(table).append($('<tr>')
								.append($('<td>').append(num))
								.append($("<td><input type='hidden' id='name"+num+"' name='name[]' value="+b.first_name+"><input type='hidden' id='first_name"+num+"' name='user_id[]' value="+b.user_id+"></td>").append(b.first_name))
								.append($("<td><input type='hidden' id='designation"+num+"' name='designation[]' value="+b.designation+"><input type='hidden' id='designation_id"+num+"' name='designation_id[]' value="+b.designation_id+"></td>").append(b.designation))
								.append($('<td>').append(sel))
                            )
							num++;
						}); 
                         
						
                      //var trHTML = '';          
                        //$('select[name="department_id"]').empty();
                        //$.each(data, function(key, value) {
                          //  $('select[name="department_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        //});
               
                    //$(data).each(function (i,value) {
                      //  trHTML += response.killdata.map(function(killdata) {
                        //  return '<tr class="gradeA"><td>' + killdata.id + '</td><td>' + killdata.AcctNo + '</td></tr>';
                       // });
                    //}
               // });
            }
			//else{
              //  $('select[name="department_id"]').empty();
            //}
        });
			}
		 });
		 $('select[name="training_id"]').change();
		});
	 </script>
@endsection
