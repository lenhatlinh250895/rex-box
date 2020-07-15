<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use DB;

use App\Models\User; 
use App\Models\Money;
use App\Models\Wallet;
class TradeController extends Controller
{
    public $maxTokenBuy = 0;
	public $maxUSDUser = 0;
	public $minUSDUser = 0;
	public $endDate = '';
	public $closeDate = '';
	public $stringDate = 0;
	public $setting = null;
	
	public function __construct(){
		$setting = DB::table('setting_ito')->where('setting_ito_DateOpen', '<=', date('Y-m-d H:i:s'))->where('setting_ito_DateClose', '>=', date('Y-m-d H:i:s'))->where('setting_ito_Status', 0)->orderByDesc('setting_ito_DateOpen')->first();
		if(!$setting){
			$setting = DB::table('setting_ito')->where('setting_ito_DateOpen', '>=', date('Y-m-d H:i:s'))->orderBy('setting_ito_DateOpen')->first();
		}
// 		dd($setting);
		$this->setting = $setting;
		$this->stringDate = strtotime($setting->setting_ito_DateOpen);
		$this->maxTokenBuy = $setting->setting_ito_MaxToken;
		$this->maxUSDUser = $setting->setting_ito_MaxUSDUser;
		$this->minUSDUser = $setting->setting_ito_MinUSDUser;
		$this->endDate = $setting->setting_ito_DateOpen;
		$this->closeDate = $setting->setting_ito_DateClose;
	}
	
	public function getIndex(){
// 	    if(Session('user')->User_ID != 829790){
		    return redirect()->route('system.dashboard')->with(['flash_level'=>'error', 'flash_message'=>'Please return to the next batch!']);
// 	    }
		$user = Session('user');
	    $rate = app('App\Http\Controllers\System\CoinbaseController')->coinRateBuy();
	    $balance = Money::getBalance($user->User_ID);
		$current = date('Y-m-d H:i:s');
		$checkCurrent = 0;
		$endDate = $this->endDate;
		if($current < $this->endDate){
			$checkCurrent = 0;
		} else {
			$checkCurrent = 1;
		}
		//tính tổng số RBD đã mua
		$getBalanceRBD = DB::table('money')->where('Money_MoneyStatus', 1)->where('Money_User', $user->User_ID)->where('Money_MoneyAction',15)->whereRaw('Money_Comment like "Buy%"')->where('Money_Currency', 8)->sum('Money_USDT');
		$getTotalSell = DB::table('money')->where('Money_MoneyStatus', 1)->where('Money_User', $user->User_ID)->where('Money_MoneyAction',17)->where('Money_Currency', 8)->sum('Money_USDT');
		
		return view('System.Trade.Index', compact('balance', 'rate', 'endDate', 'checkCurrent', 'getBalanceRBD', 'getTotalSell'));
	}
	
