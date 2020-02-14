@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.edit'))

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

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
{{ html()->modelForm($user, 'PATCH', route('admin.auth.user.update', $user->id))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.users.management')
                        <small class="text-muted">@lang('labels.backend.access.users.edit')</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                <div class="col">
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
                            <label class="control-label">@lang('labels.backend.designations.fields.designation')</label>
                            <select class="form-control select2"  name="designation_id">
                          <option value="">Please Select</option>  
                            </select>
                     </div> 
                     <div class="col-12 col-lg-6 form-group">
                            <label class="control-label">Registration Type</label>
                            <select class="form-control select2"  name="registration_type">
                                <option value="">Please Select</option> 
                                 <option value="1">LDAP</option> 
                                <option value="2">Manual</option> 
                            </select>
                     </div> 

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('reportingmanager_id',trans('labels.backend.designations.fields.reportingmanager_id'), ['class' => 'control-label']) !!}
                        {!! Form::select('reportingmanager_id', $users, old('users'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false]) !!}
                    </div> 

                     <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('organisationaldept_id',trans('labels.backend.designations.fields.organisationaldept_id'), ['class' => 'control-label']) !!}
                        <select class="form-control select2"  name="organisationaldept_id">
                            <option value="">Please Select</option>  
                        </select>
                        
                    </div>  
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('organisationaldept_role',trans('labels.backend.designations.fields.organisationaldept_role'), ['class' => 'control-label']) !!}
                        <select class="form-control select2"  name="organisationaldept_role">
                            <option value="">Please Select</option>  
                        </select>
                        
                    </div>    
                </div><!--form-group--> 
                    <div class="form-group row">
                    {{ html()->label(__('validation.attributes.backend.access.users.first_name'))->class('col-md-2 form-control-label')->for('first_name') }}

                        <div class="col-md-10">
                            {{ html()->text('first_name')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.access.users.first_name'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.access.users.last_name'))->class('col-md-2 form-control-label')->for('last_name') }}

                        <div class="col-md-10">
                            {{ html()->text('last_name')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.access.users.last_name'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.access.users.email'))->class('col-md-2 form-control-label')->for('email') }}

                        <div class="col-md-10">
                            {{ html()->email('email')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.access.users.email'))
                                ->attributes(['maxlength'=> 191,'readonly'=>true])
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                    {{ html()->label(__('validation.attributes.backend.access.users.employee_code'))->class('col-md-2 form-control-label')->for('last_name') }}

                        <div class="col-md-10">
                            {{ html()->text('emp_code')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.access.users.employee_code'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <!-- <div class="form-group row">
                    {{ html()->label(__('validation.attributes.backend.access.users.moodle_id'))->class('col-md-2 form-control-label')->for('last_name') }}

                        <div class="col-md-10">
                            {{ html()->text('moodle_id')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.access.users.moodle_id'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                        </div>
                    </div> -->
                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.access.users.isadmin'))->class('col-md-2 form-control-label')->for('active') }}

                        <div class="col-md-2">
                            <select class="form-control select2"  name="is_admin">
                                <option value="">Please Select</option> 
                                <option value="1" <?php echo ($user->is_admin == 1 ? 'selected' : '') ?>>Yes</option> 
                                <option value="0" <?php echo ($user->is_admin == 1 ? '' : 'selected') ?>>No</option> 
                            </select>
                            
                        </div><!--col-->
                    </div>
                     <div class="form-group row" id="TrackDiv" style="display: none;">
                            {!! Form::label('track_id',trans('labels.backend.crts.fields.track_id'), ['class' => 'col-md-2 form-control-label']) !!}
                            <div class="col-md-4">
                                <select class="form-control select2" id="track_id" name="track_id[]" multiple="multiple">
                                      
                                </select>
                            
                            </div><!--col-->
                        </div>

                    <!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Abilities')->class('col-md-2 form-control-label') }}

                        <div class="table-responsive col-md-10">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>@lang('labels.backend.access.users.table.roles')</th>
                                        <th>@lang('labels.backend.access.users.table.permissions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            @if($roles->count())
                                                @foreach($roles as $role)
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="checkbox d-flex align-items-center">
                                                                {{ html()->label(
                                                                        html()->checkbox('roles[]', in_array($role->name, $userRoles), $role->name)
                                                                                ->class('switch-input')
                                                                                ->id('role-'.$role->id)
                                                                        . '<span class="switch-slider" data-checked="on" data-unchecked="off"></span>')
                                                                    ->class('switch switch-label switch-pill switch-primary mr-2')
                                                                    ->for('role-'.$role->id) }}
                                                                {{ html()->label(ucwords($role->name))->for('role-'.$role->id) }}
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            @if($role->id != 1)
                                                                @if($role->permissions->count())
                                                                    @foreach($role->permissions as $permission)
                                                                        <i class="fas fa-dot-circle"></i> {{ ucwords($permission->name) }}
                                                                    @endforeach
                                                                @else
                                                                    @lang('labels.general.none')
                                                                @endif
                                                            @else
                                                                @lang('labels.backend.access.users.all_permissions')
                                                            @endif
                                                        </div>
                                                    </div><!--card-->
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @if($permissions->count())
                                                @foreach($permissions as $permission)
                                                    <div class="checkbox d-flex align-items-center">
                                                        {{ html()->label(
                                                                html()->checkbox('permissions[]', in_array($permission->name, $userPermissions), $permission->name)
                                                                        ->class('switch-input')
                                                                        ->id('permission-'.$permission->id)
                                                                    . '<span class="switch-slider" data-checked="on" data-unchecked="off"></span>')
                                                                ->class('switch switch-label switch-pill switch-primary mr-2')
                                                            ->for('permission-'.$permission->id) }}
                                                        {{ html()->label(ucwords($permission->name))->for('permission-'.$permission->id) }}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!--col-->
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.auth.user.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
{{ html()->closeModelForm() }}

<script type="text/javascript">
      $(document).ready(function() {
    $('select[name="is_admin"]').on('change', function() {
                var isAdmin = $(this).val();

                if(isAdmin == 1){
                    $('#TrackDiv').css( "display", "block" );
                }else{
                    $('#TrackDiv').css( "display", "none" );
                }
           });
    });
</script>
@endsection
