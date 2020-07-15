<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Redbox</title>
    <meta name="description" content="Responsive, Bootstrap, BS4"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <base href="{{asset('')}}">
    <!-- for ios 7 style, multi-resolution icon of 152x152 -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
    <link rel="apple-touch-icon" href="system/images/logo/logRedbox-02.png">
    <meta name="apple-mobile-web-app-title" content="Flatkit">

    <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" sizes="196x196" href="system/images/logo/logRedbox-02.png">
    <base href="{{asset('')}}">
    <!-- style -->
    <link rel="stylesheet" href="system/css/animate/animate.min.css" type="text/css"/>
    <link rel="stylesheet" href="system/css/glyphicons/glyphicons.css" type="text/css"/>
    <link rel="stylesheet" href="system/css/font-awesome/css/font-awesome.min.css" type="text/css"/>
    <link rel="stylesheet" href="system/css/material-design-icons/material-design-icons.css" type="text/css"/>
    <link rel="stylesheet" href="system/css/ionicons/css/ionicons.min.css" type="text/css"/>
    <link rel="stylesheet" href="system/css/simple-line-icons/css/simple-line-icons.css" type="text/css"/>
    <link rel="stylesheet" href="system/css/bootstrap/dist/css/bootstrap.min.css" type="text/css"/>
    <!-- build:css css/styles/app.min.css -->
    <link rel="stylesheet" href="system/css/styles/app.css?v={{ time() }}" type="text/css"/>
    <link rel="stylesheet" href="system/css/styles/style.css" type="text/css"/>
    <!-- endbuild -->
    <link rel="stylesheet" href="system/css/styles/font.css" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css" />
	
	<!-- Start Alexa Certify Javascript -->
