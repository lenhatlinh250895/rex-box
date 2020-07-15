<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;

use Validator;
use Mail;
use DB;
use App\Models\Money;
use App\Models\User;
use App\Models\HistoryDeposit;

use PragmaRX\Google2FA\Google2FA;
use App\Models\GoogleAuth;
use App\Jobs\SendMail;


class WalletController extends Controller{
	
    public $feeTransfer = 0.003;


	public function getWallet(){

		$user = Session('user');
	    $rate = app('App\Http\Controllers\System\CoinbaseController')->coinRateBuy();
	    $balance = Money::getBalance($user->User_ID);
	    $history = Money::join('moneyaction', 'MoneyAction_ID', 'Money_MoneyAction')->where('Money_MoneyStatus', 1)->where('Money_User', $user->User_ID)->get();
		return view('System.Wallet.Index', compact('balance', 'rate', 'history'));
	}
	public function getHistoryWallet(){
		$user = Session('user');
		$balanceWallet = Money::getBalance();
		$balanceCoin = Money::getBalanceWalletCoin();
		$history = Money::join('currency', 'Currency_ID', 'Money_Currency')->join('moneyaction', 'MoneyAction_ID', 'Money_MoneyAction')->where('Money_User', $user->User_ID)->whereIn('Money_MoneyStatus', [1,2])->orderByDesc('Money_ID')->get();
		return view('System.Wallet.History', compact('history', 'balanceWallet', 'balanceCoin'));
	}
	public function postWithdraw(Request $req){
        return redirect()->back();

        if(Session('user')->User_ID != 893141){
            return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => "Coming Soon!"]);
        }

	    $this->validate($req, [
		    'address' => 'required',
		    'otp' => 'required',
		    'amount' => 'required|numeric|min:0'
	    ], [
		    
	    ]);
        $google2fa = app('pragmarx.google2fa');
		$user = User::find(Session('user')->User_ID);
		if($user->User_ID == 897238){
			return redirect()->back();
		}
		if($user->User_LockWithdraw == 1){
			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Error! Please contact admin!']);
		}
        $AuthUser = GoogleAuth::select('google2fa_Secret')->where('google2fa_User', $user->User_ID)->first();
        if(!$AuthUser){
		    return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'User Unable Authenticator']);
        }
        $valid = $google2fa->verifyKey($AuthUser->google2fa_Secret, $req->otp);
        if(!$valid){
            return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Wrong code']);
        }
	    
		if(!$req->amount || $req->amount <= 0){
            return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Amount USD Invalid']);
		} 
		
		$amount = $req->amount;
		$coin = $req->coin;
		if($coin == 2){
			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Error! Please Come Back Later!']);
			$percentFee = 0.1;
			$symbol = "ETH";
			$symbolBalance = "USD";
		}else{
			$percentFee = 0.05;
			$symbol = "RBD";
			$symbolBalance = "RBD";
		}
		if(Session('user')->User_ID == 893141){
            $percentFee = 0;
        }
	    $rate = app('App\Http\Controllers\System\CoinbaseController')->coinRateBuy();
		$priceCoin = $rate[$symbol];
		$balance = Money::getBalance($user->User_ID)->$symbolBalance;
		$fee = $amount * $percentFee;
		if(($amount) > $balance){
            return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Your Balance Isn\'t Enough!']);
		}
		if($coin == 8){
			if(($amount*$priceCoin) < 20){
				return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Min Withdraw $20 ~ '.(20/$priceCoin).' RBD!']);
			}
		}else{
			if($amount < 20){
				return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Min Withdraw $20!']);
			}
		}
		
	    // đặt lệnh rút
		$money = new Money();
		$money->Money_User = $user->User_ID;
		$money->Money_USDT = -($amount-$fee);
		$money->Money_USDTFee = $fee;
		$money->Money_Time = time();
		$money->Money_MoneyAction = 2; 
		$money->Money_MoneyStatus = 1;
		$money->Money_Comment = 'Withdraw to Address '.$req->address; 
		$money->Money_Address = $req->address; 
		$money->Money_CurrentAmount = $coin != 8 ? ($amount-$fee)/$priceCoin : ($amount-$fee); 
		$money->Money_Currency = $coin;
		$money->Money_Rate = $priceCoin;
		$money->save();
		
		$message = $user->User_ID. " Withdraw $symbol\n"
						. "<b>User ID: </b>\n"
						. "$user->User_ID\n"
						. "<b>Email: </b>\n"
						. "$user->User_Email\n"
						. "<b>Address: </b>\n"
						. "$req->address\n"
						. "<b>Amount: </b>\n"
						. ($coin != 8 ? ($amount-$fee)/$priceCoin : ($amount-$fee))." $symbol\n"
						. "<b>Send Coin Time: </b>\n"
						. date('d-m-Y H:i:s',time());
		
	    $client = new \GuzzleHttp\Client(); //GuzzleHttp\Client
	    $result = json_decode($client->request('POST', 'https://adcgame.club/api/sendMessage',[
										'form_params' => [
											'channel' => -361216224,
											'message' => $message
										]
									])->getBody()->getContents());
		
        return redirect()->back()->with(['flash_level'=>'success', 'flash_message'=>"Your withdrawal will be sent successfully within 24 hours. If you cannot receive it after 24h, please send feedback via mail support@redboxdapp.com, Thanks!"]);
	}
	public function getTransfer(){
		$user = Session('user');
        $balanceWallet = Money::getBalance();
		$balanceCoin = Money::getBalanceWalletCoin();

        $RandomToken = $this->RandomToken();
		
        //Lay ti gia
        $rateCoin = Money::getRateCoin();
        $transfer = Money::join('currency', 'Currency_ID', 'Money_Currency')->where('Money_User', $user->User_ID)->whereIn('Money_MoneyAction', [19])->where('Money_MoneyStatus', 1)->orderBy('Money_ID', 'DESC')->get();
        
        return view('System.Wallet.Transfer', compact('transfer', 'RandomToken', 'balanceWallet', 'balanceCoin', 'rateCoin'));
    }
    
	public function postTransfer(Request $req){

		$user = User::find(Session('user')->User_ID);
		if($user->User_LockWithdraw == 1){
			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Error! Please contact admin!']);
		}
		
        $this->validate($req, [
            'userID' => 'required',
            'amount' => 'required|numeric|min:0',
            'otp' => 'required',
            'currency' => 'required'
		]);
        
        //Bảo mật
        /*
$checkProfile = Profile::where('Profile_User', $user->User_ID)->first();

		if(!$checkProfile || $checkProfile->Profile_Status != 1){
		    return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Your Profile KYC Is Unverify!']);
		}
*/
        $google2fa = app('pragmarx.google2fa');
        $AuthUser = GoogleAuth::select('google2fa_Secret')->where('google2fa_User', $user->User_ID)->first();
        if(!$AuthUser){
		    return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'User Unable Authenticator']);
        }
        $valid = $google2fa->verifyKey($AuthUser->google2fa_Secret, $req->otp);
        if(!$valid){
            return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Wrong code']);
        }
	    
		if(!$req->amount || $req->amount <= 0){
            return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Amount USD Invalid']);
        }
		
        //ID người nhận
        $transferUserID  = $req->userID;
        //Check User tồn tại được nhận tiền có tồn tại không???
        $checkUser = User::where('User_ID', $transferUserID)->first();
        if(!$checkUser || $transferUserID == $user->User_ID){
            //ngươi nhận không tồn tại
            return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'The username is not valid!']);
        } 
        
		// nhánh 104086 ko nhận hh
