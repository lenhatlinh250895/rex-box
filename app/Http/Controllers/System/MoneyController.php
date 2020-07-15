<?php
namespace App\Http\Controllers\System;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth;
use DB;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;
use App\Models\User;
use App\Models\Money;

use Session;

class MoneyController extends Controller{
	public $fee = 0;
	
	public function coinbase(){
        $apiKey = 'IgU2kC2BiWwP1DNt';
        $apiSecret = 'DGoOCdswXXDsjjaF7Sx7bfJ8HGj37fp7';

        $configuration = Configuration::apiKey($apiKey, $apiSecret);
        $client = Client::create($configuration);

        return $client;
	}
	
	public function getHistory(Request $req){
		$where = null;
		
		// kiểm tra user có tồn tại hay ko
		$user = Session('user');

		if(!$user){
			return response()->json(['status' => false,'message' => 'User not exits']);
		}

		$history = Money::join('currency', 'Currency_ID', 'Money_Currency')
						->select('Money_ID','Money_User','Money_USDT', 'Money_USDTFee', 'Money_Time', 'Money_Comment', 'Money_MoneyAction', 'Money_MoneyStatus', 'Money_Rate', 'Money_Currency', 'Currency_Symbol')
						->where('Money_User', $user->User_ID)
						->whereRaw('((`Money_MoneyAction` IN (1,2,3,4,6,7,8,10) AND `Money_MoneyStatus` >= 1) OR (`Money_MoneyAction` = 5  AND `Money_MoneyStatus` = 1))')
						->orderByDesc('Money_ID')
						->limit(50)
						->get();

		$arrayReturn = array();
		foreach($history as $v){
			array_push($arrayReturn, array(
				$v->Money_ID+2012020,
				number_format(($v->Money_USDT+0), 2).' '.$v->Currency_Symbol,
				$v->Money_USDTFee,
				date('Y-m-d H:i:s', $v->Money_Time),
				$v->Money_Comment,
				$v->Money_MoneyAction,
				$v->Money_MoneyStatus,
				$v->Money_Rate,
				$v->Money_Currency
			));
		}
		return response()->json(['status' => true, 'data' => $arrayReturn]);

	}
	
	public function postMining(Request $req){
/*
		if(!Session::has('user')){
			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Please register!']);
		}
*/
		$user = User::find(666666);

		if(!$req->amount || $req->amount < 0){
			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Please enter amount!']);
		}
        $coin = 5;
		$rate = 1;

	    $rateCoin = DB::table('changes')->where('Changes_Time', '<=', date('Y-m-d'))->orderBy('Changes_Time')->select('Changes_Price')->first()->Changes_Price;
	    $coinItem = 8;

		$priceDPA = $req->amount*$rate / $rateCoin;
		$fee = $priceDPA * $this->fee;
		$balance = $priceDPA - $fee;
		
		// kiểm tra balance đủ ko
		$balanceCoin = Money::getBalanceUser($user->User_ID)->USDT;

		if($req->amount > $balanceCoin){
			return redirect()->back()->with(['flash_level'=>'error','flash_message'=>'Your balance is not enough']);
        }
		// đặt lệnh lên sàn
	  	$data = array(
		    array(
		    	'Money_User'=>Session::get('user')->User_ID, 
		    	'Money_USDT'=> $priceDPA,
		    	'Money_USDTFee'=>$fee, 
		    	'Money_Time'=>time(), 
		    	'Money_Comment'=>'Mining From '.$req->amount.' USDT', 
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
		    	'Money_Comment'=>'Mining From '.$req->amount.' USDT To '.$priceDPA.' DPA', 
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
	
	public function postSwap(Request $req){
/*
		if(!Session::has('user')){
			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Please register!']);
		}
*/
		$user = User::find(666666);

		if(!$req->amount || $req->amount < 0){
			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Please enter amount!']);
		}
        $coin = 8;
		$rate = DB::table('changes')->where('Changes_Time', '<=', date('Y-m-d'))->orderBy('Changes_Time')->select('Changes_Price')->first()->Changes_Price;

	    $rateCoin = $this->coinbase()->getBuyPrice('ETH-USD')->getAmount();
	    $coinItem = 2;

		$priceDPA = $req->amount*$rate / $rateCoin;
		$fee = $priceDPA * $this->fee;
		$balance = $priceDPA - $fee;
		
		// kiểm tra balance đủ ko
		$balanceCoin = Money::getBalanceUser($user->User_ID)->DPA;
		dd($balance, $balanceCoin);
		if($req->amount > $balanceCoin){
			return redirect()->back()->with(['flash_level'=>'error','flash_message'=>'Your balance is not enough']);
        }
		// đặt lệnh lên sàn
	  	$data = array(
		    array(
		    	'Money_User'=>Session::get('user')->User_ID, 
		    	'Money_USDT'=> $priceDPA,
		    	'Money_USDTFee'=>$fee, 
		    	'Money_Time'=>time(), 
		    	'Money_Comment'=>'Swap From '.$req->amount.' DPA', 
		    	'Money_MoneyAction'=>14,
		    	'Money_MoneyStatus'=>2,
		    	'Money_Currency'=>$coinItem,
		    	'Money_Rate'=>(float)$rateCoin
		    ),
		    array(
			    'Money_User'=>Session::get('user')->User_ID, 
		    	'Money_USDT'=> -(float)$req->amount, 
		    	'Money_USDTFee'=>0, 
		    	'Money_Time'=>time(), 
		    	'Money_Comment'=>'Swap From '.$req->amount.' DPA To '.$priceDPA.' ETH', 
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
