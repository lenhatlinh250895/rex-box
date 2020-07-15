@extends('System.Layouts.Master')
@section('title')
    Admin Profile
@endsection
@section('css')
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css"/>

@endsection
@section('content')
    <div class="app-body">
        <!-- ############ PAGE START-->
        <div class="row-col">
            <div class="col-lg b-r">
                <div class="padding padding-big">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <h2><i class="fa fa-user" aria-hidden="true"></i> Profile</h2>
                                        </div>
                                        <div class="box-divider m-a-0"></div>
                                        <div class="box-body bg-logo">
                                            <div class="row m-b p-a">
                                                <div class="col-md-6">
                                                    <label for="single-prepend-text">ID</label>
                                                    <div class="input-group m-b">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-user"></i></span>
                                                        <input type="text" class="form-control" placeholder="Enter ID">
                                                    </div>
                                                    <label for="single-prepend-text">Email</label>
                                                    <div class="input-group m-b">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-envelope"></i></span>
                                                        <input type="text" class="form-control"
                                                               placeholder="Enter Email">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="single-prepend-text">Status</label>
                                                        <div class="input-group select2-bootstrap-prepend">
														<span class="input-group-btn">
															<button class="btn btn-default" type="button"
                                                                    data-select2-open="single-prepend-text">
															<span class="fa fa-caret-down"></span>
															</button>
														</span>
                                                            <select id="single-prepend-text"
                                                                    class="form-control select2" data-ui-jp="select2"
                                                                    data-ui-options="{theme: 'bootstrap'}">
                                                                <option value="A">Pedding</option>
                                                                <option value="B">Confirmed</option>
                                                                <option value="B">Error</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="single-prepend-text">From</label>
                                                    <div class="form-group">
                                                        <div class='input-group date' data-ui-jp="datetimepicker"
                                                             data-ui-options="{
														format: 'DD/MM/YYYY',
														icons: {
														time: 'fa fa-clock-o',
														date: 'fa fa-calendar',
														up: 'fa fa-chevron-up',
														down: 'fa fa-chevron-down',
														previous: 'fa fa-chevron-left',
														next: 'fa fa-chevron-right',
														today: 'fa fa-screenshot',
														clear: 'fa fa-trash',
														close: 'fa fa-remove'
														}
														}">
                                                            <input type='text' class="form-control"/>
                                                            <span class="input-group-addon">
															<span class="fa fa-calendar"></span>
														</span>
                                                        </div>
                                                    </div>
                                                    <label for="single-prepend-text">To</label>
                                                    <div class="form-group">
                                                        <div class='input-group date' data-ui-jp="datetimepicker"
                                                             data-ui-options="{
														format: 'DD/MM/YYYY',
														icons: {
														time: 'fa fa-clock-o',
														date: 'fa fa-calendar',
														up: 'fa fa-chevron-up',
														down: 'fa fa-chevron-down',
														previous: 'fa fa-chevron-left',
														next: 'fa fa-chevron-right',
														today: 'fa fa-screenshot',
														clear: 'fa fa-trash',
														close: 'fa fa-remove'
														}
														}">
                                                            <input type='text' class="form-control"/>
                                                            <span class="input-group-addon">
															<span class="fa fa-calendar"></span>
														</span>
                                                        </div>
                                                    </div>
                                                    <div class="pull-left">
                                                        <label for="single-prepend-text" style="opacity: 0">To</label>
                                                        <div class="btn-groups">
                                                            <button class="btn btn-outline info"><i class="fa fa-search"
                                                                                                    aria-hidden="true"></i>
                                                                Search
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header pd-b-2">
                                    <div class="pull-left">
                                        <h2><i class="fa fa-table"></i> Profile Confirm</h2>
                                    </div>
                                    <div class="pull-right">
                                        <h2>Total: $123456</h2>
                                    </div>
                                </div>
                                <div class="box-body bg-logo">
                                    <div class="p-a-sm">
                                        Search: <input id="filter" type="text"
                                                       class="form-control input-sm w-auto inline m-r"/>
                                    </div>
                                    <div>
                                        <table class="table m-b-none" data-ui-jp="footable" data-filter="#filter"
                                               data-page-size="10">
                                            <thead>
                                            <tr>
                                                <th data-toggle="true">
                                                    ID
                                                </th>
                                                <th>
                                                    PROFILE USER
                                                </th>
                                                <th data-hide="phone,tablet">
                                                    PASSPORT ID
                                                </th>
                                                <th data-hide="phone">
                                                    UPDATE TIME
                                                </th>
                                                <th data-hide="phone">
                                                    STATUS
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($profileList as $item)
                                            <tr>
                                                <td>{{$item->Profile_ID}}</td>
                                                <td>{{$item->Profile_User}}</td>
                                                <td>{{$item->Profile_Passport_ID}}</td>
                                                <td>{{$item->Profile_Time}}</td>
                                                <td id="list-profile-action-{{$item->Profile_ID}}">
                                                    @if($item->Profile_Status == 0)

                                                        <button class="btn btn-success btn-post-confirm-profile"
                                                                data-value="{{$item->Profile_ID}}"><i
                                                                class="fa fa-server" aria-hidden="true">Confirm</i>
                                                        </button>

                                                    @elseif($item->Profile_Status == 1)
                                                        Confirmed
                                                    @else
                                                        Cancel
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot class="hide-if-no-paging">
                                            <tr>
                                                <td colspan="12" class="text-center">
                                                    <ul class="pagination"></ul>
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
    <!-- Modal coinfirm profile -->
    <div id="profile_info" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal-profile-header"></h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('system.admin.getProfile')}} " enctype="multipart/form-data">
                        @csrf
                        {{--                                                            <div class="panel-wrapper collapse in">--}}
                        {{--                                                                <div class="panel-body pa-0">--}}
                        <div class="row">
                            <div class="col-md-12 col-lg-12" style="margin: auto;">
                                <div class="form-wrap">
                                    <div class="form-body overflow-hide">
                                        <div class="form-group">
                                            <label class="control-label mb-10" for="exampleInputuname_01"
                                                   style="color: #0088ce">ID/Passport Number</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                                <input type="text" class="form-control " name="passport_id"
                                                       id="modal-passport-id" placeholder="" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-wrap">
                                    <div class="form-body overflow-hide">
                                        <div class="form-group mb-30">
                                            <label class="control-label mb-10 text-left" style="color: #0088ce">ID/Passport</label>
                                            <div class="panel panel-default card-view">
                                                <div class="panel-wrapper collapse in">
                                                    <div class="panel-body">
                                                        <img
                                                            src="https://media.redboxdapp.com/users/447045/profile/passport_image_selfie_447045_5d83827631ad1.png"
                                                            width="100%" id="img-passport">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-wrap">
                                    <div class="form-body overflow-hide">
                                        <div class="form-group mb-30">
                                            <label class="control-label mb-10 text-left"
                                                   style="color: #0088ce">Selfie</label>
                                            <div class="panel panel-default card-view">
                                                <div class="panel-wrapper collapse in">
                                                    <div class="panel-body">
                                                        <img
                                                            src="https://media.redboxdapp.com/users/447045/profile/passport_image_selfie_447045_5d83827631ad1.png"
                                                            width="100%" id="img-passport-selfie">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" id="div-modal-footer">
                    <button type="button" class="btn btn-success" id="profile-accept">Accept</button>
                    <button type="button" class="btn btn-warning" id="profile-disagree">Disagree</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal confirm profile -->