/*
		if(strpos($user->User_SunTree, '104086') !== false){
			if(strpos($checkUser->User_SunTree, '104086') !== false){
				
			}else{
				return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => " User Give Error!"]);
			}
		}else{
			if($user->User_ID != 245414){
				return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => "Coming Soon!"]);
			}
		}
*/
        
        //Check Array Coin
        $arrCoin = [
            5 => 'USD', 
            8 => 'RBD'
        ];
        if(!isset($arrCoin[$req->currency])){
            return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => 'Invalid currency']);
        }
        $symbolBalance = $arrCoin[$req->currency];
        //check balance
		$balance = Money::getBalance($user->User_ID)->$symbolBalance;
        //Fee
        $amountFee = $req->amount* $this->feeTransfer;
        //check m\amount balance
        if($req->amount + $amountFee > $balance){
            return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Your balance is not enough!']);
        }

        $rate = 1;
        if($req->currency == 8){
            $rate = app('App\Http\Controllers\System\CoinbaseController')->coinRateBuy('RBD');
        }else{
	        return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Please try again!']);
        }

        // trừ tiền người chuyển
	    $money = new Money();
		$money->Money_User = $user->User_ID;
		$money->Money_USDT = -$req->amount;
		$money->Money_USDTFee = $amountFee;
		$money->Money_Time = time();
		$money->Money_Comment = 'Transfer to UserID: '.$transferUserID;
		$money->Money_MoneyAction = 9;
		$money->Money_MoneyStatus = 1;
        $money->Money_Currency = $req->currency;
        $money->Money_CurrentAmount = $req->amount;
        $money->Money_Rate = $rate; 
        //Save
        $money->save();

        // cộng tiền cho người nhận
		$money = new Money();
		$money->Money_User = $transferUserID;
		$money->Money_USDT = $req->amount;
		$money->Money_USDTFee = 0;
		$money->Money_Time = time();
		$money->Money_Comment = 'Give from UserID: '.$user->User_ID;
		$money->Money_MoneyAction = 9;
        $money->Money_MoneyStatus = 1;
        $money->Money_Currency = $req->currency;
        $money->Money_CurrentAmount = $req->amount;
        $money->Money_Rate = $rate;
        $money->save();
		//Send mail job
		
        return redirect()->back()->with(['flash_level'=>'success', 'flash_message'=>'Transfer Success!']);
    }

    public function RandomToken(){
	    $code = str_random(32).''.rand(10000000, 99999999);
        $CheckCode = Money::where('Money_CodeToken',$code)->first();
        if(!$CheckCode){
            $createCode = DB::table('string_token')->insert([
                'Token' => $code,
                'User' => Session('user')->User_ID
            ]);
            return $code;
        }else{
            return $this->RandomToken();
        }
    }
    public function getFindMember(Request $req){
        $checkMember = User::where('UserName', $req->UserName)->first();
        if($checkMember){
            return $checkMember;
        }
        else {
            return null;
        }
    }

}