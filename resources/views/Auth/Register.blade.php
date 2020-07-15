<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Redbox</title>
    <meta name="description" content="Responsive, Bootstrap, BS4" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    <link rel="stylesheet" href="system/css/animate/animate.min.css" type="text/css" />
    <link rel="stylesheet" href="system/css/glyphicons/glyphicons.css" type="text/css" />
    <link rel="stylesheet" href="system/css/font-awesome/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="system/css/material-design-icons/material-design-icons.css" type="text/css" />
    <link rel="stylesheet" href="system/css/ionicons/css/ionicons.min.css" type="text/css" />
    <link rel="stylesheet" href="system/css/simple-line-icons/css/simple-line-icons.css" type="text/css" />
    <link rel="stylesheet" href="system/css/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
    <!-- build:css css/styles/app.min.css -->
    <link rel="stylesheet" href="system/css/styles/app.css?v={{ time() }}" type="text/css" />
    <link rel="stylesheet" href="system/css/styles/style.css" type="text/css" />
    <!-- endbuild -->
    <link rel="stylesheet" href="system/css/styles/font.css" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
	
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

                    <form name="form" method="POST" action="{{route('postRegister')}}">
                        @csrf

                        <div class="form-group">
                            <input type="email" name="Email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="Password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="Re-Password" class="form-control"
                                placeholder="Password Confirmation" required>
                        </div>
                        <div class="form-group">
                            <input placeholder="Sponsor" type="text" class="form-control" name="parent"
                                value="{{request()->input('ref')}}" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <input placeholder="Presenter" type="text" name="presenter" class="form-control"
                                value="{{request()->input('presenter')}}" autocomplete="off" />
                        </div>
                        {{-- <div class="form-group">
                            <input type="text" name="sponser" class="form-control" placeholder="Sponser" id="sponser-id" required>
                        </div> --}}
                        <button type="submit" class="btn btn-lg black p-x-lg">Sign Up</button>
                    </form>
                    <div class="p-y-lg text-center">
                        <div>Already have an account? <a href="{{route('getLogin')}}" class="text-primary _600">Sign
                                in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ############ LAYOUT END-->
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

        _linkRef = {{request()->input('ref') ? request()->input('ref') : 0}};
        if(_linkRef !== 0){
            $('#sponser-id').val(_linkRef);
        }

    </script>

</body>

</html>