@endsection
@section('script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $('.btn-post-confirm-profile').click(function () {
            profileID = $(this).attr('data-value');
            console.log(profileID);
            profileData = @json($profileList);
            profileInfor = jQuery.grep(profileData, function (obj) {
                return obj.Profile_ID == profileID;
            });

            $('#modal-profile-header').text('Profile ID: ' + profileID);
            $('#modal-passport-id').val(profileInfor[0].Profile_Passport_ID);
            $('#profile-accept').attr('data-value', profileID);
            $('#profile-disagree').attr('data-value', profileID);
            imageServerPath = "https://media.redboxdapp.com/";
            $('#img-passport').attr('src', imageServerPath + profileInfor[0].Profile_Passport_Image);
            $('#img-passport-selfie').attr('src', imageServerPath + profileInfor[0].Profile_Passport_Image_Selfie);
            $('#profile_info').modal('show');
        });

        $('#profile-accept').click(function () {
            profileID = $(this).attr('data-value');
            if (profileID) {
                var _token = $('meta[name="_token"]').attr('content');
                $.ajax({
                    url: '{{ route('system.admin.confirmProfile') }}',
                    type: "POST",
                    dataType: "json",
                    data: {_token: _token, id: profileID, action: 1},
                    success: function (data) {
                        if (data.status == 'success') {
                            $('#list-profile-action-' + profileID).html('Confirmed');
                            $('#profile_info').modal('hide');
                            swal("Confirmed!", {
                                icon: "success",
                            });
                        } else {
                            $('#profile_info').modal('hide');
                            swal("Error", data.message + "!", "error");

                        }
                    }
                });
            }
        });
        $('#profile-disagree').click(function () {
            profileID = $(this).attr('data-value');
            if (profileID) {
                var _token = $('meta[name="_token"]').attr('content');
                $.ajax({
                    url: '{{ route('system.admin.confirmProfile') }}',
                    type: "POST",
                    dataType: "json",
                    data: {_token: _token, id: profileID, action: -1},
                    success: function (data) {
                        if (data.status == 'success') {
                            $('#list-profile-action-' + profileID).text('Cancel');
                            swal("Success", data.message + "!", "Success");

                        } else {
                            $('#profile_info').modal('hide');
                            swal("Error", data.message + "!", "error");
                        }
                    }
                });
            }
        });

    </script>

@endsection
