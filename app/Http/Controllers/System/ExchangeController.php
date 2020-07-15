<?php
namespace App\Http\Controllers\System;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session; 
use Illuminate\Support\Facades\Auth;
use DB;

use App\Models\Investment;
use App\Models\Money;
use App\Models\User;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;


class ExchangeController extends Controller{
	
	public $channel = -338172029;
	
	public function getExchange(){
		$user = Session('user');
	    $rate = app('App\Http\Controllers\System\CoinbaseController')->coinRateBuy();
	    $balance = Money::getBalance($user->User_ID);
	    $history = Money::join('moneyaction', 'MoneyAction_ID', 'Money_MoneyAction')->where('Money_MoneyStatus', 1)->where('Money_User', $user->User_ID)->get();
		return view('System.Wallet.Exchange', compact('rate', 'balance', 'history'));
	}
	
	
	
	public function getCheckSwap(Request $req){
		$user = Session('user');
		if($req->_a < 0 || !$req->_a){
			return response()->json(['status' => false,'message' => 'Amount > 0']);
		}
		
		// kiểm tra tổng số tiền invest
		$invest = Investment::getPackage($user->User_ID);
		$tokenPrice = DB::table('changes')->where('Changes_Time', date('Y-m-d'))->where('Changes_Hour', '<=', date('H'))->orderBy('Changes_Hour', 'DESC')->first();

		// kiểm tra số tiền swap trong ngày
		$swap = Money::where('Money_MoneyAction', 10)
						->where('Money_Time', '>=', strtotime(date('Y-m-d')))
						->where('Money_Time', '<', strtotime(date('Y-m-d'))+86400)
						->where('Money_User', $user->User_ID)
						->where('Money_MoneyStatus', 1)
						->where('Money_Currency', 5)->sum('Money_USDT');

		if(($req->_a*$tokenPrice->Changes_Price) > ($invest - abs($swap))){
			return response()->json(['status' => false,'message' => 'Your total investment packages is '.number_format($invest,2).'$. Today, you have swapped '.number_format(abs($swap),2).'$ so you are only allowed to swap the remaining '.number_format($invest - abs($swap), 2).'$']);
		}
		
		return response()->json(['status' => true]); 

	}
	
	public function postExchange(Request $req){
		$user = Session('user');
// 		return response()->json(['status' => false,'message' => 'Please Come Back Later!']);
		// kiểm tra balance USDT
		$balance = Money::getBalance($user->User_ID);

		
		if($req->_a < 0){
			return response()->json(['status' => false,'message' => 'Amount > 0']);
		}
		
		if($req->_a > $balance->USD){
			return response()->json(['status' => false,'message' => 'Account balance is not enough']);
		}
	    $rate = app('App\Http\Controllers\System\CoinbaseController')->coinRateBuy();
		$amountToken = $req->_a / $rate['RBD'];
		
		// trừ và cộng tiền
		$inserArr = array(
			array(
				'Money_User' => $user->User_ID,
				'Money_USDT' => -$req->_a,
				'Money_USDTFee' => 0,
				'Money_Investment' => 0,
				'Money_Time' => time(),
				'Money_Comment' => 'Exchange USDM to RBD',
				'Money_MoneyAction' => 10,
				'Money_MoneyStatus' => 1,
				'Money_Currency' => 5,
				'Money_Rate' => 1
			),
			array(
				'Money_User' => $user->User_ID,
				'Money_USDT' => $amountToken,
				'Money_USDTFee' => 0,
				'Money_Investment' => 0,
				'Money_Time' => time(),
				'Money_Comment' => 'Exchange RBD from USDM',
				'Money_MoneyAction' => 10,
				'Money_MoneyStatus' => 2,
				'Money_Currency' => 8,
				'Money_Rate' => $rate['RBD']
			)

		);
		
		// thêm vào bảng swap
		$insertSwap = array(
			'swap_User' => $user->User_ID,
			'swap_Amount'=> $req->_a,
			'swap_Currency' => 5,
			'swap_Time' => date('Y-m-d H:i:s'),
			'swap_Status' => 0
		);
		DB::table('swap')->insert($insertSwap);
		//$Currency = $data->Money_Currency == 1 ? "BTC" : ($data->Money_Currency == 2 ? "ETH" : "TRX");
	    
		//Gửi telegram thông báo User verify
/*
		$message = "Swap Coin User: $user->User_ID\n"
				. "From: <b>$req->_a</b> USDM\n"
				. "To: <b>$amountToken</b> RBD\n"
				. "Address: <b>$user->User_WalletAddress</b>\n"
				. "<b>Submit Swap Coin Time: </b>\n"
				. date('d-m-Y H:i:s',time());
		
	    $client = new \GuzzleHttp\Client(); //GuzzleHttp\Client
	    $result = json_decode($client->request('POST', 'https://adcgame.club/api/sendMessage',[
										'form_params' => [
											'channel' => $this->channel,
											'message' => $message
										]
									])->getBody()->getContents());
*/

		
		Money::insert($inserArr);
		return response()->json(['status' => true,'message' => 'Exchange complete']);
		
	}
	
