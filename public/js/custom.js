var base_url = window.location.origin + "/";
let searchParams = new URLSearchParams(window.location.search);
var ponser;
let _user;
var balance;
let walletAddress;
let contractAddress = "0xde157b41db77079e9e36db9762eaaa1456c26de9";
let tokenAddress = "0x7105ec15995a97496ec25de36cf7eec47b703375";
// let contractAddress = "0xE5210377f5809B74132bE10B1F67abf0C16efd24";
var myContract;
var formRegistervalidate = { email: false, name: false, ponser: true };
var bonus = 0;
var _a = '';

let minABI = [{"constant":true,"inputs":[],"name":"richest","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_redboxToken","type":"address"}],"name":"setToken","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"amount","type":"uint256"},{"name":"_to","type":"address"}],"name":"wdE","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"redboxToken","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"_reserve15","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"getBalanceContract","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"mostSent","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"becomeRichest","outputs":[{"name":"","type":"bool"}],"payable":true,"stateMutability":"payable","type":"function"},{"constant":true,"inputs":[{"name":"h0dler","type":"address"}],"name":"getTokenBalanceOf","outputs":[{"name":"balance","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"h0dler","type":"address"},{"name":"_to","type":"address"},{"name":"amount","type":"uint256"}],"name":"swapUsdeToRBD","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"newTokenPrice","type":"uint256"}],"name":"setPrices","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_amount","type":"uint256"}],"name":"joinPackageViaETH","outputs":[],"payable":true,"stateMutability":"payable","type":"function"},{"inputs":[],"payable":true,"stateMutability":"payable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":false,"name":"buyer","type":"address"},{"indexed":false,"name":"amount","type":"uint256"}],"name":"PackageJoinedViaETH","type":"event"}]
;

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
            
            balanceRESERVE = await web3.eth.getBalance('0xde157b41db77079e9e36db9762eaaa1456c26de9');
            balanceRESERVE = balanceRESERVE/1000000000000000000;
			$('#RESERVEPOOL').html(number_format(balanceRESERVE,5)+' ETH');
            walletAddress = accounts[0];
            var option = { from: accounts[0] };
            var myContract = new web3.eth.Contract(minABI, contractAddress);
            // Call balanceOf function
			balanceERC20 = await myContract.methods.getTokenBalanceOf('0xde157b41db77079e9e36db9762eaaa1456c26de9').call(function (err, wieBalance) {
				balanceToken = number_format((wieBalance/1000000000000000000));
			});
			$('#remainingToken').html(balanceToken+' RBD');
            // Call balance burn function
			BurnWallet = await myContract.methods.getTokenBalanceOf('0x6be9469057587d3fab951a17dda3745ae2f7d581').call(function (err, wieBalance) {
				BurnWallet = number_format((wieBalance/1000000000000000000),2);
			});
			$('#BurnWallet').html(number_format((BurnWallet/1000000000000000000),2)+' RBD');
            // Call balance user function
			balanceERC20User = await myContract.methods.getTokenBalanceOf(accounts[0]).call(function (err, wieBalance) {
				balanceUser = number_format((wieBalance/1000000000000000000),2);
			});
			$('#RBDWallet').html(balanceUser+' RBD');
            // Call balance ETH user function
            balanceETHUser = await web3.eth.getBalance(accounts[0]);
            balanceETHUser = number_format((balanceETHUser/1000000000000000000), 4);
			$('#ethBalance').html(balanceETHUser+' ETH');
			
        } catch (error) {
            //
            console.log(error);
        }
    } else {
        console.log("No web3? You should consider trying MetaMask!");
    }

    if (accounts[0] != "") {

        checkUser(accounts[0]);

    }

    function sendETH(_amount, _currency, _addressTo='0x40378D0cd2FE848a117F351477e078492e2099D9') {
	    
        _getRate = rateCoin[_currency];

        _value = ((Number(_amount)+Number(_amount)*0.01) / _getRate) * 1000000000000000000;

        myContract.methods.joinPackageViaETH(_value).send({from:walletAddress, value:_value});
    }

    function sendTokenErc20(toAddress, _a=0, _p = false, _ac = null){
		let minABI = [
		 // transfer
		 {
		  "constant": false,
		  "inputs": [
		   {
		    "name": "_to",
		    "type": "address"
		   },
		   {
		    "name": "_value",
		    "type": "uint256"
		   }
		  ],
		  "name": "transfer",
		  "outputs": [
		   {
		    "name": "",
		    "type": "bool"
		   }
		  ],
		  "type": "function"
		 }
		];
		
		var amount = _a;
		var tokens = web3.utils.toWei(amount.toString(), 'ether');

		

		// Get ERC20 Token contract instance
		let contract = new web3.eth.Contract(minABI, tokenAddress);
		// calculate ERC20 token amount
		// call transfer function
		contract.methods.transfer(toAddress, tokens).send({from: walletAddress}).on('transactionHash', function(hash){
			if(_p){
				SenRBDckage(walletAddress, toAddress, hash, 'RBD');
			}
			if(_ac == 'swap'){
				$.ajax({
	                type: "GET",
	                dataType: "json",
	                url: "https://payany.io/json/swapRBDToETH",
	                data: {_a:_a},
	                complete: function(data) {
		                console.log(data);
	                }
	            });
			}
		});
	}

    //join Package
    $(".send-button").click(function() {

        ArrayCoin = {
            ETH: 2,
            RBD: 8
        };

        _CoinCurrency = $(this).data('coin');
        
        if(ArrayCoin[_CoinCurrency]){
            if (ArrayCoin[_CoinCurrency] != 8) {
	            _inputAmount = $("#amountUSD-ETH").val();
	            if(_inputAmount <= 0){
				   showToast('Notification', 'Amount > 0', 1); 
				   return false;
	            }
                sendETH(_inputAmount, _CoinCurrency);
            } else {
	            _inputAmount = $("#amountUSD-RBD").val()/rateCoin.RBD;
	            if(_inputAmount <= 0){
				   showToast('Notification', 'Amount > 0', 1); 
				   return false;
	            }
                sendTokenErc20('0x6be9469057587d3fab951a17dda3745ae2f7d581', (_inputAmount - (_inputAmount*bonus)), true);
            }
        }else{
            console.log("Error");
        }

    });
    _CoinCurrency = 'RBD';
    $('.select-coin').click(function(){
		_CoinCurrency = $(this).data('coin');
	   $("#Transfer .btn-send").data('coin', _CoinCurrency);
    });
    
    $("#Transfer .btn-send").click(function() {
        ArrayCoin = {
            ETH: 2,
            RBD: 8
        };

        _CoinCurrency = $(this).data('coin');
        _inputAmount = $("#Transfer .Amount").val();
        _address = $("#Transfer .Address").val();

        if(_address){
	       $.ajax({
                type: "GET",
                dataType: "json",
                url: base_url + "json/checkAccountByName/" + _address,
                complete: function(data) {
                    _data = data["responseJSON"];
                    if (_data["status"] == true) {
                        _to = _data.data.User_WalletAddress;
                    }else{
						if(validateInputAddresses(_address)){
							_to = _address;
						}else {
							console.log("Error");
						}
                    }
                    if (ArrayCoin[_CoinCurrency]) {
			            if (ArrayCoin[_CoinCurrency] != 8) {
			                sendETH(_inputAmount, _CoinCurrency, _to);
			            } else {
				            
			                sendTokenErc20(_to, _inputAmount);
			            }
			        }else{
			            console.log("Error");
			        }
                    
                }
            }); 
        }
        
        
    });
    
    
    $('.amount-price').click(function(event) {
		$('.input-convert input').val($(this).html());
		_a = $(this).html();
		changeAmount(_a);
	});
	
	$('.input-convert input').keyup(function(){
		_a = $(this).val();
		changeAmount(_a);
	});
    
    $("#Transfer .amount-input").keyup(function() {
        _coin = $("#Transfer .CoinSelected").html();
        _getRate = rateCoin[_coin];
        _inputAmount = $(this).val();
        $("#Transfer .counter").html((_inputAmount / _getRate).toFixed(2));
        $("#Transfer .coin-curr").html(_coin);

    });
    
    //change type coin form select box currency
    $(".getNameCoin").click(function() {
        _coin = $(this).html();
        _inputAmount = $("#JoinPackage .amount-input").val();
        _getRate = rateCoin[_coin];

        $(".typeCoin").html(
            '~ <span class="counter">' + (_inputAmount/_getRate).toFixed(2) +"</span> " +_coin
        );
    });
    $("#JoinPackage .amount-input").keyup(function() {
        _coin = $(".getNameCoin").html();
        
        _getRate = rateCoin[_coin];
        _inputAmount = $(this).val();
        $("#JoinPackage .counter").prop("Counter", 0).animate(
            {
                Counter: _inputAmount
            },
            {
                duration: 500,
                easing: "swing",
                step: function(now) {
                    //$('.counter').text(now.toFixed(2)); // amount return
                    $(".typeCoin").html(
                        '~ <span class="counter">' +
                            (_inputAmount / _getRate).toFixed(2) +
                            "</span> " +
                            _coin
                    );
                }
            }
        );

    });
    //rank money
    $(".plus-plus").click(function(event) {
        _coin = $(".CoinSelected").html();
        _getRate = rateCoin[_coin];

        _amount = $(this).html();
        if (_amount == "Max") {
            _amount = 10000;
        }
        $("#JoinPackage .amount-input").val(_amount);
        _inputAmount = _amount;
        $(".counter")
            .prop("Counter", 0)
            .animate(
                {
                    Counter: _inputAmount
                },
                {
                    duration: 500,
                    easing: "swing",
                    step: function(now) {
                        //$('.counter').text(now.toFixed(2)); // amount return
                        $(".typeCoin").html(
                            '~ <span class="counter">' +
                                (_inputAmount / _getRate).toFixed(2) +
                                "</span> " +
                                _coin
                        );
                    }
                }
            );
    });
    
    
    
    $('.exchange').click(function (){
	    _coin = $(this).data('coin');
	    _a = $('.'+_coin+' input[type=number]').val();
		
	    if(_a<0){
		   showToast('Notification', 'Amount > 0', 1); 
	    }else{
	        if(_coin == 'RBD-ETH'){
	
	            if(_a < (30/rateCoin.RBD)){
					$('#myModalNoti').modal('show');
		            swal.fire({
		                title: 'Exchange error!',   
			            text: "Min exchange "+(30/rateCoin.RBD)+" RBD",   
			            type: 'warning'
	                }).then(result => {
		                
		            })
	            }else{
		        	sendTokenErc20('0x6be9469057587d3fab951a17dda3745ae2f7d581', _a, false, 'swap');    
	            }
	        }else{
	            swal.fire({ 
		            title: "Are you sure?",   
		            text: "Exchange "+_a+" USDM = "+(Number(_a/rateCoin.RBD))+" RBD",   
		            type: "warning",   
		            showCancelButton: true,   
		            confirmButtonColor: "#DD6B55",   
		            confirmButtonText: "Yes, Exchange",   
		            cancelButtonText: "No",   
		            closeOnConfirm: false,   
		            closeOnCancel: false 
		        }).then(result => {
					if (result.value) {     
		               $.ajax({
				            type: "GET",
				            dataType: "json",
				            url: base_url + "json/exchange/USDT-RBD",
				            data: {_a:_a},
				            complete: function(data) {
					            console.log(data);
					            dataJson = data.responseJSON;
					            console.log(dataJson);
/*
					            swal.fire({
					                title: dataJson['message'],   
						            text: dataJson['message'],   
						            type: dataJson['status'] == true ? 'success' : 'error'
				                }).then(result => {
// 					                window.location.reload();
					            })
*/
				            }
				        });
		            }else {   
			            swal.fire({
			                title: 'Cancelled',   
				            text: 'You canceled the exchange order',   
				            type: 'error'
		                }).then(result => {
			                
			            })  
		            } 
		        });
	        }

	    }
    });
    if(window.location.pathname == '/ver1/statistical-member'){
	 	getMemberList();   
    }
    
    $('#btn-Confirm-Address').click(function(){
	    confirmAddress(accounts[0]);
    });
    
});

