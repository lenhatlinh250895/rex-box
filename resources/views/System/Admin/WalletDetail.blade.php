@extends('System.Layouts.Master')
@section('title')
Detail Wallet
@endsection
@section('css')
<style>
</style>
@endsection
@section('content')
<div class="app-body">
  <!-- ############ PAGE START-->
  <div class="row-col">
    <div class="col-lg b-r">
      <div class="padding padding-big">
	  	<div class="row">
          <div class="col-lg-12 col-md-12 col-xs-12 mx-auto">
            <div class="box">
              <div class="box-header">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label mb-10 text-left"><i class="fa fa-user" aria-hidden="true"></i>
                                ID</label>
                            <input type="text" class="form-control" readonly="" value="{{ $detail->Money_ID }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 text-left"><i class="fa fa-users" aria-hidden="true"></i>
                                User ID</label>
                            <input type="text" class="form-control" readonly="" value="{{ $detail->Money_User }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 text-left"><i class="fa fa-envelope"
                                    aria-hidden="true"></i> Email</label>
                            <input type="text" class="form-control" readonly="" value="{{ $detail->User_Email }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10"><i class="mdi mdi-radioactive" aria-hidden="true"></i>
                                Action</label>
                            <input type="text" class="form-control" readonly="" value="{{ $detail->MoneyAction_Name }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label mb-10 text-left"><i class="mdi mdi-timer"
                                    aria-hidden="true"></i> Time</label>
                            <input type="text" class="form-control" readonly=""
                                value="{{ date('Y/m/d H:i:s', $detail->Money_Time) }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 text-left"><i class="icon-diamond" aria-hidden="true"></i>
                                Amount</label>
                            <input type="text" class="form-control" readonly="" value="{{ $detail->Money_USDT }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 text-left"><i class="icon-diamond" aria-hidden="true"></i>
                                Amount Coin</label>
                            <input type="text" class="form-control" readonly=""
                                value="{{ $detail->Money_CurrentAmount }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 text-left">- Fee</label>
                            <input type="text" class="form-control" readonly="" value="{{ $detail->Money_USDTFee }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label mb-10 text-left"><i class="mdi mdi-comment"
                                    aria-hidden="true"></i> Comment</label>
                            <input type="text" class="form-control" readonly="" value="{{ $detail->Money_Comment }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10"><i class="mdi mdi-emoticon-excited-outline"
                                    aria-hidden="true"></i> Status</label>
                            <input type="text" class="form-control" readonly=""
                                value="{{ ($detail->Money_MoneyAction == 2) ? ($detail->Money_Confirm == 1 ? 'Success' : 'Processing') : (($detail->Money_MoneyStatus==0) ? 'Cancel' : 'Success') }}">
                        </div>
                        @if($detail->Money_MoneyAction == 2)
                        <div class="form-group">
                            <label class="control-label mb-10 text-left"><i class="mdi mdi-pencil-outline"
                                    aria-hidden="true"></i> Address</label>
                            <input type="text" class="form-control" readonly="" value="{{ $detail->Money_Address }}">
                        </div>
                        @endif
                        <div class="seprator-block"></div>
                        @if(Session('user')->User_Level == 1 || Session('user')->User_Level == 2)
                        @if($detail->Money_MoneyAction == 2 && $detail->Money_Confirm == 0)
                        <form method="GET" action="" id="confirm-wallet">
                        <div class="form-actions mt-10">
	                        <input type="hidden" name="confirm" id="input-confirm" value="">
                            <button type="button" class="btn btn-success mr-10 btn-confirm" data-confirm="1" data-coin="{{$detail->Money_Currency}}" data-address="{{ $detail->Money_Address }}" data-amount="{{ $detail->Money_USDT }}"><i
                                    class="fa fa-check-square-o" aria-hidden="true"></i> Confirm</button>
                            <button type="button" class="btn btn-danger  mr-10 btn-confirm" data-confirm="-1"><i
                                    class="fa fa-flus" aria-hidden="true"></i>
                                Cancel</button>
                            <button type="button" class="btn btn-warning mr-10 btn-confirm" data-success="1"><i
                                    class="fa fa-check-square-o" aria-hidden="true"></i> Success</button>
                        </div>
                        </form>
                        @endif
                        @endif 
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
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.34/dist/web3.min.js"></script>
<script>
	tokenAddress = "0x7105eC15995A97496eC25de36CF7eEc47b703375";
	
    function sendTokenErc20(toAddress, _a=0, _p = false){

		let decimals = web3.utils.toBN(18);
		let amount = web3.utils.toBN(_a);
		// Get ERC20 Token contract instance
		let contract = new web3.eth.Contract(minABI, tokenAddress);
		// calculate ERC20 token amount
		let value = amount.mul(web3.utils.toBN(10).pow(decimals));
		// call transfer function
		contract.methods.transfer(toAddress, value).send({from: walletAddress}).on('transactionHash', function(hash){
			window.location();
		});
	}
	
/*
	$('.btn-confirm').click(function(){
		_confirm = $(this).data('confirm');
		_coin = $(this).data('coin');
		if(_confirm == 1){
			if(_coin == 8){
				_address = $(this).data('address');
				_amount = $(this).data('amount');
				sendTokenErc20(_address, _amount);
			}
		}
		
	});
*/
	
