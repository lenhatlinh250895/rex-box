@extends('System.Layouts.Master')
@section('title')
Up Notification
@endsection
@section('css')
<meta name="_token" content="{!! csrf_token() !!}" />

<!--THIS PAGE LEVEL CSS-->
<link href="datetime/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
    rel="stylesheet" />
<link href="datetime/plugins/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css" rel="stylesheet" />
<link href="datetime/plugins/boootstrap-datepicker/bootstrap-datepicker3.min.css" rel="stylesheet" />
<link href="datetime/plugins/bootstrap-timepicker/css/bootstrap-timepicker.css" rel="stylesheet" />
<link href="datetime/plugins/bootstrap-daterange/daterangepicker.css" rel="stylesheet" />
<link href="datetime/plugins/clockface/css/clockface.css" rel="stylesheet" />
<link href="datetime/plugins/clockpicker/clockpicker.css" rel="stylesheet" />
<!--REQUIRED THEME CSS -->
<link href="datetime/assets/css/themes/main_theme.css" rel="stylesheet" />
<style>
    .dtp-btn-cancel {
        background: #9E9E9E;
    }

    .dtp-btn-ok {
        background: #009688;
    }
    .form-check-input{
	    margin-left: 0px;
    }
</style>
@endsection
@section('content')

<div class="app-body">
  <!-- ############ PAGE START-->
  	<div class="row-col">
    	<div class="col-lg b-r">
			<div class="padding padding-big">
				<div class="col-md-12">
				    <div class="row">
				        <div class="box m-b-30">
				            <div class="box-header">
				                <div class="mt-0 text-white">Up Notification</div>
				            </div>
				            <div class="box-body bg-logo">
				                <form method="post" action="{{ route('system.admin.postImage') }}" enctype="multipart/form-data">
					                @csrf
				                    <div class="panel-body">
				                        <div class="row">	                            
				                        	<div class="col-md-12">
					                            <div class="row">
				                                <!-- form -->
					                                <div class="col-md-6 col-lg-12">
						                                <div class="form-group">
					                                    	<label for="">Image</label>
															<input type="file" name="notiImage" class="form-control" placeholder="Enter image">
														</div>
					                                </div>
					                                <div class="col-md-6 col-lg-4">
						                                <div class="form-group">
							                                <div class="form-check">
															    <input type="checkbox" name="checkLanding" value="1" class="form-check-input" id="inlineCheckbox1">
															    <label class="form-check-label" for="inlineCheckbox1">Landing page</label>
															</div>
						                                </div>
					                                </div>
					                                <div class="col-md-6 col-lg-4">
						                                <div class="form-group">
							                                
							                                <div class="form-check">
															    <input type="checkbox" name="checkSystem" value="1" class="form-check-input" id="inlineCheckbox2">
															    <label class="form-check-label" for="inlineCheckbox2">Login system</label>
															</div>
						                                </div>
					                                </div>				
					                                <div class="col-md-6 col-lg-4">
						                                <div class="form-group">
							                                <div class="form-check">
															    <input type="checkbox" name="checkExchange" value="1" class="form-check-input" id="inlineCheckbox3">
															    <label class="form-check-label" for="inlineCheckbox3">Dashboard </label>
															</div>
						                                </div>
				
					                                </div>
					                                <div class="col-md-12 text-right">
						                                <button type="submit" class="btn btn-primary info"><i class="fa fa-save" aria-hidden="true"></i>
					                                        Save</button>
					                                </div>
					                            </div>
				                            </div>
				                        </div>
				                        <!-- end form -->
				
				                    </div>
				                </form>
				            </div>
				        </div>
				    </div>
				<div class="row">
				    <div class="box">
				        <div class= "m-b-30">
				            <div class="box-header">
				                <div class="mt-0 text-white">List Images Notification</div>
				            </div>
				            <div class="box-body bg-logo">
				                <div class="table-responsive">
				                    <table class="table table-hover">
				                        <thead>
				                            <tr>
				                                <th data-toggle="true">
				                                    #
				                                </th>
				                                <th>
				                                    Image
				                                </th>
				                                <th>
				                                    Landing
				                                </th>
				                                <th>
				                                    System
				                                </th>
				                                <th>
				                                    Exchang
				                                </th>
				                                <th>
				                                    Action
				                                </th>
				                            </tr>
				                        </thead>
				                        <tbody> 
						         			@foreach($notiImage as $noti)                           
					                        <tr>
				                            	<td>{{$noti->ID}}</td>
				                            	<td>
					                            	<img src="https://redboxdapp.com/public/app/public/{{$noti->Url}}" width="50">
				                            	</td>
				                            	<td>
					                            	@if($noti->Location_Login == 1)
					                            	<span class="badge badge-success">YES</span> 
					                            	@else
					                            	<span class="badge badge-danger">No</span>
					                            	@endif
				                            	</td>
				                            	<td>
					                            	@if($noti->Location_System == 1)
					                            	<span class="badge badge-success">YES</span> 
					                            	@else
					                            	<span class="badge badge-danger">No</span>
					                            	@endif
				                            	</td>
				                            	<td>
					                            	@if($noti->Location_Exchange == 1)
					                            	<span class="badge badge-success">YES</span> 
					                            	@else
					                            	<span class="badge badge-danger">No</span>
					                            	@endif
				                            	</td>
				                            	
				                            	<td>
				                            		@if($noti->Status == 0)
					                            		<a type="button" href="{{ route('system.admin.getHideNoti', $noti->ID) }}"
				                                        	class="btnDelete btn btn-rounded btn-noborder btn-danger min-width-125 mt-2"
																data-id="{{ $noti->ID }}"
																	data-status="{{ $noti->Status }}">Hide notification</a> 
				                                    @else($noti->Status == 1)
				                                    	<a type="button" href="{{ route('system.admin.getHideNoti', $noti->ID) }}"
				                                        	class="btnDelete btn btn-rounded btn-noborder btn-success min-width-125 mt-2"
																data-id="{{ $noti->ID }}"
																	data-status="{{ $noti->Status }}">Turn on notification</a> 
													@endif
													<a type="button" href="{{ route('system.admin.getDeleteNoti', $noti->ID) }}"
				                                        	class="btnDelete btn btn-rounded btn-noborder btn-danger min-width-125 mt-2"
																data-id="{{ $noti->ID }}"
																	data-status="{{ $noti->Status }}">Delete</a> 
				                                </td>
				                            </tr>
				                            @endforeach
				                        </tbody>
				                    </table>
				                </div>
				            </div>
				        </div>
				    </div>
				</div>
			</div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script src="datetime/plugins/momentjs/moment.js"></script>
<script src="datetime/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js">
</script>
<script src="datetime/plugins/boootstrap-datepicker/bootstrap-datepicker.min.js">
</script>
<script src="datetime/plugins/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js">
</script>
<script src="datetime/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js">
</script>
<script src="datetime/plugins/bootstrap-daterange/daterangepicker.js"></script>
<script src="datetime/plugins/clockface/js/clockface.js"></script>
<script src="datetime/plugins/clockpicker/clockpicker.js"></script>

<script src="datetime/assets/js/pages/forms/date-time-picker-custom.js"></script>


<script>
    $('#datefrom').bootstrapMaterialDatePicker({ format : 'YYYY/MM/DD', clearButton: true, time: false });
    $('#dateto').bootstrapMaterialDatePicker({ format : 'YYYY/MM/DD', clearButton: true, time: false });
</script>
@endsection