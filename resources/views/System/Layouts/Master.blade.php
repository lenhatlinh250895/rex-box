<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Redbox - @yield('title')</title>
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
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css">
        @section('css')
        @show
    </head>
    <body class="black pace-done" ui-class="black">
        <div class="app" id="app">
            @include('System.Layouts.NavLeft')

            @section('content')
            @show

        </div>

        <script src="system/libs/jquery/dist/jquery.js"></script>
        <script src="system/libs/jquery/dist/canvasBG.js?v={{ time() }}"></script>
        <!-- Bootstrap -->
        <script src="system/libs/tether/dist/js/tether.min.js"></script>
        <script src="system/libs/bootstrap/dist/js/bootstrap.js"></script>
        <!-- core -->
        <script src="system/libs/jQuery-Storage-API/jquery.storageapi.min.js"></script>
{{--        <script src="system/libs/PACE/pace.min.js"></script>--}}
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
        <script>
		    var gettimeCur = '{{ date('Y-m-d H:i:s') }}';
		    //var Xdate = new Date(gettimeCur.replace(' ', 'T'));
		    //console.log(Xdate);
		    
		    var dateCac = new Date(gettimeCur);
		    if(Number.isNaN(dateCac.getMonth())) {
		      var arr = gettimeCur.split(/[- :]/);
		      dateCac = new Date(arr[0], arr[1]-1, arr[2], arr[3], arr[4], arr[5]);
		    }
			function calcTime(city, offset) {
			    
			    var n = dateCac.valueOf();
			    n+=1000;
			    dateCac = new Date(n);
			    // date.getSeconds(date.getSeconds()+1);
			    return dateCac;
			
			}
        </script>
        <script src="system/libs/jquery/dist/flipper-responsive.js?v={{ time() }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
        <script>
			
            jQuery(function ($) {
                $('#myFlipper').flipper('init');
                $('#modalFlipper').flipper('init');
            });
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
			$('form').on('submit', function () {
				$("form button").attr("disabled", true);
			});
        </script>

        @section('script')
        @show
    </body>
</html>