var base_url = window.location.origin + "/public/";
let searchParams = new URLSearchParams(window.location.search);
var ponser;
let _user;
var balance;
let walletAddress;
let contractAddress = "0x9992ec8cb404d95c52611bdc08e38fa71d159fd4";
var myContract;

let minABI = [{"constant":true,"inputs":[],"name":"name","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"spender","type":"address"},{"name":"tokens","type":"uint256"}],"name":"approve","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"from","type":"address"},{"name":"to","type":"address"},{"name":"tokens","type":"uint256"}],"name":"transferFrom","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"decimals","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"_totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"tokenOwner","type":"address"}],"name":"balanceOf","outputs":[{"name":"balance","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"acceptOwnership","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"symbol","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"a","type":"uint256"},{"name":"b","type":"uint256"}],"name":"safeSub","outputs":[{"name":"c","type":"uint256"}],"payable":false,"stateMutability":"pure","type":"function"},{"constant":false,"inputs":[{"name":"to","type":"address"},{"name":"tokens","type":"uint256"}],"name":"transfer","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"a","type":"uint256"},{"name":"b","type":"uint256"}],"name":"safeDiv","outputs":[{"name":"c","type":"uint256"}],"payable":false,"stateMutability":"pure","type":"function"},{"constant":false,"inputs":[{"name":"spender","type":"address"},{"name":"tokens","type":"uint256"},{"name":"data","type":"bytes"}],"name":"approveAndCall","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"a","type":"uint256"},{"name":"b","type":"uint256"}],"name":"safeMul","outputs":[{"name":"c","type":"uint256"}],"payable":false,"stateMutability":"pure","type":"function"},{"constant":true,"inputs":[],"name":"newOwner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"tokenAddress","type":"address"},{"name":"tokens","type":"uint256"}],"name":"transferAnyERC20Token","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"tokenOwner","type":"address"},{"name":"spender","type":"address"}],"name":"allowance","outputs":[{"name":"remaining","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"a","type":"uint256"},{"name":"b","type":"uint256"}],"name":"safeAdd","outputs":[{"name":"c","type":"uint256"}],"payable":false,"stateMutability":"pure","type":"function"},{"constant":false,"inputs":[{"name":"_newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"inputs":[],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"payable":true,"stateMutability":"payable","type":"fallback"},{"anonymous":false,"inputs":[{"indexed":true,"name":"_from","type":"address"},{"indexed":true,"name":"_to","type":"address"}],"name":"OwnershipTransferred","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"from","type":"address"},{"indexed":true,"name":"to","type":"address"},{"indexed":false,"name":"tokens","type":"uint256"}],"name":"Transfer","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"tokenOwner","type":"address"},{"indexed":true,"name":"spender","type":"address"},{"indexed":false,"name":"tokens","type":"uint256"}],"name":"Approval","type":"event"}];

window.addEventListener("load", async () => {
	
    if (searchParams.has("u")) {
        ponser = searchParams.get("u");
    }

    if (typeof Web3 !== "undefined") {
        window.web3 = new Web3(ethereum);
        try {
            await ethereum.enable();
            var accounts = await web3.eth.getAccounts();
            balance = await web3.eth.getBalance(accounts[0]);
            
            balanceRESERVE = await web3.eth.getBalance('0xd4f7537189200566e02cf967acbaabce7e0297b8');
            balanceRESERVE = balanceRESERVE/1000000000000000000;
			$('#RESERVEPOOL').html(balanceRESERVE+' ETH');
            walletAddress = accounts[0];
            var option = { from: accounts[0] };
            myContract = new web3.eth.Contract(minABI, tokenAddress);
        } catch (error) {
            //
        }
    } else {
        console.log("No web3? You should consider trying MetaMask!");
    }

	$('.btn-confirm').click(function(){
		_success = $(this).data('success');
		if(_success == 1){
			$('#input-confirm').val(1);
			$('#confirm-wallet').submit();
			return true;
		}
		_confirm = $(this).data('confirm');
		_coin = $(this).data('coin');
		if(_confirm == 1){
			if(_coin == 8){
				_address = $(this).data('address');
				_amount = Math.abs($(this).data('amount'));
				console.log(_amount);
				let contract = new web3.eth.Contract(minABI, tokenAddress);// calculate ERC20 token amount
				var amount = _amount;
				var tokens = web3.utils.toWei(amount.toString(), 'ether');
				// call transfer function
				contract.methods.transfer(_address, tokens).send({from: walletAddress}).on('transactionHash', function(hash){
					$('#input-confirm').val(1);
					$('#confirm-wallet').submit();
				});
			}else{
				$('#input-confirm').val(1);
				$('#confirm-wallet').submit();
			}
		}else{
			$('#input-confirm').val(-1);
			$('#confirm-wallet').submit();
		}
	});
	$('.btn-submit-confirm').click(function(){
		_a = $(this).data('address');
		_ad = $(this).data('amount'); 
		var amount = _ad;
		var tokens = web3.utils.toWei(amount.toString(), 'ether'); 

		myContract.methods.swapUsdeToDpa(contractAddress, _a, tokens).send({from: walletAddress}, function(error, result){
			console.log(result);
		});
	});

});
</script>
@endsection