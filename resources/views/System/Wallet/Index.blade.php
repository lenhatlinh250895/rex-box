@extends('System.Layouts.Master')
@section('title')
Wallet
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
                    <div class="col-md-6 m-auto">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="box">
                                    <div class="box-header">
                                        <h2><i class="fa fa-send-o" aria-hidden="true"></i> Withdrawal</h2>
                                    </div>
                                    <div class="box-divider m-a-0"></div>
                                    <form method="post" action="{{route('system.postWithdraw')}}" id="form-withdraw">
                                        @csrf
                                        <div class="box-body bg-logo">
                                            <div class="row m-b p-a">
                                                <div class="form-group">
                                                    <label for="single-prepend-text">Currency</label>
                                                    <div class="input-group select2-bootstrap-prepend">
                                                        <span class="input-group-btn">
                                      <button class="btn btn-default" type="button" data-select2-open="single-prepend-text">
                                        <span class="fa fa-usd"></span>
                                                        </button>
                                                        </span>
                                                        <select style="color:white!important;" id="single-prepend-text" name="coin" class="form-control select2" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}">
                                                            <option value="8">REDBOX</option>
                                                            <option value="2">ETH</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <label for="single-prepend-text">Address Wallet</label>
                                                <div class="input-group m-b">
                                                    <span class="input-group-addon"><i class="fa fa-google-wallet"></i></span>
                                                    <input type="text" class="form-control" name="address" placeholder="Wallet Address" value="{{Session('user')->User_WalletAddress}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Amount USD<span class="text-warning"> Maximum <span class="maximum">{{$balance->RBD+0}} RBD</span></span>
                                                    </label>
                                                    <input type="number" step="any" id="amount-usd" name="amount" class="form-control" placeholder="Amount" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Fee( <span class="fee_withdraw">0.3%</span> )</label>
                                                    <input type="number" step="any" id="amount-fee" readonly="" class="form-control" placeholder="Amount">
                                                </div>

                                                <label for="single-prepend-text">Authentication Code</label>
                                                <div class="input-group m-b">
                                                    <span class="input-group-addon"><i class="fa fa-google"></i></span>
                                                    <input type="text" name="otp" class="form-control" placeholder="Google Authenticator">
                                                </div>
                                                <div class="text-center">
                                                    <button class="btn btn-outline info btn-withdraw-submit" type="button" disabled="true"><i class="fa fa-send-o" aria-hidden="true"></i> Withdraw</button>
                                                </div>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="box">
                                    <div class="box-header">
                                        <h2><i class="fa fa-send-o" aria-hidden="true"></i> Transfer</h2>
                                    </div>
                                    <div class="box-divider m-a-0"></div>
                                    <form method="post" action="{{route('system.postTransfer')}}" id="form-transfer">
                                        @csrf
                                        <div class="box-body bg-logo">
                                            <div class="row m-b p-a">
                                                <div class="form-group">
                                                    <label for="single-prepend-text">Currency</label>
                                                    <div class="input-group select2-bootstrap-prepend">
                                                        <span class="input-group-btn">
                                      <button class="btn btn-default" type="button" data-select2-open="single-prepend-text">
                                        <span class="fa fa-usd"></span>
                                                        </button>
                                                        </span>
                                                        <select style="color:white!important;" id="single-prepend-text" name="currency" class="currency_withdraw form-control select2" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}">
                                                            <option value="8">REDBOX</option>
                                                           <!-- <option value="5">USD</option>-->
                                                        </select>
                                                    </div>
                                                </div>
                                                <label for="single-prepend-text">User ID</label>
                                                <div class="input-group m-b">
                                                    <span class="input-group-addon"><i class="fa fa-google-wallet"></i></span>
                                                    <input type="text" class="form-control" name="userID" placeholder="Enter User ID" value="">
                                                </div>
                                                <div class="form-group">
                                                    <label>Amount</label>
                                                    <input type="number" step="any" name="amount" class="form-control" placeholder="Amount" required>
                                                </div>
                                                {{--<div class="form-group">
                                                    <label>Fee( 0.3% )</label>
                                                    <input type="number" step="any" id="amount-fee" readonly="" class="form-control" placeholder="Amount">
                                                </div>--}}

                                                <label for="single-prepend-text">Authentication Code</label>
                                                <div class="input-group m-b">
                                                    <span class="input-group-addon"><i class="fa fa-google"></i></span>
                                                    <input type="text" name="otp" class="form-control" placeholder="Google Authenticator">
                                                </div>
                                                <div class="text-center">
                                                    <button class="btn btn-outline info btn-transfer-submit" type="button" ><i class="fa fa-send-o" aria-hidden="true"></i> Tranfer</button>
                                                </div>
                                                <div class="form-group" style="opacity: 0;">
                                                    <label>Fee( 0.3% )</label>
                                                    <input type="hidden">
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h2><i class="fa fa-history"></i> History</h2>
                        </div>
                        <div class="box-body bg-logo">
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
                                                Date Time
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
                                            <td>{{number_format($item['Money_Rate'], 3)}}</td>
                                            <td>{{date('Y-m-d H:i:s', $item['Money_Time'])}}</td>
                                            <td>{{$item['Money_Comment']}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="hide-if-no-paging">
                                        <tr>
                                            <td colspan="7" class="text-center">
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
    <!-- ############ PAGE END-->
</div>
@endsection
@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js"></script>
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
    _amount = 0;
    _balance = {2:{{$balance->USD}},8:{{$balance->RBD}}};
    _coin = 8;
    _fee = 0;
    $('#single-prepend-text').change(function(){
	    _coin = $(this).val();
	    console.log(_coin);
	    let amount_change = 0;
        if(_coin==2){
            amount_change = $('#amount-usd').val() * 0.1;
		    $('.maximum').html('$'+_balance[_coin]);
	    }else{
            amount_change = $('#amount-usd').val() * 0.05;
		    $('.maximum').html(_balance[_coin]+' RBD');
	    }
        $('#amount-fee').val(amount_change);
        changeFee(_coin);
    });
    $('#amount-usd').keyup(function(){
	    _amount = parseInt($(this).val());
        _get_curency_withdraw = $('#single-prepend-text').val();
        if(_get_curency_withdraw == 8){
            _fee = _amount*0.05;
        }
	    else{
            _fee = _amount*0.1;
        }
	    $('#amount-fee').val(_fee);
    });
    changeFee($('#single-prepend-text').val());
    function changeFee(currency){
        if(currency == 8){
            $('.fee_withdraw').html('5%');
        }
	    else{
            $('.fee_withdraw').html('10%');
        }
    }

    $('#amount-usd').blur(function(){
	    if(_amount > _balance[_coin]){
		    $('.btn-withdraw-submit').prop('disabled', true);
		    toastr.error('Your Balance Isn\t Enough', 'Error!', {timeOut: 3500});
	    }else{
		    $('.btn-withdraw-submit').prop('disabled', false);
	    }
    });
    
    $('.btn-withdraw-submit').click(function(){

		swal.fire({
		    title: 'Confirm Withdrawal',
		    text: 'Are You Sure Withdraw $'+_amount+' ?',
		    type: 'warning',
		    showCancelButton: true,
		    confirmButtonText: 'Submit',
		    confirmButtonClass: 'btn btn-confirm',
		    cancelButtonClass: 'btn btn-cancel'
		}).then(function (confirm) {
			console.log(confirm);
		    if(confirm.value == true){
			    $('#form-withdraw').attr('action', '{{route('system.postWithdraw')}}');
			    $('#form-withdraw').submit();
		    }
		});  
    });
    
    $('.btn-transfer-submit').click(function(){
		
		swal.fire({
		    title: 'Confirm Transfer',
		    text: 'Are You Sure Transfer ?',
		    type: 'warning',
		    showCancelButton: true,
		    confirmButtonText: 'Submit',
		    confirmButtonClass: 'btn btn-confirm',
		    cancelButtonClass: 'btn btn-cancel'
		}).then(function (confirm) {
			console.log(confirm);
		    if(confirm.value == true){
			    $('#form-transfer').attr('action', '{{route('system.postTransfer')}}');
			    $('#form-transfer').submit();
		    }
		});  
    });
    @if(Session('flash_level') && Session('flash_level') == 'success')
    	Swal.fire({
            title: 'Success',
            text: '{{Session('flash_message')}}',
            type: 'success',
            confirmButtonText: 'OK',
            confirmButtonClass: 'btn btn-confirm',
            closeOnConfirm: true
        })
    @endif
});
</script>
@endsection