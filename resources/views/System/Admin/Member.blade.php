@extends('System.Layouts.Master')
@section('title')
Admin Member
@endsection
@section('css')
@endsection
@section('content')
<div class="app-body">
    <!-- ############ PAGE START-->
    <div class="row-col">
        <div class="col-lg b-r">
            <div class="padding padding-big">
                <div class="row">
                    <form method="get" action="{{route('system.admin.getMember')}}">@csrf
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <h2><i class="fa fa-user" aria-hidden="true"></i> Member</h2>
                                        </div>
                                        <div class="box-divider m-a-0"></div>
                                        <div class="box-body bg-logo">
                                            <div class="row m-b p-a">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10" for="exampleInputpwd_1"><i
                                                                class="fa fa-user" aria-hidden="true"></i> User
                                                            ID</label>
                                                        <input class="form-control" type="text" placeholder="User ID"
                                                            value="{{request()->input('UserID')}}" name="UserID">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10" for="exampleInputpwd_1"><i
                                                                class="fa fa-users" aria-hidden="true"></i>
                                                            Email</label>
                                                        <input class="form-control" type="text" placeholder="Email"
                                                            value="{{request()->input('Email')}}" name="Email">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10" for="exampleInputpwd_1"><i
                                                                class="fa fa-users" aria-hidden="true"></i> Created
                                                            Date</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Registration Time" name="datetime"
                                                            id="datetime" value="{{request()->input('datetime')}}" />
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10" for="exampleInputpwd_1"><i
                                                                class="fa fa-users" aria-hidden="true"></i>
                                                            Sponsor</label>
                                                        <input class="form-control" type="text" placeholder="Sponsor"
                                                            value="{{request()->input('sponsor')}}" name="sponsor">
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10" for="exampleInputpwd_1"><i
                                                                class="fa fa-users" aria-hidden="true"></i> Tree</label>
                                                        <input class="form-control" type="text" placeholder="Tree"
                                                            value="{{request()->input('tree')}}" name="tree">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10" for="exampleInputpwd_1"><i
                                                                class="fa fa-users" aria-hidden="true"></i>Sun Tree</label>
                                                        <input class="form-control" type="text" placeholder="Sun Tree"
                                                            value="{{request()->input('suntree')}}" name="suntree">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10" for="exampleInputpwd_1"><i
                                                                class="fa fa-users" aria-hidden="true"></i>
                                                            Status</label>
                                                        <select id="inputState" class="form-control" name="status">
                                                            <option selected value=""
                                                                {{request()->input('status') == '' ? 'selected' : ''}}>
                                                                --- Select ---</option>
                                                            <option value="1"
                                                                {{request()->input('status') == '1' ? 'selected' : ''}}>
                                                                Active</option>
                                                            <option value="0"
                                                                {{request()->input('status') == '0' ? 'selected' : ''}}>
                                                                Not Active</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                {{-- <div class="col-md-6">
                                                    <label for="single-prepend-text">ID</label>
                                                    <div class="input-group m-b">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-user"></i></span>
                                                        <input type="text" name="user_id" class="form-control"
                                                            placeholder="Enter ID">
                                                    </div>
                                                    <label for="single-prepend-text">Email</label>
                                                    <div class="input-group m-b">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-envelope"></i></span>
                                                        <input type="text" name="email" class="form-control"
                                                            placeholder="Enter Email">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="single-prepend-text">Agency Level</label>
                                                        <div class="input-group select2-bootstrap-prepend">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" type="button"
                                                                    data-select2-open="single-prepend-text">
                                                                    <span class="fa fa-caret-down"></span>
                                                                </button>
                                                            </span>
                                                            <select id="single-prepend-text" name="agency_level"
                                                                class="form-control select2" data-ui-jp="select2"
                                                                data-ui-options="{theme: 'bootstrap'}">
                                                                <option value="">---select---</option>
                                                                <option value="0">Level 0</option>
                                                                <option value="1">Level 1</option>
                                                                <option value="2">Level 2</option>
                                                                <option value="3">Level 3</option>
                                                                <option value="4">Level 4</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="single-prepend-text">Level</label>
                                                        <div class="input-group select2-bootstrap-prepend">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" type="button"
                                                                    data-select2-open="single-prepend-text">
                                                                    <span class="fa fa-caret-down"></span>
                                                                </button>
                                                            </span>
                                                            <select id="single-prepend-text" name="level"
                                                                class="form-control select2" data-ui-jp="select2"
                                                                data-ui-options="{theme: 'bootstrap'}">
                                                                <option value="">---select---</option>
                                                                <option value="0">User</option>
                                                                <option value="1">Admin</option>
                                                                <option value="2">Finance</option>
                                                                <option value="3">Support</option>
                                                                <option value="4">Customer</option>
                                                                <option value="5">Test</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div> --}}

                                                <div class="pull-left m-l-md">
                                                    <div class="btn-groups">
														
                                                    	<div class="form-group">
								                        	<label for="single-prepend-text">Check To Export</label>
											                <input type="checkbox" class="form-control" name="export" value="1" style="width: 26px; height: 26px;">
								                        </div>
                                                        <button class="btn btn-outline info"><i class="fa fa-search"
                                                                aria-hidden="true"></i>
                                                            Search
                                                        </button>
                                                        <button type="submit" class="btn btn-outline warning" name="export" value="1"><i class="fa fa-search"
                                                                aria-hidden="true"></i>
                                                            Export
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <h2><i class="fa fa-table"></i> List User</h2>
                            </div>
                            <div class="box-body bg-logo">
                                <div class="p-a-sm pull-left">

                                </div>
                                <div class="pull-right p-r-md">
                                    <div class="btn-groups">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="member-list-table" class="table m-b-none">
                                        <thead>
                                            <tr>
                                                <th data-toggle="true">
                                                    ID
                                                </th>
                                                <th>
	                                                LEVEL
                                                </th>
                                                <th>
                                                    MAIL
                                                </th>
                                                <th data-hide="phone">
                                                    REGISTERED DATE
                                                </th>
                                                <th data-hide="phone">
                                                    PARENT
                                                </th>
                                                <th data-hide="phone">
                                                    AGENCY LEVEL
                                                </th>
                                                <th data-hide="phone,tablet">
                                                    BINARY TREE
                                                </th>
                                                <th data-hide="phone,tablet">
                                                    SUN TREE
                                                </th>
                                                <th data-hide="phone,tablet">
                                                    STATUS
                                                </th>
                                                <th data-hide="phone">
                                                    AUTH
                                                </th>
                                                <th data-hide="phone">
                                                    ACTION
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($memberList as $user)
                                            <tr>
                                                <td>
                                                    <p>{{ $user->User_ID }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ $level[$user->User_Level] }}</p>
                                                </td>
                                                <td>


                                                    <i class="d-block"
                                                        style="display: block; font-weight: bold;">{{ $user->User_ID }}</i>
                                                    <span
                                                        id="input-email-{{$user->User_ID}}">{{$user->User_Email}}</span>
                                                    <div id="action-email-{{$user->User_ID}}" style="float:right">
                                                        <a data-id_user='{{$user->User_ID}}' href="javascript:void(0)"
                                                            class="btn-edit-mail btn btn-warning btn-xs waves-effect waves-light"><i
                                                                class="fa fa-edit"> </i></a>
                                                    </div>
                                                </td>
                                                <td>{{ $user->User_RegisteredDatetime }}</td>
                                                <td>{{ $user->User_Parent }}</td>
                                                <td>{{$user->user_agency_level_Name}}</td>
                                                <td width="200px">
                                                    <div style="overflow:auto;width:300px!important;height:60px">
                                                        {{ str_replace(',',', ', $user->User_Tree) }}</div>
                                                </td>
                                                <td width="200px">
                                                    <div style="overflow:auto;width:300px!important;height:60px">
                                                        {{ str_replace(',',', ', $user->User_SunTree) }}</div>
                                                </td>
                                                <td>
                                                    @if($user->User_EmailActive == 0)
                                                    <span class="label label-danger r-3 blink">Not
                                                        Active</span>
                                                    @else
                                                    <span class="label label-success r-3">Active</span>
                                                    @endif
                                                    @php
                                                    $enableKYC = App\Models\Profile::where('Profile_User',
                                                    $user->User_ID)->where('Profile_Status', 1)->first();
                                                    @endphp
                                                    @if(isset($enableKYC))
                                                    <span class="label label-success r-3">Verification
                                                        turned on</span>
                                                    @else
                                                    <span class="label label-danger r-3">Verification not
                                                        enabled</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($user->google2fa_User)
                                                    <a href="{{ route('system.admin.getDisableAuth', $user->User_ID) }}"
                                                        class="btn btn-danger btn-xs waves-effect waves-light"><i
                                                            class="fa fa-trash"> Delete</i></a>
                                                    @else
                                                    <span class="btn btn-secondary btn-xs waves-effect waves-light"><i
                                                            class="fa fa-ban"> None</i></span>
                                                    @endif
                                                </td>
                                                <td>

                                                    <a href="{{ route('system.admin.getLoginByID', $user->User_ID) }}"
                                                        class="bt-loginID btn btn-primary btn-xs waves-effect waves-light"
                                                        data-toggle="tooltip" title="Login"><i class="fa fa-sign-in">
                                                            Login</i></a>
                                                    @if($user->User_EmailActive == 0)
                                                    <a href="{{ route('system.admin.getActiveMail', $user->User_ID) }}"
                                                        class="bt-loginID btn btn-success btn-xs waves-effect waves-light"
                                                        data-toggle="tooltip"><i class="fa fa-check"> Active</i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                        <tfoot class="hide-if-no-paging">
                                            <tr>
                                                <td colspan="12" class="text-center">
                                                    <ul class="pagination">
                                                        {{ $memberList->appends(request()->input())->links()}}</ul>

                                                </td>
                                            </tr>

                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ############ PAGE END-->