<script type="text/javascript">
_atrk_opts = { atrk_acct:"vaigt1zDGU20kU", domain:"redboxdapp.com",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://certify-js.alexametrics.com/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://certify.alexametrics.com/atrk.gif?account=vaigt1zDGU20kU" style="display:none" height="1" width="1" alt="" /></noscript>
<!-- End Alexa Certify Javascript -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-158646467-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-158646467-1');
</script>
</head>
<body>
<div class="app" id="app">
    <div class="padding">
        <canvas class="canvasBG"></canvas>
        <canvas class="canvasBG"></canvas>

    </div>
    <div class="b-t">
        <div class="center-block w-xxl w-auto-xs p-y-md text-center border-box">
            <div class="p-a-md">
                <div class="navbar navbar-Login">
                    <div class="pull-center">
                        <!-- brand -->
                        <a href="index.html" class="navbar-brand">
                            <img src="system/images/logo/logoRedbox-01.png" alt="Logo Redbox" width="100%">
                        </a>
                        <!-- / brand -->
                    </div>
                </div>
                <br>
                <form name="form" method="POST" action="{{route('postLogin')}}" id="sign-in-form">
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <!-- <div class="form-group">
                    	<div class="g-recaptcha" data-sitekey="6LfOtccUAAAAAD68tDwXAvaRMJRswxM8VGGw1zn3"></div>
                    </div> -->
                    <button type="submit" class="btn btn-lg black p-x-lg">Sign in</button>
                </form>
                <div class="m-y">
                    <a href="{{route('getForgotPass')}}" class="_600">Forgot password?</a>
                </div>
                {{--<div>
                    Do not have an account?
                    <a href="{{route('getRegister')}}" class="text-primary _600">Register</a>
                </div>--}}
            </div>
        </div>
    </div>

    <!-- ############ LAYOUT END-->
</div>
<div class="modal" id="myModal">
	<div class="modal-dialog" style="max-width:400px">
		<div class="modal-content" style="background-color: #fa0b0b;">
			<div class="modal-body" style="padding: 0;">
				<button type="button" class="close" data-dismiss="modal" style="padding-right: 10px;text-align: right;color:#fff;opacity:1">&times;</button>
				
				<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
						<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
					</ol>
					<div class="carousel-inner">
						@foreach($noti_image as $k=>$v)
						<div class="carousel-item {{$k == 0 ? 'active' : ''}}">
							<img src="https://redboxdapp.com/public/app/public/{{$v->Url}}" width="100%"> 
						</div>
						@endforeach	
					</div>
					<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
    <script src="system/libs/jquery/dist/jquery.js"></script>
    <script src="system/libs/jquery/dist/canvasBG.js?v={{ time() }}"></script>
    <!-- Bootstrap -->
    <script src="system/libs/tether/dist/js/tether.min.js"></script>
    <script src="system/libs/bootstrap/dist/js/bootstrap.js"></script>
    <!-- core -->
    <script src="system/libs/jQuery-Storage-API/jquery.storageapi.min.js"></script>
    <script src="system/libs/PACE/pace.min.js"></script>
    <script src="system/libs/jquery-pjax/jquery.pjax.js"></script>
    <script src="system/libs/blockUI/jquery.blockUI.js"></script>
    <script src="system/libs/jscroll/jquery.jscroll.min.js"></script>
    <script src="system/scripts/config.lazyload.js"></script>
    <script src="system/scripts/ui-load.js?v={{ time() }}"></script>
    <script src="system/scripts/ui-jp.js"></script>
    <script src="system/scripts/ui-include.js"></script>
    <script src="system/scripts/ui-device.js"></script>
    <script src="system/scripts/ui-form.js"></script>
    <script src="system/scripts/ui-modal.js"></script>
    <script src="system/scripts/ui-nav.js"></script>
    <script src="system/scripts/ui-list.js"></script>
    <script src="system/scripts/ui-screenfull.js?v={{ time() }}"></script>
    <script src="system/scripts/ui-scroll-to.js"></script>
    <script src="system/scripts/ui-toggle-class.js"></script>
    <script src="system/scripts/ui-taburl.js"></script>
    <script src="system/scripts/app.js?v={{ time() }}"></script>
    <script src="system/scripts/ajax.js?v={{ time() }}"></script>
    <!-- countdown -->
    <script src="system/libs/jquery/dist/flipper-responsive.js?v={{ time() }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js"></script>
<script>
		@if($noti_image->count() > 0)
			$(document).ready(function () {
				$('#myModal').css("display", "block");
				$('#myModal').addClass('active-modal');
			});
			$(".close").click(function(){
				 $('#myModal').css("display", "none");
			});
			$(window).click(function(e){
				console.log($('#myModal').hasClass('active-modal'));
				if($('#myModal').hasClass('active-modal') == true){
					$('#myModal').css("display", "none");
				}
			});
		@endif
</script>
<script src='https://www.google.com/recaptcha/api.js?hl=us'></script>
    <script>

        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
            toastr.error('{{$error}}', 'Error!', {timeOut: 3500});
            @endforeach
        @endif
        @if(Session::get('flash_level') == 'success')
            toastr.success('{{ Session::get('flash_message') }}', 'Success!', {timeOut: 3500});
        @elseif(Session::get('flash_level') == 'error')
            toastr.error('{{ Session::get('flash_message') }}', 'Error!', {timeOut: 3500});
        @endif

        $('#sign-in-form').submit(function(e) {
            rcres = grecaptcha.getResponse();
            if (!rcres.length) {
                toastr.error("Please check capchar field!", 'Error!', {timeOut: 3500});
                e.preventDefault();
            }
        });
        $(document).ready(function() {
                @if(Session::has('otp'))
            var CSRF_TOKEN = '{{ csrf_token() }}';
            swal.fire({
                title: 'Enter Authentication',
                text: 'Please enter authentication code.',
                input: 'text',
                type: 'input',
                name: 'txtOTP',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Submit',
                showLoaderOnConfirm: true,
                confirmButtonClass: 'btn btn-confirm',
                cancelButtonClass: 'btn btn-cancel'
            }).then(function (confirm) {
	            otp = confirm.value;
                $.ajax({
                    url: "{{route('system.user.postLoginCheckOTP')}}",
                    type: 'GET',
                    data: {_token: CSRF_TOKEN, otp:otp},
                    success: function (data) {
                        if(data == 1){
                            location.href = "{{route('system.dashboard')}}";
                        }else{
                            swal.fire({
                                title: 'Error',
                                text: "Authentication Code Is Wrong",
                                type: 'error',
                                confirmButtonClass: 'btn btn-confirm',
                                allowOutsideClick: false
                            }).then(function() {
                                location.href = "{{route('getLogin')}}";
                            })
                        }
                    }
                });
            });
            @endif
        });

    </script>
</body>
</html>
