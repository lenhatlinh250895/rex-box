@extends('System.Layouts.Master')
@section('title')
Trade ITO
@endsection
@section('css')
<link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css" />
<style>
.padding {
    padding: 1.5rem 1rem;
}
</style>
@endsection
@section('content')
<div class="app-body">
  <div class="padding padding-big">
    <div class="row">
      {{--<div class="col-md-6 offset-md-3">
        <div class="box">
          <div class="box-header">
            <h2><i class="fa fa-clock-o" aria-hidden="true"></i> Countdown To Open Selling</h2>
          </div>
          <div class="box-divider m-a-0"></div>
          <div class="box-body bg-logo">
            <h5 class="text-center text-light">The second day of sale: {{date('F jS, Y H:i:s', strtotime($endDate))}} / UTC</h5>
            <div class="padding">
              <div class="flipper" data-reverse="true" data-datetime="{{$endDate}}" data-template="dd|HH|ii|ss" data-labels="Days|Hours|Minutes|Seconds" id="myFlipper"></div>
            </div>
          </div>
        </div>
      </div>--}}
      
        @include('System.Layouts.Balance')
      <div class="col-md-6 offset-md-3">
        <div class="box">
          <div class="box-header">
            <div class="pull-left">
              <h2><i class="fa fa-usd" aria-hidden="true"></i> Buy Token</h2>
            </div>
            <div class="pull-right">
              <h2>$ 0.00 </h2>
            </div>
            <h2 class="text-center text-warning">TOTAL BOUGHT: {{$getBalanceRBD+0}} RBD</h2>
          </div>
          <div class="box-divider m-a-0"></div>
          <div class="box-body bg-logo">
	        <form method="post" action="{{route('system.postTradeBuy')}}" id="form-trade">
            <div class="row m-b p-a">
              <label for="single-prepend-text">Price</label>
              <div class="input-group m-b">
                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                <input type="text" class="form-control" value="{{$rate['RBD']}}" placeholder="Username">
              </div>
              <div class="form-group">
                <label>Amount</label>
                <input type="number" step="any" class="form-control" placeholder="Amount USD" id="amountUSD" name="amount" required>
              </div>
              <div class="form-group text-center">
                <button type="button" class="btn btn-sm btn-success range-button" value="100">Min</button>
                <button type="button" class="btn btn-sm btn-primary range-button" value="{{$balance->USD}}">Max</button>
              </div>
              <div class="form-group">
                <label>Amount Token</label>
                <input type="number" step="any" class="form-control" placeholder="Amount Token" id="amountRBD" name="amountRBD" required="">
              </div>
              <div class="form-group">
                <label style="color:red">Fee 0%</label>
                <input type="number" step="any" class="form-control" placeholder="Amount Fee Token" id="amountFeeRBD" name="amountFeeRBD" required="" readonly="">
              </div>
              	@if($checkCurrent == 1)
	            <div class="form-group mx-auto">
		            <center>
		            {{--Mở lại khi mở bán--}}
					<div class="g-recaptcha captcha" style="display:none;" data-sitekey="6LfOtccUAAAAAD68tDwXAvaRMJRswxM8VGGw1zn3" data-callback="enableBtn" id="captcha_buy"></div>
		            </center>
	            </div>
	            @endif
              <div class="text-center">
                <button type="submit" id="buy_btn" class="btn btn-outline info"><i class="fa fa-send-o" aria-hidden="true"></i> Buy Token</button>
              </div>
            </div>
            @csrf
            </form>
            </div>
          </div>
        </div>
      @if(Session('user')->User_Level != 1)
      @elseif(Session('user')->User_Level == 1)
      @endif
      <div class="col-md-6 offset-md-3">
        <div class="box">
          <div class="box-header">
            <div class="pull-left">
              <h2><i class="fa fa-usd" aria-hidden="true"></i> Sell Token</h2>
            </div>
            <div class="pull-right">
              <h2>{{$balance->RBD+0}} RBD</h2>
            </div>
            <h2 class="text-center text-warning">TOTAL BOUGHT: {{$getBalanceRBD+0}} RBD</h2>
          </div>
          <div class="box-divider m-a-0"></div>
          <div class="box-body bg-logo">
	        <form method="post" action="{{route('system.postTradeSell')}}" id="form-trade-sell">
            <div class="row m-b p-a">
              <label for="single-prepend-text">Price</label>
              <div class="input-group m-b">
                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                <input type="text" class="form-control" value="{{$rate['RBD']}}" placeholder="Username">
              </div>
              <div class="form-group">
                <label>Amount Token</label>
                <input type="number" step="any" class="form-control" placeholder="Amount Token" id="amountRBD_sell" name="amountRBD" required="">
              </div>
              <div class="form-group text-center">
                <button type="button" class="btn btn-sm btn-success range_button_sell" value="1000">Min</button>
                <button type="button" class="btn btn-sm btn-primary range_button_sell" value="{{$balance->RBD}}">Max</button>
              </div>
              <div class="form-group">
                <label>Amount USD</label>
                <input type="number" step="any" class="form-control" placeholder="Amount USD" id="amountUSD_sell" name="amount" required>
              </div>
              <div class="form-group">
                <label style="color:red">Fee 5%</label>
                <input type="number" step="any" class="form-control" placeholder="Amount Fee Token" id="amountFeeRBD_sell" name="amountFeeRBD" required="" readonly="">
              </div>
              
              	@if($checkCurrent != 1)
	            <div class="form-group mx-auto">
		            <center>
	            	<div class="g-recaptcha captcha-sell" style="display:none;" data-sitekey="6LfOtccUAAAAAD68tDwXAvaRMJRswxM8VGGw1zn3" data-callback="enableBtn" id="captcha_sell"></div>
		            </center>
	            </div>
	            @endif
              <div class="text-center">
                <button type="submit" id="buy_btn_sell" class="btn btn-outline info"><i class="fa fa-send-o" aria-hidden="true"></i> Sell Token</button>
              </div>
            </div>
            @csrf
            </form>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>

