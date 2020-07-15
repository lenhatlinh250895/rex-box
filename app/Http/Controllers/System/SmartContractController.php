<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use DB;
use App\Models\User; 
use App\Models\Money;
use App\Models\Wallet;
use App\Models\Investment;


class SmartContractController extends Controller
{
	public function getIndex(){
		return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => "Coming Soon!"]);

		$user = Session('user');
	    $rate = app('App\Http\Controllers\System\CoinbaseController')->coinRateBuy();
	    $balance = Money::getBalance($user->User_ID);
		return view('System.Investment.Contract', compact('rate', 'balance', 'investment'));
	}
}