</div>
@endsection
@section('script')

<script>
    $(document).ready(function() {
        $('.bt-loginID').click(function(e) {
            if ($('.bt-loginID').hasClass("disabled")) {
                event.preventDefault();
            }
            $('.bt-loginID').addClass("disabled");
        });
        var arr_email = [];
        $('#member-list-table').on('click', '.btn-edit-mail', function(){
            let id_user = $(this).data('id_user');
            var html_edit_mail = "<input id=\"input-mail-"+id_user+"\" type=\"text\" class=\"edit-email-input\" value=\""+$('#input-email-'+id_user).text()+"\">";
            arr_email[id_user] = $('#input-email-'+id_user).text();
            let html_action_mail = "<a data-id_user='"+id_user+"' href=\"javascript:void(0)\" class=\"btn-disable-mail btn btn-warning btn-xs waves-effect waves-light\"><i class=\"fa fa-edit\"> </i></a>  <a data-id_user='"+id_user+"' href=\"javascript:void(0)\" class=\"btn-save-mail btn btn-success btn-xs waves-effect waves-light\"><i class=\"fa fa-save\"> </i></a>"
            $('#action-email-'+id_user).html(html_action_mail);
            $('#input-email-'+id_user).html(html_edit_mail);
        });
        $('#member-list-table').on('click', '.btn-disable-mail', function(){
            let id_user = $(this).data('id_user');
            let html_edit_mail =  arr_email[id_user];
            let html_action_mail = "<a data-id_user='"+id_user+"' href=\"javascript:void(0)\" class=\"btn-edit-mail btn btn-warning btn-xs waves-effect waves-light\"><i class=\"fa fa-edit\"> </i></a>"
            $('#action-email-'+id_user).html(html_action_mail);
            $('#input-email-'+id_user).html(html_edit_mail);
        });
        $('#member-list-table').on('click', '.btn-save-mail', function(){
            let id_user = $(this).data('id_user');
            let html_edit_mail = $('#input-mail-'+id_user).val();
            let html_action_mail = "<a data-id_user='"+id_user+"' href=\"javascript:void(0)\" class=\"btn-edit-mail btn btn-warning btn-xs waves-effect waves-light\"><i class=\"fa fa-edit\"> </i></a>"
            $('#action-email-'+id_user).html(html_action_mail);
            $.ajax({
                url : '{{ route('system.admin.getEditMailByID') }}',
                type : "POST", 
                dataType:"json", 
                data : { 
                    _token: "{{ csrf_token() }}",
                    id_user : id_user,
                    new_email : html_edit_mail
                },
                success : function (result){
                    if(!result){
                        html_edit_mail = arr_email[id_user];  
                        toastr.error('Email Already Exists', 'Error!', {timeOut: 3500});
                    }
                    else{   
                        if(result == -1){
                            html_edit_mail = arr_email[id_user];
                            toastr.error('ID Does Not Exist', 'Error!', {timeOut: 3500});
                        }
                        else{
                            html_edit_mail = $('#input-mail-'+id_user).val();
                            toastr.success('Updated Email', 'Success!', {timeOut: 3500});
                        }
                    }
                    $('#input-email-'+id_user).html(html_edit_mail);
                }
            });
        });
    });
</script>
@endsection