	public function getRate(){
		$coin = array('BTC'=>0, 'ETH'=>0, 'LTC'=>0, 'BCH'=>0, 'USD'=>1, 'TRX'=>0);
	    $coin['BTC'] = $this->coinbase()->getBuyPrice('BTC-USD')->getAmount();
	    $coin['ETH'] = $this->coinbase()->getBuyPrice('ETH-USD')->getAmount();
	    $coin['LTC'] = $this->coinbase()->getBuyPrice('LTC-USD')->getAmount();
		$coin['BCH'] = $this->coinbase()->getBuyPrice('BCH-USD')->getAmount();
		$tokenPrice = DB::table('changes')->where('Changes_Time', date('Y-m-d'))->where('Changes_Hour', '<=', date('H'))->orderBy('Changes_Hour', 'DESC')->first();
		if(!$tokenPrice){
			$getPrice = DB::table('changes')->orderByDesc('Changes_Time')->first();
			$data = ['Changes_Price'=>$getPrice->Changes_Price, 'Changes_Time'=>date('Y-m-d'), 'Changes_Status'=>1 ];
			DB::table('changes')->insert($data);
			$tokenPrice = DB::table('changes')->where('Changes_Time', date('Y-m-d'))->first();
		}
		$coin['PAY'] = $tokenPrice->Changes_Price;
		return $coin;
	}
	
	public function coinbase(){
        $apiKey = 'IgU2kC2BiWwP1DNt';
        $apiSecret = 'DGoOCdswXXDsjjaF7Sx7bfJ8HGj37fp7';

        $configuration = Configuration::apiKey($apiKey, $apiSecret);
        $client = Client::create($configuration);

        return $client;
	}
	
	public function swapRBDToETH(Request $req){
		$user = Session('user');
		if($req->_a < 0){
			return response()->json(['status' => false,'message' => 'Amount > 0']);
		}
		
		$inserArr = array(
			'swap_User' => $user->User_ID,
			'swap_Amount' => $req->_a,
			'swap_Currency' => 8,
			'swap_Time' => date('Y-m-d H:i:s'),
			'swap_Status' => 0
		);
		
		DB::table('swap')->insert($inserArr);
		
		$ETHPrice = $this->coinbase()->getBuyPrice('ETH-USD')->getAmount();
		$tokenPrice = DB::table('changes')->where('Changes_Time', date('Y-m-d'))->where('Changes_Hour', '<=', date('H'))->orderBy('Changes_Hour', 'DESC')->first();
		if(!$tokenPrice){
			$getPrice = DB::table('changes')->orderByDesc('Changes_Time')->first();
			$data = ['Changes_Price'=>$getPrice->Changes_Price, 'Changes_Time'=>date('Y-m-d'), 'Changes_Status'=>1 ];
			DB::table('changes')->insert($data);
			$tokenPrice = DB::table('changes')->where('Changes_Time', date('Y-m-d'))->first();
		}

		$aa = $req->_a * $tokenPrice->Changes_Price;
		$tttt = ($aa/$ETHPrice)*0.88;
				
/*
		$message = "************ SWAP RBD TO ETH *************\n"
				."********************************************\n"
				."********************************************\n"
				."Swap Coin User: $user->User_ID\n"
				. "From: <b>$req->_a</b> RBD\n"
				. "To: <b>$tttt</b> ETH\n"
				. "Address: <b>$user->User_WalletAddress</b>\n"
				. "<b>Submit Swap Coin Time: </b>\n"
				. date('d-m-Y H:i:s',time());
		
		
	    $client = new \GuzzleHttp\Client(); //GuzzleHttp\Client
	    $result = json_decode($client->request('POST', 'https://adcgame.club/api/sendMessage',[
										'form_params' => [
											'channel' => $this->channel,
											'message' => $message
										]
									])->getBody()->getContents());
*/
		return response()->json(['status' => true]);
	}
	
	
}