<div class="modal" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content" style="background-color: #fa0b0b;">
			<div class="modal-body" style="padding: 0">
				<button type="button" class="close" data-dismiss="modal" style="padding-right: 10px;text-align: right;color:#fff;opacity:1">&times;</button>
				
				<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
						<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					</ol>
					<div class="carousel-inner">
						<div class="carousel-item active">
							<img src="page/project/Close ITO - NOTIFICATION (1).jpg" width="100%"> 
						</div>
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
<script src='https://www.google.com/recaptcha/api.js?hl=us'></script>
<script>
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

	function enableBtn(){
		$('#buy_btn').attr("disabled", false);
		$('#buy_btn_sell').attr("disabled", false);
		_checkCaptcha = 1;
	}
//     if({{$checkCurrent}} == 1){
		$('#buy_btn').attr("disabled", false);
// 	}else{
// 		$('#buy_btn').attr("disabled", true);
// 	}
	_checkCaptcha = 0;
	_checkButtonBuy = 0;
	
    $('#form-trade').one('submit', function(e) {
	    _form = $(this);
        rcres = grecaptcha.getResponse();
        if (!rcres.length) {
            toastr.error("Please check capchar field!", 'Error!', {timeOut: 3500});
            e.preventDefault();
        }else{
	        e.preventDefault();
	        swal.fire({
	            title: 'Confirm Buy Token',
	            text: 'Are You Sure ?',
	            type: 'warning',
	            showCancelButton: true,
	            confirmButtonText: 'Submit',
	            showLoaderOnConfirm: true,
	            confirmButtonClass: 'btn btn-confirm',
	            cancelButtonClass: 'btn btn-cancel'
	        }).then(function (confirm) {
		        if(confirm.value){
			       _form.submit();
		        }
	        });

        }
    });
    
	$('#buy_btn').click(function(){
		$('.captcha').show();
		if(_checkButtonBuy == 0){
			$('#buy_btn').attr("disabled", true);
		}
		_checkButtonBuy = 1;

	});
	
	$('.range-button').click(function(){
		_amount = $(this).val();
		_currency = parseInt($('.CoinType').val());
		$('#amountUSD').val(_amount);
		$('#amountRBD').val(_amount/$rateToken);
	});
	
	$temp_rate = 1;
	$nameCoin = 'USD';
	$rateToken = {{$rate['RBD']}};
	$(document).ready(function() {
		_maxCoin = 200000;
		$('#BuyONZ').submit(function(){
			$('#transfer').attr('disabled', true);
			return true;
		});

		$('#amountUSD').keyup(function(){
			$amount = $(this).val();
			$temp_rate = 0;
			$nameCoin = null;
			$RateOnizTo = 0;
			$result = $amount / $rateToken;
			$('#amountRBD').val($result);
			$('#amountFeeRBD').val($result*0.00);
		});
		
		$('#amountRBD').keyup(function(){
			$amount = $(this).val();
			$nameCoin = null;
			$result = 0;
			$result = $amount * $rateToken;
			$('#amountUSD').val($result);
			$('#amountFeeRBD').val($amount*0.00);
		});
	});
	@if(Session('user')->User_Level == 1)
	@endif
	//SELL TOKEN
    $('#form-trade-sell').one('submit', function(e) {
	    _form = $(this);
        rcres = grecaptcha.getResponse();
        if (!rcres.length) {
            toastr.error("Please check capchar field!", 'Error!', {timeOut: 3500});
            e.preventDefault();
        }else{
	        e.preventDefault();
	        swal.fire({
	            title: 'Confirm Sell Token',
	            text: 'Are You Sure ?',
	            type: 'warning',
	            showCancelButton: true,
	            confirmButtonText: 'Submit',
	            showLoaderOnConfirm: true,
	            confirmButtonClass: 'btn btn-confirm',
	            cancelButtonClass: 'btn btn-cancel'
	        }).then(function (confirm) {
		        if(confirm.value){
			       _form.submit();
		        }
	        });

        }
    });
    
	$('#buy_btn_sell').click(function(){
		$('.captcha-sell').show();
		if(_checkButtonBuy == 0){
			$('#buy_btn_sell').attr("disabled", true);
		}
		_checkButtonBuy = 1;

	});
	
	$('.range_button_sell').click(function(){
		_amount = $(this).val();
		_currency = parseInt($('.CoinType').val());
		$('#amountUSD_sell').val(_amount*$rateToken);
		$('#amountRBD_sell').val(_amount);
		$('#amountFeeRBD_sell').val(_amount*0.05);
	});
	
	$temp_rate = 1;
	$nameCoin = 'USD';
	$rateToken = {{$rate['RBD']}};
	$(document).ready(function() {
		_maxCoin = 200000;
		$('#BuyONZ').submit(function(){
			$('#transfer').attr('disabled', true);
			return true;
		});

		$('#amountUSD_sell').keyup(function(){
			$amount = $(this).val();
			$temp_rate = 0;
			$nameCoin = null;
			$RateOnizTo = 0;
			$result = $amount / $rateToken;
			$('#amountRBD_sell').val($result);
			$('#amountFeeRBD_sell').val($result*0.05);
		});
		
		$('#amountRBD_sell').keyup(function(){
			$amount = $(this).val();
			$nameCoin = null;
			$result = 0;
			$result = $amount * $rateToken;
			$('#amountUSD_sell').val($result);
			$('#amountFeeRBD_sell').val($amount*0.05);
		});
	});
</script>
@endsection