    public function postTradeBuy(Request $req){
	    if(Session('user')->User_ID != 829790){
		    return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Please return to the next batch!']);
	    }
	    
        $this->validate($req, [
            'g-recaptcha-response'=>'required'
        ]);
		$user = Session('user');
/*
		if($user->User_ID != 732365	&& $user->User_ID != 668939){
			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Not yet open for sale!']);
		}
*/
        $client = new \GuzzleHttp\Client(); 
        $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => '6LfOtccUAAAAABI-3lqeiLE6sElEP22OO7zKb9TR',
                'response' => $req->input('g-recaptcha-response'),
            ]
        ]);
        $checkCaptcha = json_decode($response->getBody())->success;
        if($checkCaptcha == false){
            return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Captcha is wrong!']);
        }
        
		$current = date('Y-m-d H:i:s');
		if($current < $this->endDate){
			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Not yet open for sale!']);
		}
		
	    $balance = Money::getBalance($user->User_ID);
		$this->validate($req,[
            'amount' => 'required|numeric|min:0',
        ]);
	    if(!$req->amount && $req->amount <= 0){
		    return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Please enter amount RBD']);
	    }
	    //giới hạn min $100 max $1000
	    if($req->amount < $this->minUSDUser){
		    return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Must greater than $100']);
		}
	    if($req->amount > $this->maxUSDUser){
// 		    return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Must not be less than $'.$this->maxUSDUser]);
		}

		$amount = $req->amount;
		$coin = 5;
		//kiểm tra ví có đử tiền không???
	    $rate['RBD'] = app('App\Http\Controllers\System\CoinbaseController')->coinRateBuy('RBD');
		$RateOfCoin = 1;
		$feeTrade = 0.00;
		$RBDPriceToCoin = $amount*$RateOfCoin/$rate['RBD'];
		$feeRBDPriceToCoin = $RBDPriceToCoin*($feeTrade);
		//kiểm tra người dùng đã mua có vươth 200.000
		$coinCheckMax = 5;
		//date round 2
		$limitRound = strtotime('2020-02-14');
		$getBoughtUSD = DB::table('money')->where('Money_MoneyStatus', 1)->where('Money_User', $user->User_ID)->where('Money_MoneyAction',15)->whereRaw('Money_Comment like "Buy%"')->where('Money_Time', '>=', $limitRound)->where('Money_Currency', $coinCheckMax)->sum('Money_USDT');
		
		if((abs($getBoughtUSD)+($req->amount)) > $this->maxUSDUser){
// 			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'You cannot purchase more than '.$this->maxUSDUser.'  USD']);
		}
		//check tổng mua
        $getRBDDay = Money::join('users', 'Money_User', 'User_ID')->whereNotIn('User_Level', [1,2,3,4])->where('Money_MoneyAction', 15)->where('Money_Currency', 8)->where('Money_Time', '>=', $this->stringDate)->where('Money_MoneyStatus', 1)->sum('Money_USDT');
        if($getRBDDay+$RBDPriceToCoin > $this->maxTokenBuy){
// 		    return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>' The amount of RBD today has ended, please return to the next batch!']);
        }
        //check balance
		if($amount > $balance->USD){
			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Your balance isn\'t enough!']);
		}
        
		//Mua RBD
	    $moneyArray = array(
		    'Money_User' => $user->User_ID,
		    'Money_USDT' => -$amount,
		    'Money_USDTFee' => 0,
		    'Money_Time' => time(),
			'Money_Comment' => 'Buy '.$RBDPriceToCoin.' RBD',
			'Money_MoneyAction' => 15,
			'Money_MoneyStatus' => 1,
			'Money_Rate' => $RateOfCoin,
			'Money_Currency' => $coin
	    );
	    DB::table('money')->insert($moneyArray);
	    
	    // cộng RBD
	    $moneyArray = array(
		    'Money_User' => $user->User_ID,
		    'Money_USDT' => $RBDPriceToCoin,
		    'Money_USDTFee' => $feeRBDPriceToCoin,
		    'Money_Time' => time(),
			'Money_Comment' => 'Buy '.$RBDPriceToCoin.' RBD From $ '.$amount,
			'Money_MoneyAction' => 15,
			'Money_MoneyStatus' => 1,
			'Money_Rate' => $rate['RBD'],
			'Money_Currency' => 8
	    );
	    DB::table('money')->insert($moneyArray);
	    
