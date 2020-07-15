<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Models\Money;
use App\Models\User;
use App\Models\Investment;

use DB;

class DashboardController extends Controller
{
	public function getDashboard(){
//     	return redirect()->route('getIndex');
		$user = Session('user');
	    $rate = app('App\Http\Controllers\System\CoinbaseController')->coinRateBuy();
	    $balance = Money::getBalance($user->User_ID);
	    $history = Money::join('moneyaction', 'MoneyAction_ID', 'Money_MoneyAction')->where('Money_MoneyStatus', 1)->where('Money_User', $user->User_ID)->get();
	    $data = DB::table('changes')->groupBy('Changes_Time')->orderBy('Changes_Time')->select('Changes_Time','Changes_Price')->get();
	    foreach($data as $d){
		    $chartPrice['xAxis'][] = $d->Changes_Time;
		    $chartPrice['series'][] = $d->Changes_Price;
	    }
	    
        $noti_image = DB::table('NotificationImage')->where('Status', 0)->where('Location_Exchange', 1)->get(); 
// 	    dd($chartPrice);
		return view('System.Dashboard.Dashboard',compact('rate', 'balance', 'history', 'chartPrice', 'noti_image'));
	}
}
