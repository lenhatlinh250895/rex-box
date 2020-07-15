<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Coinbase\History\Client;
use Coinbase\History\Configuration;
use Coinbase\History\Resource\Address;
use Coinbase\History\Resource\Account;

use Mail;
use DB;
use App\Models\Money;
use App\Models\Investment;
use App\Model\User;

class HistoryController extends Controller{
    public function coinbase(){
        $apiKey = 'E08pbjcG026NoOFA';
        $apiSecret = 'SMKMp5kkGaFyDyjcaBX9S4nlu0rfhqTd';

        $configuration = Configuration::apiKey($apiKey, $apiSecret);
        $client = Client::create($configuration);

        return $client;
    }
	public function getWalletActive(Request $req){
		// kiểm tra token có tồn tại hay ko
		include(app_path() . '/functions/xxtea.php');
		$info = xxtea_decrypt(base64_decode($req->token),'KhongTheNgo');
		$json = json_decode($info);

		$money = Money::where('Money_Token', $req->token)->where('Money_MoneyStatus', 0)->get();
		if($money){
			Money::where('Money_Token', $req->token)->update(['Money_MoneyStatus'=>1]);
			return redirect()->route('system.wallet')->with(['flash_level'=>'success', 'flash_message'=>$json->action.' complete']);
		}
		return redirect()->route('system.wallet')->with(['flash_level'=>'error', 'flash_message'=>'Token expired']);

	}

	public function getWallet(){

// 		dd($balance);
		return view('System.Wallet.Index');
	}

	public function getDeposit(){
		return view('System.Wallet.Deposit');
	}
	public function getWithdraw(){
		$user = Session('user');
    	$price = $this->coinbase()->getBuyPrice('ETH-USD');
		$RateETH = $price->getAmount();
    	$price = $this->coinbase()->getBuyPrice('BTC-USD');
		$RateBTC = $price->getAmount();
    	$price = $this->coinbase()->getBuyPrice('BCH-USD');
		$RateBCH = $price->getAmount();
    	$price = $this->coinbase()->getBuyPrice('LTC-USD');
		$RateLTC = $price->getAmount();
		// $trxPrice = json_decode(file_get_contents('https://api.coinmarketcap.com/v2/ticker/1958/'));
		$RateTRX = 0;
	    $RateGPG = DB::table('changes')->where('Changes_Time', date('Y-m-d'))->first()->Changes_Price;
		$balance = Money::getBalance($user->User_ID);
		return view('System.Wallet.Withdraw', compact('balance', 'user', 'RateETH', 'RateBTC', 'RateBCH', 'RateLTC', 'RateGPG', 'RateTRX'));
	}
	public function getTransfer(){
		$user = Session('user');
    	$price = $this->coinbase()->getBuyPrice('ETH-USD');
		$RateETH = $price->getAmount();
    	$price = $this->coinbase()->getBuyPrice('BTC-USD');
		$RateBTC = $price->getAmount();
    	$price = $this->coinbase()->getBuyPrice('BCH-USD');
		$RateBCH = $price->getAmount();
    	$price = $this->coinbase()->getBuyPrice('LTC-USD');
		$RateLTC = $price->getAmount();
		// $trxPrice = json_decode(file_get_contents('https://api.coinmarketcap.com/v2/ticker/1958/'));
		// $RateTRX = $trxPrice->data->quotes->USD->price;
		$RateTRX = 0;
	    $RateGPG = DB::table('changes')->where('Changes_Time', date('Y-m-d'))->first()->Changes_Price;
		$balance = Money::getBalance($user->User_ID);
		return view('System.Wallet.Transfer', compact('balance', 'user', 'RateETH', 'RateBTC', 'RateBCH', 'RateLTC', 'RateGPG', 'RateTRX'));
	}

	public function getHistoryWallet(){
        $user = session('user');
        $walletHistory = Money::join('moneyaction', 'Money_MoneyAction', 'moneyaction.MoneyAction_ID')->whereIn('Money_MoneyStatus', [1, 2])->where('Money_User', $user->User_ID)->orderByDesc('Money_ID')->select('Money_ID', 'Money_USDT', 'Money_USDTFee', 'moneyaction.MoneyAction_Name', 'Money_Rate','Money_Time', 'Money_Comment')->orderBy('Money_Time', 'DESC')->get();
		return view('System.History.Wallet', compact('walletHistory'));
	}
	public function getHistoryCommission(){
        $user = session('user');
        $walletHistory = Money::join('moneyaction', 'Money_MoneyAction', 'moneyaction.MoneyAction_ID')->whereIn('Money_MoneyStatus', [1, 2])->where('Money_User', $user->User_ID)->whereIn('Money_MoneyAction', [5,6])->orderByDesc('Money_ID')->select('Money_ID', 'Money_USDT', 'Money_USDTFee', 'moneyaction.MoneyAction_Name', 'Money_Rate','Money_Time', 'Money_Comment')->orderBy('Money_Time', 'DESC')->get();
		return view('System.History.Commission', compact('walletHistory'));
	}
	public function getHistoryInvestment(){
        $user = session('user');
        $investmentHistory = Investment::where('investment_User', $user->User_ID)
            ->select('investment_ID', 'investment_Amount', 'investment_Rate', 'investment_Time', 'investment_Status')
            ->orderBy('investment_Time', 'DESC')
            ->get();
		return view('System.History.Investment', compact('investmentHistory'));
	}


