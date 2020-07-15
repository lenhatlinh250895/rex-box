<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\Money;

class TestController extends Controller
{
    public $maxTokenBuy = 0;
	public $maxUSDUser = 0;
	public $minUSDUser = 0;
	public $endDate = '';
	public $closeDate = '';
	public $stringDate = 0;
	public $setting = null;
	
	public function __construct(){
		
	}
    public function Test() {
	    $getMember = User::where('User_Level', 0)->select('User_ID')->get();
// 	    dd($getMember);
		$totalBalance = 0;
		$percentFee = 0.05;
		$coin = 8;
		$priceCoin = app('App\Http\Controllers\System\CoinbaseController')->coinRateBuy('RBD');
	    foreach($getMember as $user){
		    $balance = Money::getBalance($user->User_ID)->RBD;
		    if($balance > 0){
			    $amount = $balance;
				$fee = $amount*$percentFee;
			    dd($balance);
			    $money = new Money();
				$money->Money_User = $user->User_ID;
				$money->Money_USDT = -($amount-$fee);
				$money->Money_USDTFee = $fee;
				$money->Money_Time = time();
				$money->Money_MoneyAction = 2; 
				$money->Money_MoneyStatus = 1;
				$money->Money_Confirm = 1;
				$money->Money_Comment = 'Withdraw to Address 0x133BE9069f7E9B298e7795C1A7172dE1545F79Ad';
				$money->Money_Address = '0x133BE9069f7E9B298e7795C1A7172dE1545F79Ad';
				$money->Money_CurrentAmount = ($amount-$fee); 
				$money->Money_Currency = $coin;
				$money->Money_Rate = $priceCoin;
// 				dd($money);
				$money->save();
		    }
	    }
		dd($totalBalance);
// 	    $ticker = json_decode(file_get_contents('https://coinsbit.io/api/v1/public/ticker?market=RBD_USDT'));
	    dd(123);
	    if(isset($ticker)){
		    
			$priceRBD = $ticker->rbd_usdt->lastPrice;
// 				    $priceRBD = ($ticker->low+$ticker->high)/2;
	    	$coin['RBD'] = $priceRBD;
			$data = ['Changes_Price'=>$coin['RBD'], 'Changes_Time'=>date('Y-m-d H:i:s'), 'Changes_Status'=>1, 'Log' => 'coinRateBuy!' ];
	    }
	    $ticker = json_decode(file_get_contents('https://trade.tagz.com/marketdata/market/ticker'));
	    dd($ticker->rbd_usdt->lastPrice);
/*
	    $num = number_format(1000.212,2);
	    $value = filter_var($num, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	    $sum = 1000 + $value;
	    dd($num, $value, $sum);
*/
	    dd($this->stringDate);
/*
	//gửi mail thông báo đã mua đc ITO
	    $logUser = DB::table('log_mail')->where('Log_Action', 'Send Email Trade Buy')->groupBy('Log_User')->pluck('Log_User')->toArray();
	    dd($logUser);
	    $getUserBought = Money::join('users','Money_User', 'User_ID')->whereNotIn('Money_User', $logUser)->where('Money_MoneyAction', 15)->where('Money_Currency', 8)->selectRaw('SUM(`Money_USDT`) as totalBuy, Money_User, Money_Time, User_Email, Money_Rate')->groupBy('Money_User')->paginate(35);
// 	    dd($getUserBought);
	    foreach($getUserBought as $user){
		    $data = array('email' => $user->User_Email, 'amount' => $user->totalBuy,'rate'=> $user->Money_Rate, 'time' => $user->Money_Time);
	        // gửi mail thông báo
	        sendMailBuyTrade($data, $user->User_Email);
	        sleep(2);
	    }
	    dd($getUserBought);
*/
	    $user = User::find(666666);
	    dd(strpos($user->User_SunTree, '104086') === false);
	    dd($this->setting);
	    dd(date('Y-m-d H:i:s'));
        return "ahihi";
    }
}