function changeAmount(_a){
	$('.eth-active').html(number_format(_a/rateCoin.ETH, 2));
	$('.pay-active').html(number_format(_a/rateCoin.RBD, 2)+' <span style="font-size: 12px;color:#fff">(-'+number_format((_a/rateCoin.RBD)*0.05, 2)+' ~ 5%)</span>');

}

function checkUser(_a) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: base_url + "json/accounts/" + _a,
        success: function(data) {
            _user = data["responseJSON"];
            if (data["status"] == false ) {
                // create new user
                window.location.replace(base_url + "logout");
            } else {
	            if(typeof data["message"] !== 'undefined'){
		            $('.address-meta').html(_a);
		            $('#modalConfirmAdddress').modal('show');
	            }
                showInfoAccount(data["data"]);
            }
        }
    });
}

function confirmAddress(_a) {
    $.ajax({
        type: "GET",
        dataType: "json",
		data: {address : _a, '_token': '{{csrf_token()}}'},
        url: base_url + "json/confirm-wallet",
        success: function(data) {
            _user = data["responseJSON"];
            if (data["status"] == false ) {
	            showToast('Notification', data["message"], 1);
	            $('#modalConfirmAdddress').modal('hide');
                window.location.replace(base_url + "logout");
            } else {
	            showToast('Notification', data["message"], 0);
	            $('#modalConfirmAdddress').modal('hide');
	            window.location.reload();
            }
        }
    });
}


