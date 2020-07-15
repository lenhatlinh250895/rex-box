@extends('System.Layouts.Master')
@section('title')
    Profile
@endsection
@section('css')
    <link href="vendors/bower_components/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<div class="app-body">
  <div class="padding padding-big">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <div class="box">
              <div class="item">
                <div class="item-bg light h6">
                </div>
                <div class="p-a p-t-sm pos-rlt text-center">
                  <img src="system/images/icon/RedUser.png" class="w-96" style="margin-bottom: -3.5rem">
                </div>
              </div>
              <div class="p-a-md bg-logo">
                <div class="m-t p-x-lg text-center m-t-md">
                  <h4>{{session('user')->User_ID}}</h4>
                  <button class="btn btn-outline b-light text-light" id="btn-change-password"><i class="fa fa-pencil" aria-hidden="true"></i> Change Password</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-6">
            <div class="box">
              <div class="item">
                <div class="item-bg light h6">
                </div>
                <div class="p-a p-t-sm pos-rlt text-center">
                  <img src="system/images/icon/search.png" alt="." class="w-96" style="margin-bottom: -3.2rem">
                </div>
              </div>
              <div class="p-a-md bg-logo">
                <div class="m-t p-x-lg m-t-sm text-center">
                  <h6>Google Authentication<br>Used For Withdrawals And Security Modifications</h6>
                  <button class="btn btn-outline b-info text-info" id="btn-google-authy"><i class="fa fa-key" aria-hidden="true"></i>{{ ($Enable) ? 'Disable Auth' : 'Enable Auth' }}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="box">
          <div class="box-header">
            <h2><i class="fa fa-user"></i> User Information</h2>
          </div>
          <div class="box-divider m-a-0"></div>
          <div class="box-body bg-logo">
            <form role="form" method="post" action="{{route('system.postProfile')}}">
	            @csrf
              <label class="form-control-label">Email Address</label>
              <div class="input-group m-b">
                <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="Enter Email Address" value="{{session('user')->User_Email}}" readonly>
              </div>
              <label class="form-control-label">Wallet Ethereum</label>
              <div class="input-group m-b">
                <span class="input-group-addon"><i class="fa fa-google-wallet" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="address" required="" value="{{session('user')->User_WalletAddress}}" placeholder="Enter Wallet">
              </div>
              <label class="form-control-label">Google Authenticator</label>
              <div class="input-group m-b">
                <span class="input-group-addon"><i class="fa fa-google-plus" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="otp" required placeholder="Enter Google Authenticator">
              </div>
	            <div class="text-right">
	              <button class="btn btn-outline info"><i class="fa fa-send-o" aria-hidden="true" type="submit"></i> Update</button>
	            </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-8">
          <form method="post" action="{{route('system.user.PostKYC')}} " enctype="multipart/form-data">
              @csrf
        <div class="box">
          <div class="box-header">
            <h2><i class="fa fa-key" aria-hidden="true"></i> Verification</h2>
          </div>
          <div class="box-divider m-a-0"></div>
          <div class="box-body bg-logo">
            <div class="row m-b">
              <div class="col-md-4">
                <label>ID/Passport Number</label>
                <div class="input-group m-b">
                  <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                  <input type="text" class="form-control" name="passport" id="passport" placeholder="ID/Passport Number">
                </div>
              </div>

              <div class="col-md-4">
                <label>ID/Passport</label>
                <p>Make sure the image is full and clear and the format is jpg, jpeg.</p>
                  <input type="file" name="passport_image" id="passport-image" class="dropify bg-dark" data-default-file="system/images/verification/redbox-id-card.png" accept="image/*" />
              </div>
              <div class="col-md-4">
                <label>Selfie</label>
                <p>Make sure the image is full and clear and the format is jpg, jpeg.</p>
                <p>
                  <i class="fa fa-caret-right" aria-hidden="true"></i> Your face<br>
                  <i class="fa fa-caret-right" aria-hidden="true"></i> Your ID/Passport
                </p>
                  <input type="file" name="passport_image_selfie" id="passport_image_selfie" class="dropify bg-dark" data-default-file="system/images/verification/redbox-selfie.png" accept="image/*"/>
              </div>
            </div>
            <div class="text-right">
              <button class="btn btn-outline info"><i class="fa fa-send-o" aria-hidden="true"></i> Submit</button>
            </div>
          </div>
        </div>
          </form>
      </div>

    </div>

  </div>
  <!-- ############ PAGE START-->
<!--Change password modal -->
    <div id="modal-change-password" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('system.user.postChangePassword')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 class="modal-title" id="myModalLabel">Change Password</h5>
                    </div>
                    <div class="modal-body">
                        <!-- Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body pa-0">
                                            <div class="col-sm-12 col-xs-12">
                                                <div class="form-wrap">
                                                    <div class="form-body overflow-hide">
                                                        <div class="form-group">
                                                            <label class="mb-10 text-dark" for="exampleInputpwd_1">Current Password</label>
                                                            <div class="input-group">
                                                                <div class="input-group-addon"><i class="icon-lock"></i></div>
                                                                <input type="password" class="form-control" name="current_password" placeholder="Enter current password">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="mb-10 text-dark" for="exampleInputpwd_1">New Password</label>
                                                            <div class="input-group">
                                                                <div class="input-group-addon"><i class="icon-lock"></i></div>
                                                                <input type="password" class="form-control" name="new_password" placeholder="Enter new password">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="mb-10 text-dark" for="exampleInputpwd_1">Password confirm</label>
                                                            <div class="input-group">
                                                                <div class="input-group-addon"><i class="icon-lock"></i></div>
                                                                <input type="password" class="form-control" name="password_confirm" placeholder="Enter password confirm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success waves-effect"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--/Change password modal-->
    <!--Modal Google Authencation -->
    <div id="modal-google-authy" class="modal fade animate" data-backdrop="true">
        <div class="modal-dialog" id="animate">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        {{ ($Enable) ? 'Disable Authenticator' : 'Enable Authenticator' }}
                    </h4>
                </div>
                <!-- Modal Body -->
                <div class="modal-body text-center">
                    <form role="form" action="{{route('system.user.postAuth')}}" method="POST" style="color:black!important;">
                        {{csrf_field()}}
                        @if(!$Enable)
                            Authenticator Secret Code: <b>{{ $secret }}</b>
                            <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{ $inlineUrl }}&choe=UTF-8">
                        @endif
                        <label >Enter the 2-step verification code provided by your authentication app</label>
                        <input type="text" name="verifyCode" class="form-control" id="exampleInputuname_01" placeholder="Verification code" value="">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success waves-effect">{{ ($Enable) ? 'Disable' : 'Enable' }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!--/Modal Google authenticion -->

  <!-- ############ PAGE END-->
</div>
@endsection
@section('script')
    <script src="vendors/bower_components/dropify/dist/js/dropify.min.js"></script>
    <script src="dist/js/form-file-upload-data.js"></script>
    <script>

        $('#btn-change-password').click(function () {
            $('#modal-change-password').modal('show');
        });

        $('#btn-google-authy').click(function () {
           $('#modal-google-authy').modal('show');
        });
        data = @json($kycProfile);
        if (data) {
            $('#passport').val(data.Profile_Passport_ID);
            $('#passport-image').attr('data-default-file', 'https://media.redboxdapp.com/' + data.Profile_Passport_Image);
            $("#passport_image_selfie").attr('data-default-file', 'https://media.redboxdapp.com/' + data.Profile_Passport_Image_Selfie);
        }

    </script>
@endsection