	public function getExchangeRate(){
		$rate = DB::table('rate')->orderByDesc('Rate_Time')->paginate(50);
		foreach($rate as $v){
			$v->GPG = DB::table('changes')->where('Changes_Time', $v->Rate_Time)->first()->Changes_Price;
		}
		return view('System.Wallet.ExchangeRate', compact('rate'));
	}

	public function getCancel(){
		if(Session::has('Transfer')){
			Session::forget('Transfer');
			Session::forget('otpADC');
			Session::forget('otpUSDA');
			return redirect()->back()->with(['flash_level'=>'error','flash_message'=>'Canceled Transfer!!']);
		}
		if(Session::has('withdraw')){
			Session::forget('withdraw');
			Session::forget('otpwithdraw');
			return redirect()->back()->with(['flash_level'=>'error','flash_message'=>'Canceled Withdraw!!']);
		}
		Session::forget('BuyADC');
		Session::forget('SellADC');
		return redirect()->back();
	}
	public function postSellExchange(Request $req, $base, $item){
		if($base == 'BTC'){
			$price = $this->coinbase()->getBuyPrice('BTC-USD');
			$rate = $price->getAmount();
		}elseif($base == 'ETH'){
			$price = $this->coinbase()->getBuyPrice('ETH-USD');
			$rate = $price->getAmount();
		}elseif($base == 'TRX'){
			// $trxPrice = json_decode(file_get_contents('https://api.coinmarketcap.com/v2/ticker/1958/'));
			$rate = 0;
		}
		if($item == 'USD'){

			$rateCoin = 1;

		}
		else{
			$rateCoin = DB::table('changes')->where('Changes_Time', date('Y-m-d'))->first()->Changes_Price;
		}
		$priceGPG = $req->amount*$rate / $rateCoin;
		$fee = $priceGPG * $this->fee;
		$balance = $priceGPG - $fee;

		Session::put('SellADC', [$balance,$req->amount]);
		return redirect()->route('system.getExchange',[$base,$item]);
	}

	public function postSellConfirm(Request $req, $base, $item){
		if($item == 'SNT'){
			return redirect()->back()->with(['flash_level'=>'error','flash_message'=>'Error! ']);
		}
		$coin = 0;
		if($base == 'BTC'){
			$coin = 1;
			$price = $this->coinbase()->getBuyPrice('BTC-USD');
			$rate = $price->getAmount();
		}elseif($base == 'ETH'){
			$coin = 2;
			$price = $this->coinbase()->getBuyPrice('ETH-USD');
			$rate = $price->getAmount();
		}elseif($base == 'TRX'){
			$coin = 9;
			// $trxPrice = json_decode(file_get_contents('https://api.coinmarketcap.com/v2/ticker/1958/'));
			$rate = 0;
		}
		if($item == 'USD'){

			$rateCoin = 1;
			$coinItem = 5;

		}else{
			$rateCoin = DB::table('changes')->where('Changes_Time', date('Y-m-d'))->first()->Changes_Price;
			$coinItem = 8;
		}
		$priceGPG = $req->amount*$rate / $rateCoin;
		$fee = $priceGPG * $this->fee;
		$balance = $priceGPG - $fee;

		// kiểm tra balance đủ ko
		$balanceCoin = Money::getBalance(Session::get('user')->User_ID)->$base;

		if($req->amount > $balanceCoin){
			Session::forget('BuyADC');
			return redirect()->back()->with(['flash_level'=>'error','flash_message'=>'Your balance is not enough']);
		}
		// đặt lệnh lên sàn
			$data = array(
			array(
				'Money_User'=>Session::get('user')->User_ID,
				'Money_USDT'=> $priceGPG,
				'Money_USDTFee'=>$fee,
				'Money_Time'=>time(),
				'Money_Comment'=>'Swap Coin From '.$base,
				'Money_MoneyAction'=>14,
				'Money_MoneyStatus'=>1,
				'Money_Currency'=>$coinItem,
				'Money_Rate'=>(float)$rateCoin
			),
			array(
				'Money_User'=>Session::get('user')->User_ID,
				'Money_USDT'=> -(float)$req->amount,
				'Money_USDTFee'=>0,
				'Money_Time'=>time(),
				'Money_Comment'=>'Swap Coin From '.$base.' To '.$item,
				'Money_MoneyAction'=>14,
				'Money_MoneyStatus'=>1,
				'Money_Currency'=>$coin,
				'Money_Rate'=>$rate
			)
		);

		Money::insert($data);

		Session::forget('SellADC');
		return redirect()->back()->with(['flash_level'=>'success','flash_message'=>'Successfully!']);


	}

}