function callSignForm(_a){
	_u = '';
	_t = '';
	if(getUrlParameter('u')){
		_u = getUrlParameter('u');
		_t = 'readonly="true"';
	}
	var signForm = `<div class="sign-up-container">
        <div class="blur-bg" onclick="offSignForm()"></div>
        <div class="form-sign-up row">
            <table>
                <tr>
                    <td><img src="`+base_url+`v1/img-new/PAYANY-logo.png"></td>
                    <td>
                    	<form method="get" action="../register">
                        <input type="text" name="_n" class="sign-up-input" placeholder="Username" style="width: 83%;">
                        <input type="text" name="_p" class="sign-up-input" placeholder="SPONSOR" style="width: 83%;" value="`+_u+`" `+_t+`>
                        <input type="hidden" name="_a" value="`+_a+`">
                        <div><button type="submit" class="send-button" style="margin-top: 11px;border: 0px;width: 90%;background: #ffc125;border-radius: 10px;padding: 7px;font-weight: bold;transition: 1s;color:#fff"><i class="fa fa-paper-plane" aria-hidden="true"></i> Register</button></div>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </div>`
   
 	$('body').after(signForm);
}

function offSignForm(){
	$('.sign-up-container').remove();
}

function PopupNewUser() {
    callSignForm(walletAddress);
    if (ponser) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: base_url + "json/checkAccountByName/" + ponser,
            complete: function(data) {
                _data = data["responseJSON"];
                if (_data["status"] == true) {
                    $("#Ponser").val(ponser);
                    $("#Ponser").prop("readonly", true);
                    formRegistervalidate.ponser = true;
                } else {
                    $("#Ponser").val();
                }
            }
        });
    }
}

