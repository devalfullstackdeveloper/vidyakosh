@extends('backend.layouts.app')

@section('title', __('labels.backend.submitsuggestion.title').' | '.app_name())

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

</style>

@endpush


@section('content')
{{ html()->form('POST', route('admin.resources.store'))->acceptsFiles()->class('form-horizontal')->open() }}
<div class="card">
	<div class="card-header">
		<h3 class="page-title ">@lang('labels.backend.submitsuggestion.title')</h3>
	</div>
	<div class="card-body">
		<div class="row">
			 <div class="col-12">

				<div class="form-group row">

					
					<div class="col-12 col-lg-6 form-group">
                        {!! Form::label('resourcetrack', trans('labels.backend.resourcelist.fields.resourcetrack').' *', ['class' => 'control-label']) !!}
                        {!! Form::select('resourcetrack', $resourcetrack, old('resourcetrack'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

                    
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('resourcecat',trans('labels.backend.resourcelist.fields.resourcecat'), ['class' => 'control-label']) !!}
                        {!! Form::select('resourcecat', $resourcecat, old('resourcecat'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

					<div class="col-12 col-lg-6 form-group">
						<label class="control-label">Resource Type</label>
						<select class="form-control select2"  name="resourcetype">
							<option value="1">Video</option>
							<option value="2">Document</option>
						</select>
					</div>
					<div class="col-12 col-lg-6 form-group year_1">
						{{ html()->label(__('labels.backend.resourcelist.fields.resourcetitle'))->class('form-control-label')->for('resourcetitle') }}
						{{ html()->text('resourcetitle')
						->class('form-control')
						->placeholder(__('labels.backend.resourcelist.fields.resourcetitle'))
						->attribute('maxlength', 500)
						->required()
						->autofocus() }} 

					</div>
					<div class="col-12 col-lg-6 form-group year_1">
						{{ html()->label(__('labels.backend.resourcelist.fields.resourcesuggested_link'))->class('form-control-label')->for('resourcesuggested_link') }}
						{{ html()->text('resourcesuggested_link')
						->class('form-control')
						->placeholder(__('labels.backend.resourcelist.fields.resourcesuggested_link'))
						->attribute('maxlength', 1000)
						->required()
						->autofocus() }} 

					</div>
				</div><!--form-group-->	


				<div class="form-group row justify-content-center">
					<div class="col-4">
						{{ form_cancel(route('admin.resources.index'), __('buttons.general.cancel')) }}
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
        $('select[name="resourcetrack"]').on('change', function() {
            var trackID = $(this).val();
            if(trackID) {
                $.ajax({
                    url: 'category-ajax/'+trackID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="resourcecat"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="resourcecat"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="resourcecat"]').empty();
            }
        });	
        
    });
</script>
@endsection