/*
	    $percent = 0.1;
		$direct_commission = array(
							//user parent
			'Money_User' => $user->User_Parent,
			'Money_USDT' => $percent*$req->amount,
			'Money_USDTFee' => 0,
			'Money_Time' => time(),
			'Money_Comment' => 'Direct Commission From ID '. $user->User_ID .' Buy ' . $RBDPriceToCoin . ' RBD',
			'Money_MoneyAction' => 5,
			'Money_MoneyStatus' => 1,
			'Money_Rate' => $rate['RBD'],
			'Money_Currency' => 8
		);
		DB::table('money')->insert($direct_commission);
*/
		// nhánh 104086 ko nhận hh
		if(strpos($user->User_SunTree, '104086') === false){
			$this->checkCommission($user, $amount);
		}
		// exit();
	    return redirect()->back()->with(['flash_level'=>'success', 'flash_message'=>'Buy '.$RBDPriceToCoin.' RBD Success!']);
    }
    
    public function checkCommission($user, $amount){
	    $percentArr = [1=>0.06, 2=>0.03, 3=>0.02];
        $arrParent = explode(',', $user->User_SunTree);
        $arrParent = array_reverse($arrParent);
        for($i = 1; $i <= 3; $i++){
	        if(!isset($arrParent[$i])){
				continue;
			}
			$getInfo = User::find($arrParent[$i]);
			if(!$getInfo){
				continue;
			}
			$checkBuyITO = Money::where([
										['Money_User', $getInfo->User_ID],
										['Money_MoneyStatus', 1],
										['Money_MoneyAction', 15],
										['Money_Currency', 5]
										])
								->groupBy('Money_User')
								->first();
			if(!$checkBuyITO){
				continue;
			}
			$countChildBuyITO = Money::join('users', 'User_ID', 'Money_User')
									->where([
											['User_Parent', $getInfo->User_ID],
											['Money_MoneyStatus', 1],
											['Money_MoneyAction', 15],
											['Money_Currency', 5]
											])
									->groupBy('Money_User')
									->get()->count();
			if($countChildBuyITO < $i){
				continue;
			}

			$directCom = array(
				'Money_User' => $getInfo->User_ID,
				'Money_USDT' => $amount*$percentArr[$i],
				'Money_USDTFee' => 0,
				'Money_Time' => time(),
				'Money_Comment' => 'Commission From F'.$i.' User ID: '.$user->User_ID.'',
				'Money_MoneyAction' => 16,
				'Money_MoneyStatus' => 1,
				'Money_Currency' => 5,
				'Money_Rate' => 1
			);
			$money = Money::insert($directCom);
        }
    }
	
    public function postTradeSell(Request $req){
		    return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'The amount of RBD today has ended, please return to the next batch!']);

        $this->validate($req, [
            'g-recaptcha-response'=>'required'
        ]);
		$user = Session('user');
		if($user->User_ID != 245414){
// 			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Coming Soon!']);
		}
        $client = new \GuzzleHttp\Client(); 
        $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => '6LfOtccUAAAAABI-3lqeiLE6sElEP22OO7zKb9TR',
                'response' => $req->input('g-recaptcha-response'),
            ]
        ]);
        $checkCaptcha = json_decode($response->getBody())->success;
        if($checkCaptcha == false){
            return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Captcha is wrong!']);
        }
        
		$current = date('Y-m-d H:i:s');
		if($current < $this->endDate){
// 			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Not yet open for sale!']);
		}
		
	    $balance = Money::getBalance($user->User_ID);
		$this->validate($req,[
            'amount' => 'required|numeric|min:0',
        ]);
	    if(!$req->amount && $req->amount <= 0){
		    return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Please enter amount RBD']);
	    }
	    /*
if($req->amount < $this->minUSDUser || $req->amount > $this->maxUSDUser){
		    return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Must not be less than $1000 and greater than $100']);
		}
*/
		//Amount USD
		$amount = $req->amount;
		$coin = 5;
		//kiểm tra ví có đử tiền không???
	    $rate['RBD'] = app('App\Http\Controllers\System\CoinbaseController')->coinRateBuy('RBD');
		$RateOfCoin = 1;
		$feeTrade = 0.05;
		$RBDPriceToCoin = $amount*$RateOfCoin/$rate['RBD'];
		$feeUSD = $amount*($feeTrade);
		
		//kiểm tra người dùng đã mua có vươth 200.000
		/*
$coinCheckMax = 5;
		$getBoughtUSD = DB::table('money')->where('Money_MoneyStatus', 1)->where('Money_User', $user->User_ID)->where('Money_MoneyAction',15)->whereRaw('Money_Comment like "Buy%"')->where('Money_Currency', $coinCheckMax)->sum('Money_USDT');
		
		if((abs($getBoughtUSD)+($req->amount)) > $this->maxUSDUser){
			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'You cannot purchase more than '.$this->maxUSDUser.'  USD']);
		}
*/
		
		//kiểm tra tổng bán
        /*
$getRBDDay = Money::join('users', 'Money_User', 'User_ID')->whereNotIn('User_Level', [1,2,3,4])->where('Money_MoneyAction', 17)->where('Money_Currency', 8)->where('Money_Time', '>=', $this->stringDate)->where('Money_MoneyStatus', 1)->sum('Money_USDT');

        if($getRBDDay+$RBDPriceToCoin > $this->maxTokenBuy){
		    return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>' The amount of RBD today has ended, please return to the next batch!']);
        }
*/
        //check balance RBD
		if($RBDPriceToCoin > $balance->RBD){
			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Your balance isn\'t enough!']);
		}
	    
	    // trừ tiền
	    $moneyArray = array(
		    'Money_User' => $user->User_ID,
		    'Money_USDT' => -$RBDPriceToCoin,
		    'Money_USDTFee' => 0,
		    'Money_Time' => time(),
			'Money_Comment' => 'Sell '.$RBDPriceToCoin.' RBD To $ '.$amount,
			'Money_MoneyAction' => 17,
			'Money_MoneyStatus' => 1,
			'Money_Rate' => $rate['RBD'],
			'Money_Currency' => 8
	    );
	    DB::table('money')->insert($moneyArray);
        
		//Bán RBD
	    $moneyArray = array(
		    'Money_User' => $user->User_ID,
		    'Money_USDT' => $amount,
		    'Money_USDTFee' => $feeUSD,
		    'Money_Time' => time(),
			'Money_Comment' => 'Sell '.$RBDPriceToCoin.' RBD',
			'Money_MoneyAction' => 17,
			'Money_MoneyStatus' => 1,
			'Money_Rate' => $RateOfCoin,
			'Money_Currency' => $coin
	    );
	    DB::table('money')->insert($moneyArray);

	    return redirect()->back()->with(['flash_level'=>'success', 'flash_message'=>'Sell '.$RBDPriceToCoin.' RBD Success!']);
    }
}