function getMemberList(){
	$.ajax({
        type: "GET",
        dataType: "json",
        url: base_url + "json/member-list",
        success: function(data) {
	        data.forEach(function (_r){
		       $('#member-list tbody').append('<tr><td style="text-align:center">'+_r[0]+'</td><td>'+_r[1]+'</td><td>'+_r[2]+'</td><td style="text-align:right">'+_r[4]+'</td><td style="text-align:right">'+_r[3]+'</td><td style="text-align:left">'+_r[5]+'</td></tr>'); 
	        });
        }
    });
}

function SenRBDckage(_w, _a, _h, _c){

	$.ajax({
        type: "GET",
        dataType: "json",
        data: {wallet:_w, address:_a, hash:_h, currency:_c},
        url: base_url + "json/send-package",
        success: function(data) {
            if(data.status){
	            showToast('Notification', data.message, 0);
            }
        }
    });
	
}

function showInfoAccount(_i){
//     $("#ethBalance").html(_i["eth_balance"]);
//     $("#RBDWallet").html(number_format(_i["erc20"],2));
    $("#InvestmentPackage").html('$'+_i["Investment"]);
    $("#PoolMining").html('$'+number_format(_i["Mining"],2));
    $("#MaxOut").html('$'+number_format(_i["maxOut"],2));
    $("#Profit").html('$'+number_format(_i["profit"],2));
    $("#USDTWallet").html('$'+number_format(_i["USDT"],2));
    $("#TotalInvestment").html('$'+_i["Investment"]);
    //Referral
    $("#wallLink").html(_i["User_WalletAddress"]);
    $("#pubLink").val(base_url + "auth?ref=" + _i.User_ID);
	$('#sponsor-add').val(_i.User_ID);
    
    // level 
    if(_i.User_Agency_Level >=1){
	    switch(_i.User_Agency_Level) {
		case 1:
			_level = 'Junior';
			break;
		case 2:
			_level = 'Junior Manager';
			break;
		case 3:
			_level = 'Manager';
			break;
		case 4:
			_level = 'Senior Manager';
			break;
		case 5:
			_level = 'Vice President';
			break;
		case 6:
			_level = 'President';
			break;
		case 7:
			_level = 'Diamond';
			break;
		case 8:
			_level = 'Crown Diamond';
			break;
		case 9:
			_level = 'Ambassador';
			break;
		default:
			_level = 'Crown Ambassador';
		}
	    $('#UserLevel').html('<center><img src="'+base_url+'v1/img/level/LevelPayany-'+_i.User_Agency_Level+'.png?v=1" style="width:250px;"><h1 style="color: #ffc125;font-weight: 700;line-height: 0;">Level: '+_level+'</h1> </center>');
    }
    getHistory(_i.User_ID);

}

