<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;

use Mail;

use DB;
use App\Models\User; 
use App\Models\Money;
use App\Models\Wallet;
use App\Models\Investment;

class InvestmentController extends Controller{
    
    public function getInvestment(){
		return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => "Coming Soon!"]);




		$user = Session('user');
	    $rate = app('App\Http\Controllers\System\CoinbaseController')->coinRateBuy();
	    $balance = Money::getBalance($user->User_ID);
		$investment = Investment::join('currency','investment_Currency', 'Currency_ID')->where('investment_User', $user->User_ID)->get();
		return view('System.Investment.Index', compact('rate', 'balance', 'investment'));
    }
    
	public function postPackage(Request $req){
		
		// kiểm tra user có tồn tại hay không
		$user = User::checkUserExits($req->wallet);
		$currency = DB::table('currency')->where('Currency_Symbol', $req->currency)->first();
		if(!$currency){
			return response()->json(['status' => false,'message' => 'Curency not exits']);
		}
		
		// kiểm tra lệnh này đc insert vào db chưa
		$invest = Investment::where('investment_Hash', $req->hash)->first();
		if($invest){
			return response()->json(['status' => false,'message' => 'Package exits']);
		}
		
		if($user){
			$insertArray = array(
				'investment_User' => $user->User_ID,
				'investment_Amount' => 0,
				'investment_Currency' => $currency->Currency_ID,
				'investment_Rate' => 0,
				'investment_AddressTo' => $req->address,
				'investment_Hash' => $req->hash,
				'investment_Time' => time(),
				'investment_Status' => 0
			);
			//$Investment = Investment::insert($insertArray);
			if($Investment){
				return response()->json(['status' => true,'message' => 'join package complete']);
			}
		}else{
			return response()->json(['status' => false,'message' => 'User not exits']);
		}
	}
	
}
