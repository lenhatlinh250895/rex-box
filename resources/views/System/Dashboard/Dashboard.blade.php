
@extends('System.Layouts.Master')
@section('title')
Dashboard
@endsection
@section('css')
<link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css" />
@endsection
@section('content')
        
        <div class="app-body">
          <!-- ############ PAGE START-->
          <div class="row-col">
            <div class="col-lg b-r">
              <div class="padding padding-big">
                <div class="row">
	                @include('System.Layouts.Balance')
<!--
                    <div class="col-lg-12 col-xl-12">
                      <div class="row">
                        <div class="col-sm-12 col-md-6 ">
                          <div class="box">
                            <div class="item">
                              <div class="item-bg light h6">
                                </div>
                                    <div class="p-a p-t-sm pos-rlt">
                                    <img src="system/images/icon/redbox.png" alt="." class="w-64" style="margin-bottom: -3.2rem">
                                </div>
                            </div>
                            <div class="p-a-md bg-logo">
                              <div class="m-t">
                                  <table class="table m-a-0 table-box">
                                    <tbody>
                                      <tr class="border-bt">
                                        <td class="text-danger item-title">RBD</td>
                                        <td>$ {{$balance->RBD+0}}</td>
                                      </tr>
                                      <tr>
                                        <td>$ {{$rate['RBD']+0}}</td>
                                        <td class="text-danger item-title"><button class="btn btn-info btn-rounded" data-id="2">Coming Soon</button></td>
                                      </tr>
                                    </tbody>
                                  </table>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                          <div class="box">
                            <div class="item">
                              <div class="item-bg light h6">
                                </div>
                                    <div class="p-a p-t-sm pos-rlt">
                                    <img src="system/images/icon/usd.png" alt="." class="w-64" style="margin-bottom: -3.2rem">
                                </div>
                            </div>
                            <div class="p-a-md bg-logo">
                              <div class="m-t">
                                  <table class="table m-a-0 table-box">
                                    <tbody>
                                      <tr class="border-bt">
                                        <td class="text-warn item-title">USD</td>
                                        <td>$ {{$balance->USD+0}}</td>
                                      </tr>
                                      <tr>
                                        <td>$ 1</td>
                                        <td class="text-warn item-title"><button class="btn btn-info btn-rounded deposit" data-id="2">Deposit ETH</button></td>
                                      </tr>
                                    </tbody>
                                  </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
-->

                    <div class="col-lg-12 col-xl-12">
                      <div class="row">
                         <div class="col-sm-12">
                          <div class="box">
                            <div class="box-header">
                              <h3><i class="fa fa-usd"></i> Price</h3>
                            </div>
                            <div class="box-body bg-logo">
                              <div data-ui-jp="echarts" data-ui-options="{
                                  tooltip : {
                                      trigger: 'axis'
                                  },
                                  legend: {
                                      data:['RBD']
                                  },
                                  calculable : true,
                                  xAxis : [
                                      {
                                          type : 'category',
                                          boundaryGap : false,
                                          data : {!! str_replace('"','\'', json_encode($chartPrice['xAxis'])) !!}
                                      }
                                  ],
                                  yAxis : [
                                      {
                                          type : 'value'
                                      }
                                  ],
                                  series : [
                                      {
                                          name:'Deal',
                                          type:'line',
                                          smooth:true,
                                          itemStyle: {normal: {areaStyle: {type: 'default'}}},
                                          data:{!! str_replace('"','\'', json_encode($chartPrice['series'])) !!}
                                      }
                                  ]
                                      
                              }" style="height:360px" >
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
                              <h2><i class="fa fa-history"></i> History</h2>
                            </div>
                            <div class="pull-right">
<!--                               <h2>Total: <span class="text-white text-bold">$ 123456789</span></h2> -->
                            </div>
                          </div>
                          <div class="box-body bg-logo">
                            <div class="p-a-sm">
                                Search: <input id="filter" type="text" class="form-control input-sm w-auto inline m-r"/>
                            </div>
                            <div>
                              <table class="table m-b-none" data-ui-jp="footable" data-filter="#filter" data-page-size="10">
			                    <thead>
			                      <tr>
			                        <th data-toggle="true">
			                          ID
			                        </th>
			                        <th>
			                          DEPOSIT AMOUNT
			                        </th>
			                        <th data-hide="phone,tablet">
			                          MONEY ACTION
			                        </th>
			                        <th data-hide="phone">
			                          FEE
			                        </th>
			                        <th data-hide="phone">
			                          EXCHANGE RATE
			                        </th>
			                        <th data-hide="phone">
			                          COMMENT
			                        </th>
			                      </tr>
			                    </thead>
			                    <tbody>
			                    @foreach($history as $item)
			                        <tr>
			                            <td>{{$item['Money_ID']}}</td>
			                            <td>{{number_format($item['Money_USDT'], 2)}}</td>
			                            <td>{{$item['MoneyAction_Name']}}</td>
			                            <td>{{number_format($item['Money_USDTFee'], 2)}}</td>
			                            <td>{{number_format($item['Money_Rate'], 4)}}</td>
			                            <td>{{date('Y-m-d H:i:s', $item['Money_Time'])}}</td>
			                            <td>{{$item['Money_Comment']}}</td>
			                        </tr>
			                    @endforeach
			                    </tbody>
			                    <tfoot class="hide-if-no-paging">
			                    <tr>
			                      <td colspan="7" class="text-center"><ul class="pagination"></ul></td>
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
@endsection
@section('script')
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
<script>
$(document).ready(function () {
    
    $('.deposit').click(function(){
        _coin = $(this).attr('data-id');
        getAddress(_coin);
    });
    
    
    function getAddress(_coin){
	    $.getJSON( "{{ route('system.json.getAddress') }}?coin="+_coin, function( data ) {
	        Swal.fire({
	            titleText: "Deposit "+data['name'],
	            html: '<div class="pay--attention">PLEASE COPY WALLET ADDRESS OR SCAN QR CODE AND THEN WAITING THE SYSTEM PROCESS YOUR REQUEST...</div>'+
	                    '<div class="send--to">Send to address:</div>'+
	                    
	                    '<div class="the--address"><b style="font-weight: 900;">'+data['address']+'</b></div>'+
	                    '<br>'+
	                    '<img src="'+data['Qr']+'" style="width: 90%;"></img>'
	        })
	        
		    $('#inputAddress').val(data['address']);
		    $('#ImageQr').html('<img src="'+data['Qr']+'" style="margin: 0 auto;"/>');
		});
    }
    
});
</script>
@endsection