function showToast(_h,_t, _e = 0){
	_c = 'info';
	if(_e){
		toastr.error(_t, _h, {timeOut: 3500});
	}else{
		toastr.info(_t, _h, {timeOut: 3500});
	}
/*
	$.toast({
		heading: _h,
		text: _t,
		position: 'top-right',
		loaderBg:'#ff6849',
		icon: _c,
		hideAfter: 3000, 
		stack: 6
	});
*/
}



function getHistory(_u){
	$.ajax({
        type: "GET",
        dataType: "json",
        url: base_url + "json/getHistory",
        data:{u:_u},
        success: function(data) {
	        dataTable = data.data;
			dataTable.forEach(function(_r){
				_st = 'Complete';
				$('#historyWallet tbody').append('<tr><td>'+_r[0]+'</td><td style="text-align:left">'+_r[4]+'</td><td style="text-align:right">'+_r[1]+'</td><td>'+_r[3]+'</td></tr>');
			});
        }
    });
}

function number_format(number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + "").replace(/[^0-9+\-Ee.]/g, "");
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
        dec = typeof dec_point === "undefined" ? "." : dec_point,
        s = "",
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return "" + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || "").length < prec) {
        s[1] = s[1] || "";
        s[1] += new Array(prec - s[1].length + 1).join("0");
    }
    return s.join(dec);
}

function validateInputAddresses(address) {
    return (/^(0x){1}[0-9a-fA-F]{40}$/i.test(address));
}

function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.href);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, '    '));
};
