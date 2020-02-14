<div class="card">
<div class="card-body">
 <div class="row">
<div class="col-12">
    <div class="card-footer clearfix">
                <div class="row">
                    

                    <div class="col text-right">
                        <a class="btn btn-primary" href="{{route('admin.auth.user.showuser')}}" role="button">Update Profile</a>
                    </div><!--col-->
                </div><!--row-->
            </div>
    <div class="table-responsive">

         <table id="myTable"
                               class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th>@lang('labels.backend.access.users.tabs.content.history.ministry_id')</th>
                                <th>@lang('labels.backend.access.users.tabs.content.history.department_id')</th>
                                <th>@lang('labels.backend.access.users.tabs.content.history.office_id')</th>
                                <th>@lang('labels.backend.access.users.tabs.content.history.designation_id')</th>
                                <th>@lang('labels.backend.access.users.tabs.content.history.organisationaldept_id')</th>
                                <th>@lang('labels.backend.access.users.tabs.content.history.organisationaldept_role')</th> 
                                <th>@lang('labels.backend.access.users.tabs.content.history.status')</th> 
                                
                            </tr>
                            </thead>

                            <tbody>
                             @foreach($data as $user)
                            <tr>
                                <td>{{ $user->ministry_name}}</td>
                                <td>{{ $user->department_name }}</td>
                                <td>{{ $user->office_name}}</td>
                                <td>{{ $user->designation}}</td>
                                <td>{{$user->deptname}}</td>
                                <td>{{$user->role_name}}</td>
                                  @if($user->profile == 1)
                                 <td><button type="button" id ="success" class="btn btn-success active" data-attr="{{$user->id}}">Active</button></td>
                                 @else
                                  <td><button type="button" id="inactive" class="btn btn-danger">Inactive</button></td>
                                 @endif
                                
                            </tr>
                        @endforeach 
                            </tbody>
                        </table>
    </div>
</div>
</div>
</div>
</div>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.active').click(function(){
            var bid =$(this).attr('data-attr');
            if(bid) {
                 $.ajax({
                    url: 'user-status/'+bid,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                         if (data == 1){
                          window.location.reload(); 
                        }
                    }
                });
            }

        });
    });
    </script>


