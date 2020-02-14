@extends('backend.layouts.app')

@section('title', __('labels.backend.designations.title').' | '.app_name())
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
    {{ html()->form('POST', route('admin.designations.store'))->acceptsFiles()->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.designations.create')</h3>
            <div class="float-right">
                <a href="{{ route('admin.designations.index') }}"
                   class="btn btn-success">@lang('labels.backend.designations.view')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
				
			  <div class="form-group row">  
               <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('ministry_id',trans('labels.backend.designations.fields.ministry_id'), ['class' => 'control-label']) !!}
                    {!! Form::select('ministry_id', $ministry, old('ministry'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false]) !!}
                </div>
				 <div class="col-12 col-lg-6 form-group">
				  <label class="control-label">@lang('labels.backend.designations.fields.department_id')</label>
                <select class="form-control select2"  name="department_id">
              <option value="">Please Select</option>
              
            </select>
				
				 </div>
			 <div class="col-12 col-lg-6 form-group">
				<label class="control-label">@lang('labels.backend.designations.fields.office_id')</label>
                <select class="form-control select2"  name="office_id">
              <option value="">Please Select</option>  
                </select>
				
				 </div>
				 <div class="col-12 col-lg-6 form-group">
				 {{ html()->label(__('labels.backend.designations.fields.designation'))->class('form-control-label')->for('designation') }}
            {{ html()->text('designation')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.designations.fields.designation'))
                                ->attribute('maxlength', 500)
                                ->required()
                                ->autofocus() }} 
				
				 </div> 
				 
				 
				</div><!--form-group-->	


                    <div class="form-group row justify-content-center">
                        <div class="col-4">
                            {{ form_cancel(route('admin.cities.index'), __('buttons.general.cancel')) }}
                            {{ form_submit(__('buttons.general.crud.create')) }}
                        </div>
                    </div><!--col-->
                </div>
            </div>
        </div>
    </div>
    {{ html()->form()->close() }}
	
	    <script type="text/javascript">
    $(document).ready(function() {
        $('select[name="ministry_id"]').on('change', function() {
            var ministryID = $(this).val();
            //alert(ministryID); exit;
            if(ministryID) {
                $.ajax({
                    url: 'department-ajax/'+ministryID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        
                        $('select[name="department_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="department_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="department_id"]').empty();
            }
        });
				
		
	  $('select[name="department_id"]').on('change', function() {
            var departmentID = $(this).val();
            //alert(departmentID); exit;
            if(departmentID) {
                $.ajax({
                    url: 'office-ajax/'+departmentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        
                        $('select[name="office_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="office_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="office_id"]').empty();
            }
        });	
			
		
    });
</script>
@endsection
