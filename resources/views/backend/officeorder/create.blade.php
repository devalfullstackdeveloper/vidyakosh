@extends('backend.layouts.app')

@section('title', __('labels.backend.officeorder.title').' | '.app_name())
@push('after-styles')
<link rel="stylesheet" href="{{asset('assets/plugins/YearPicker/style.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/YearPicker/yearpicker.css')}}" />

<link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
<script src="{{asset('plugins/bootstrap-tagsinput/jquery.min.js')}}"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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

    .search_btn{
        margin: 0px;
        padding: 28px 18px;
    }

</style>

@endpush

@section('content')
{{ html()->form('POST', route('admin.officeorder.store'))->acceptsFiles()->class('form-horizontal officeorder')->open() }}
<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.officeorder.create')</h3>
        <div class="float-right">
            <a href="{{ route('admin.officeorder.create') }}"
               class="btn btn-success">@lang('labels.backend.officeorder.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">

                <div class="form-group row">  
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.officeorder.fields.nomination_type'), ['class' => 'control-label']) !!}
                        <select class="form-control select2"  name="nomination_type">
                            <option value="0">Initial Nomination</option>
                            <option value="1">Partial Nomination</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.officeorder.fields.department_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('department_id', $department, old('department'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group action d-none">
                        {!! Form::label('z',trans('labels.backend.officeorder.fields.action'), ['class' => 'control-label']) !!}
                        <select class="form-control select2 selectaction"  name="action">
                            <option value="">Select Action</option>
                            <option value="0">Add Nomination</option>
                            <option value="1">Remove Nomination</option>
                        </select>
                    </div>




    
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.officeorder.fields.training_id'), ['class' => 'control-label']) !!}
                        <select class="form-control select2"  name="training_id">
                            <option value="0">Please select</option>
                        </select>
                    </div>

                    <div class="col-12 col-lg-6 form-group signing_authority d-none">
                        {!! Form::label('z',trans('labels.backend.officeorder.fields.signing_authority'), ['class' => 'control-label']) !!}
                        <select class="form-control select2"  name="signing_authority">
                            <option value="0">Please select</option>
                        </select>
                    </div>

                    <div class="col-12 col-lg-6 form-group file_no d-none">
                        {!! Form::label('z',trans('labels.backend.officeorder.fields.file_no'), ['class' => 'control-label']) !!}
                        {{ html()->text('file_no')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.officeorder.fields.file_no'))
                        ->attribute('maxlength', 500)
                        ->autofocus() }}
                    </div>

                    <!-- <div class="col-12 col-lg-6 form-group  d-none removing_btn">
                        <button class="btn btn-success btn-warning" type="button" id="show_removing">Click here to show removing list</button>
                    </div> -->

                    <div class="col-12 col-lg-6 form-group d-none emp_code">
                        {!! Form::label('z',trans('labels.backend.officeorder.fields.emp_code'), ['class' => 'control-label']) !!}
                        {{ html()->text('emp_code')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.officeorder.fields.emp_code'))
                        ->attribute('maxlength', 500)
                        ->autofocus() }}
                    </div>

                    <div class="col-12 col-lg-6 form-group d-none search_btn">
                        <button class="btn btn-success" type="button" id="search">Search</button>
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-12 col-lg-12 empTable">
                         <table id="myTable"
                               class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th>@lang('labels.general.sr_no')</th>
                                <th>@lang('labels.backend.officeorder.fields.name')</th>
                                <th>@lang('labels.backend.officeorder.fields.designation')</th>
                                <th>@lang('labels.backend.officeorder.fields.empcode')</th>
                                <th>@lang('labels.backend.officeorder.fields.email')</th>
                                <th>@lang('labels.backend.officeorder.fields.state')</th>
                                <th>@lang('labels.backend.officeorder.fields.action')<input name="officeorderid" type="hidden" value="secret"></th>
                             
                            </tr>
                            </thead>
                            
                            <tbody>
                                
                            </tbody>
                                    
                        </table>
            </div>
        </div>


          
    </div>

</div>
 <div class="form-group row justify-content-center buttons">
                    <div class="col-4">
                        <button class="btn btn-success pull-right" type="submit">Generate Office Order</button>
                    </div>
                </div>
{{ html()->form()->close() }}
<!--<script>

    $(document).ready(function () {
        $("#add_nomination").click(function(){
            console.log("12345");
        })
        var route = '{{route('admin.officeorder.get_data')}}';

        @if(request('show_deleted') == 1)
            route = '{{route('admin.officeorder.get_data',['show_deleted' => 1])}}';
        @endif

        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            iDisplayLength: 10,
            retrieve: true,
            dom: 'lfBrtip<"actions">',
            buttons: [],
            ajax: route,
            columns: [
                {data: "DT_RowIndex", name: 'DT_RowIndex'},
                {data: "name", name: 'name'}, 
                {data: "emp_code", name: 'emp_code'}, 
                {data: "email", name: 'email'}, 
                {data: "state", name: 'state'}
            ],
            @if(request('show_deleted') != 1)
                columnDefs: [
                    {"width": "5%", "targets": 0},
                    {"className": "text-center", "targets": [0]}
                ],
            @endif

            createdRow: function (row, data, dataIndex) {
                $(row).attr('data-entry-id', data.id);
            },
            language:{
                url : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{$locale_full_name}}.json",
                buttons :{
                    colvis : '{{trans("datatable.colvis")}}',
                    pdf : '{{trans("datatable.pdf")}}',
                    csv : '{{trans("datatable.csv")}}',
                }
            }
        });
        @if(auth()->user()->isAdmin())
            $('.actions').html('<a href="' + '{{ route('admin.teachers.mass_destroy') }}' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
        @endif
    });

</script>-->
<script type="text/javascript">
    $(document).ready(function() {
        var nomination_type = $('select[name="nomination_type"]').val();
        if(nomination_type == 0){
            $(".signing_authority").removeClass('d-none');
            $(".file_no").removeClass('d-none');
            $(".action").addClass('d-none');
            $(".emp_code").addClass('d-none');
            $(".removing_btn").addClass('d-none');
            $(".search_btn").addClass('d-none');
            //$(".empTable").removeClass("d-none");
            $(".buttons").removeClass("d-none");
            
        }else{
            //$(".empTable").addClass("d-none");

            $(".buttons").addClass("d-none");
            $(".signing_authority").addClass('d-none');
            $(".file_no").addClass('d-none');
            $(".action").removeClass('d-none');
            
        }
        
        $('select[name="nomination_type"]').on('change', function() {
            var nomination_type = $('select[name="nomination_type"]').val();
            if(nomination_type == 0){
                $(".signing_authority").removeClass('d-none');
                $(".file_no").removeClass('d-none');
                $(".action").addClass('d-none');
                $(".emp_code").addClass('d-none');
                $(".removing_btn").addClass('d-none');
                $(".search_btn").addClass('d-none');
                //$(".empTable").removeClass("d-none");
                $(".buttons").removeClass("d-none");
            }else{
                //$(".empTable").addClass("d-none");
                $(".buttons").addClass("d-none");
                $(".signing_authority").addClass('d-none');
                $(".file_no").addClass('d-none');
                $(".action").removeClass('d-none');
                $("#officeorderid").css('display','block');
            }
        });
        
        $('select[name="action"]').on('change', function() {
            var action = $('select[name="action"]').val();
            if(action == 0){
                $(".emp_code").removeClass('d-none');
                $(".search_btn").removeClass('d-none');
                $(".removing_btn").addClass('d-none');
              //  $(".empTable").addClass('d-none');
            }else if(action == 1){
                $(".emp_code").addClass('d-none');
                $(".search_btn").addClass('d-none');
                $(".removing_btn").removeClass('d-none');
            }else if(action == ""){
                $(".emp_code").addClass('d-none');
                $(".search_btn").addClass('d-none');
                $(".removing_btn").addClass('d-none');
            }
        });
        	
        $('select[name="department_id"]').on('change', function() {
            var departmentID = $(this).val();
            //alert(departmentID);
            if(departmentID) {
                $.ajax({
                    url: 'signing-ajax/'+departmentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        var sign_html = '<option value="">Please select</option>';
                        var training_html = '<option value="">Please select</option>';
						console.log(data);
                        $.each(data, function(key, value) {
                            $.each(value, function(id, val) {
                                if(key == "signs"){
                                    sign_html += '<option value="'+ id +'">'+ val +'</option>';
                                }
                                if(key == "training"){
                                    training_html += '<option value="'+ id +'">'+ val +'</option>';
                                }
                            });
                        });
                        $('select[name="signing_authority"]').html(sign_html);
                        $('select[name="training_id"]').html(training_html);

                    }
                });
            }else{
                $('select[name="office_id"]').empty();
            }
        });
        
        // $("#search").on('click', function() {
        //     var emp_code = $("#emp_code").val();
        //     //alert(departmentID);
        //     if(emp_code) {
        //         $.ajax({
        //             url: 'empcode-ajax/'+emp_code,
        //             type: "GET",
        //             dataType: "json",
        //             success:function(data) {
        //                 var empTable = '<table class="table table-bordered table-striped">';
        //                 empTable += '<thead>';
        //                 empTable += '<tr>';
        //                 empTable += '<th>Name</th>';
        //                 empTable += '<th>Employee Code</th>';
        //                 empTable += '<th>Email</th>';
        //                 empTable += '<th>Action</th>';
        //                 empTable += '</tr>';
        //                 empTable += '</thead>';
        //                 empTable += '<tbody>';
                                
        //                 $.each(data, function(key, value) {
        //                     empTable += '<tr>';
        //                     empTable += '<td>' + value.first_name + '</td>';
        //                     empTable += '<td>' + value.emp_code + '</td>';
        //                     empTable += '<td>' + value.email + '</td>';
        //                     empTable += '<td><button class="btn btn-success add_nomination" type="button">Add</button></td>';
        //                     empTable += '</tr>';
        //                 });
                                
        //                 empTable += '</tbody>';
        //                 empTable += '</table>';
        //                 $(".empTable").html(empTable);
        //                 $(".empTable").removeClass("d-none");
                        
        //                 $(".add_nomination").click(function(){
        //                    $(".officeorder").submit();
        //                 });
        //             }
        //         });
        //     }
        // });
        
        // $("#show_removing").on('click', function() {
        //     var dept_id = $('select[name="department_id"]').val();
        //     var training_id = $('select[name="training_id"]').val();
        //     //alert(departmentID);
        //     if(emp_code) {
        //         $.ajax({
        //             url: 'showRemove-ajax/'+dept_id+","+training_id,
        //             type: "GET",
        //             dataType: "json",
        //             success:function(data) {
        //                var empTable = '<table class="table table-bordered table-striped">';
        //                 empTable += '<thead>';
        //                 empTable += '<tr>';
        //                 empTable += '<th></th>';
        //                 empTable += '<th>Name</th>';
        //                 empTable += '<th>Employee Code</th>';
        //                 empTable += '<th>Email</th>';
        //                 empTable += '</tr>';
        //                 empTable += '</thead>';
        //                 empTable += '<tbody>';
                                
        //                 $.each(data, function(key, value) {
        //                     $.each(value, function(i, val) {
        //                         empTable += '<tr>';
        //                         empTable += '<td><input type="checkbox" class="single" name="id" value="' + key + '" /></td>';
        //                         empTable += '<td>' + val.first_name + '</td>';
        //                         empTable += '<td>' + val.emp_code + '</td>';
        //                         empTable += '<td>' + val.email + '</td>';
        //                         empTable += '</tr>';
        //                     });
        //                 });
                                
        //                 empTable += '</tbody>';
        //                 empTable += '</table>';
        //                 empTable += '<div class="col-12 col-lg-6 form-group search_btn">';
        //                     empTable += '<button class="btn btn-danger" type="button" id="remove_nomination">Remove</button>';
        //                 empTable += '</div>';
        //                 $(".empTable").html(empTable);
        //                 $(".empTable").removeClass("d-none");
                        
        //                 $("#remove_nomination").click(function(){
        //                     var array = []; 
        //                     $("input:checkbox[name=id]:checked").each(function() { 
        //                         array.push($(this).val()); 
        //                     });
        //                     if(array.length > 0){
                                
        //                         $.ajax({
        //                             url: 'removeNomination-ajax/'+array,
        //                             type: "GET",
        //                             dataType: "json",
        //                             success:function(data) {
        //                                 console.log(data)
        //                                 if(data == "success"){
        //                                     var index = '{{route('admin.officeorder.index')}}';
        //                                     console.log(index)
        //                                     window.location.href = index;
        //                                 }
        //                             }
        //                         });            
                                
                                
        //                     }
        //                 });
                        
        //             }
        //         });
                
        //     }
        // });


//------------------  training to search----------------------//
 $('select[name="training_id"]').on('change', function() {

    //alert($('select[name="action"]').val());
    if($('select[name="nomination_type"]').val() == "0"){
            var trainingid = $(this).val();

            //alert(departmentID);
            if(trainingid) {
                var table = $("#myTable");
                $.ajax({
                    url: 'trainingid_ajax/'+trainingid,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        console.log(data);
                        $("#myTable > tbody").html("");
                        var num = 1;
                         $.each(data, function(a,b) {
                            $(table).append($('<tr>')
                                            .append($('<td>').append(num))
                                            .append($("<td><input type='hidden' id='userid"+num+"' name='userid' value="+b.userid+"></td>").append(b.name))
                                            .append($("<td><input type='hidden' id='designationid"+num+"' name='designationid' value="+b.designationid+"></td>").append(b.designation))
                                            .append($("<td><input type='hidden' id='empcode"+num+"' name='empcode' value="+b.empcode+"></td>").append(b.empcode))
                                            .append($("<td></td>").append(b.email))
                                            .append($("<td></td>").append(b.state))
                                            .append($('<td></td>'))

                                            
                                           )
                            num++;
                        });

                        
                    }
                });
           }
       } else if($('select[name="nomination_type"]').val() == "1" && $('select[name="action"]').val() == "1"){
            var trainingid = $(this).val();
           var deptid = $('select[name="department_id"]').val();
           var trainingid = $('select[name="training_id"]').val();
            if(trainingid) {
                var table = $("#myTable");
                $.ajax({
                    url: 'training_office_order_ajax/'+deptid+'/'+trainingid,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        console.log(data);
                       $("#myTable > tbody").html("");
                        var num = 1;
                         $.each(data, function(a,b) {
                            $(table).append($('<tr>')
                                            .append($('<td>').append(num))
                                             .append($("<td></td>").append(b.name))
                                            .append($("<td></td>").append(b.designation))
                                            .append($("<td></td>").append(b.empcode))
                                            .append($("<td></td>").append(b.email))
                                            .append($("<td></td>").append(b.state))
                                            .append($('<td><input type="button" data-element="'+b.id+'"  class="btn btn-danger btnDelete" value="Delete" "></td>'))
                                            

                                            
                                           )
                            num++;
                         });

                        
                    }
                });
           }
       } 
       else if($('select[name="nomination_type"]').val() == "1" && $('select[name="action"]').val() == "0"){
            var trainingid = $(this).val();
           var deptid = $('select[name="training_id"]').val();
                var table = $("#myTable");
                $.ajax({
                    url: 'partialadd_ajax/'+deptid,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        console.log(data);
                       $("#myTable > tbody").html("");
                        var num = 1;
                         $.each(data, function(a,b) {
                            $(table).append($('<tr>')
                                            .append($('<td>').append(num))
                                             .append($("<td><input type='hidden' id='designationid"+num+"' name='designationid' value="+b.designationid+"></td>").append(b.name))
                                            .append($("<td><input type='hidden' id='userid"+num+"' name='id' value="+b.id+"></td>").append(b.id))
                                            .append($("<td><input type='hidden' id='designationid"+num+"' name='designationid' value="+b.designationid+"></td>").append(b.designation))
                                            .append($("<td><input type='hidden' id='empcode"+num+"' name='empcode' value="+b.empcode+"></td>").append(b.empcode))
                                            .append($("<td></td>").append(b.email))
                                            .append($("<td></td>").append(b.state))
                                            .append($('<td><input type="button"  class="btn btn-success btnAdd" value="Add" "></td>'))

                                            
                                           )
                            num++;
                         });

                        
                    }
                });
       }     
    });
//----------------------------partial remove---------------------------------//
        $("#myTable").on('click', '.btnDelete', function () {
            var id = $(this).attr("data-element");
            
            $.ajax({
            url: 'update_ajax/'+id,
            type: "GET",
            dataType: "json",
                success:function(data) {
                    console.log(data);
                    
                }
            });
        });
//----------------------------------partial add----------------------------------//

$("#myTable").on('click', '.btnAdd', function () {
     var deptid = $('select[name="department_id"]').val();
     var trainingid = $('select[name="training_id"]').val();
     var fileno =  $("input[name='emp_code']").val();
     var id = $(".btnAdd").closest("tr").find('td:eq(2)').text();
            $.ajax({
            url: 'partialsave',
            url: 'partialsave/'+deptid+'/'+trainingid+'/'+fileno+'/'+id,
            type: "GET",
            dataType: "json",
                success:function(data) {
                    console.log(data);
                }
            });
        });

    });
</script>
@endsection
