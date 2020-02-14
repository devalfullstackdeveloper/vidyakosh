@extends('backend.layouts.app')
@section('title', __('labels.backend.documents.title').' | '.app_name())

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
{{ html()->modelForm($documents, 'PATCH', route('admin.documents.update', $documents->id))->class('form-horizontal docsFile')->acceptsFiles()->open() }}

<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.documents.edit')</h3>
        <div class="float-right">
            <a href="{{ route('admin.documents.index',['date'=>$documents->agenda_date,'crt'=>$documents->crt_id]) }}"
               class="btn btn-success">@lang('labels.backend.documents.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">

                <div class="form-group row">  
                    <div class="col-12 col-lg-6 form-group">

                        <input type="hidden" name="agenda_date" value="{{$documents->agenda_date}}">
                        <input type="hidden" name="crt_id" value="{{$documents->crt_id}}">
                        {!! Form::label('z',trans('labels.backend.documents.fields.type'), ['class' => 'control-label']) !!}
                        {!! Form::select('type', $type , $documents->type, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false]) !!}

                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('File Upload',  trans('labels.backend.documents.fields.file'), ['class' => 'control-label']) !!}
                        {!! Form::file('file', ['class' => 'form-control docsFile', 'accept' => 'PDF/zip/excel/doc/png']) !!} 
                    </div> 
                    <div class="col-12 col-lg-6 form-group">
                        {{ html()->label(__('Description'))->class('form-control-label')->for('Description') }}
                        {{ html()->textarea('description')
                        ->class('form-control')
                        ->placeholder(__('Description'))
                        ->attribute('maxlength', 500)
                        ->required()
                        ->autofocus() }} 
                    </div> 

                </div><!--form-group-->	


                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.documents.index',['date'=>$documents->agenda_date,'crt'=>$documents->crt_id]), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.update')) }}
                    </div>
                </div><!--col-->
            </div>
        </div>
    </div>

</div>
{{ html()->closeModelForm() }}

@endsection
<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
<script>
    $(".documentForm").submit(function(e) {
        // get the file name, possibly with path (depends on browser)
        var filename = $(".docsFile").val();
        // Use a regular expression to trim everything before final dot
        var extension = filename.replace(/^.*\./, '');
        if (extension == filename) {
            extension = '';
        } else {
            extension = extension.toLowerCase();
        }
        if(extension != ""){
            if(extension != "pdf" && extension != "zip" && extension != "png" && extension != "doc" && extension != "xlsx"){
                jQuery('.documentForm').before('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">X</span></button>File Type Must be pdf, zip, xlsx, doc, png.<br></div>');
                return false;
            }
        }
        
        
    });
</script>

