<?php

namespace App\Http\Controllers\System;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use App\Models\Profile;
use App\Models\Investment;
use Illuminate\Support\Facades\DB;
use App\Models\Money;
use App\Models\LogMail;
use App\Models\GoogleAuth;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money as CB_Money;

use Excel;
class AdminController extends Controller{

	public $secret = 'KEEHXR8VE0N63aX9LQaYP2RMQM4A5W4I4a4G6gaNX1KC9MV42FWBPP9FYCAABSNP7FO5M5QEURK8AU1T9IRJhN3vK8UTR2VBR4MN';

    const ADDRESS_HEX = '41928c9af0651632157ef27a2cf17ca72c575a4d21';
    const ADDRESS_BASE58 = 'TPL66VK2gCXNCD7EJg9pgJRfqcRazjhUZY';
    const FULL_NODE_API = 'https://api.trongrid.io:8090';
    const SOLIDITY_NODE_API = 'https://api.trongrid.io:8091';

	public function coinbase(){
        $apiKey = 'Ygutdhfy3S3tDG4R';
        $apiSecret = 'T9Nc28q7hSmXvgNOCu5pEDZSEJDTlTVs';

        $configuration = Configuration::apiKey($apiKey, $apiSecret);
        $client = Client::create($configuration);

        return $client;
    }
    
    public function closeRound(){
		$setting = DB::table('setting_ito')->where('setting_ito_DateOpen', '<=', date('Y-m-d H:i:s'))->where('setting_ito_DateClose', '>=', date('Y-m-d H:i:s'))->where('setting_ito_Status', 0)->orderByDesc('setting_ito_DateOpen')->first();
		if(!$setting){
			dd('Error! Not Found');
		}
	    $close = DB::table('setting_ito')->where('setting_ito_ID', $setting->setting_ito_ID)->update(['setting_ito_Status'=>1]);
	    if($close){
		    dd('close success!');
	    }else{
		    dd('Error!');
	    }
    }
    
    public function updateMaxToken(Request $req){
	    $maxtoken = $req->amount;
		$setting = DB::table('setting_ito')->where('setting_ito_DateOpen', '<=', date('Y-m-d H:i:s'))->where('setting_ito_DateClose', '>=', date('Y-m-d H:i:s'))->where('setting_ito_Status', 0)->orderByDesc('setting_ito_DateOpen')->first();
		if(!$setting){
			dd('Error! Not Found');
		}
		$update = DB::table('setting_ito')->where('setting_ito_ID', $setting->setting_ito_ID)->update(['setting_ito_MaxToken'=>$maxtoken]);
	    if($close){
		    dd('Update success!');
	    }else{
		    dd('Error!');
	    }
    }
    
    public function getUpdateITO($id, Request $req){
	    $setting = DB::table('setting_ito')->where('setting_ito_ID', $id)->first();
	    if(!$setting){
		    return redirect()->back()->with(['flash_level'=>'error','flash_message'=>'Error! User is not exist!']);
	    }
	    
    }
    
	public function postInvestAdmin(Request $req){
		$user = User::find(session('user')->User_ID);
        if($user->User_Level != 1){
	        dd('stop');
	    }
	    $rate = app('App\Http\Controllers\System\CoinbaseController')->coinRateBuy();
	    $arrCoin = [1=>'BTC', 2=>'ETH', 5=>'USD', 8=>'RBD'];
	    $getInfo = User::where('User_ID', $req->user)->first();
	    $amount = $req->amount;
	    $coin = $req->coin;
	    if(!$getInfo){
            return redirect()->back()->with(['flash_level'=>'error','flash_message'=>'Error! User is not exist!']);
	    }
	    if(!$amount || $amount <= 0){
            return redirect()->back()->with(['flash_level'=>'error','flash_message'=>'Error! Enter amount > 0!']);
	    }
	    
	    $symbol = $arrCoin[$coin];
		$priceCoin = $rate[$symbol];
		
		$amountUSD = $amount*$priceCoin;
		// thêm gói mới
		$insertInvest = array(
			'investment_User'=>$getInfo->User_ID,
			'investment_Amount'=>$amount,
			'investment_Currency'=>2,
			'investment_Rate'=>$priceCoin,
			'investment_AddressTo'=>'Invest Admin - '.time(),
			'investment_Hash'=>'Invest Admin - '.time(),
			'investment_Time'=>time(),
			'investment_Status'=>1
		);
		
		$invest = Investment::insertGetId($insertInvest);
		
		// tăng ví mining lên 200%
		$percent = 1.5;
		if($amountUSD >= 501){
			$percent = 2;
		}
		if($amountUSD >= 10000){
			$percent = 2.5;
		}
		if($amountUSD >= 100001){
			$percent = 3;
		}
		$miningWallet = array(
			'Money_User' => $getInfo->User_ID,
			'Money_USDT' => $amountUSD*$percent,
			'Money_USDTFee' => 0,
			'Money_Investment' => $invest,
			'Money_Time' => time(),
			'Money_Comment' => 'Insert Mining Box Investment $'.$amountUSD,
			'Money_MoneyAction' => 4,
			'Money_MoneyStatus' => 2,
			'Money_Currency' => 5,
			'Money_Rate' => 1
		);
		$money = Money::insert($miningWallet);
		
		$commission = app('App\Http\Controllers\System\CronController')->checkCommission($getInfo, $amountUSD, 5, 1);
		$commission = app('App\Http\Controllers\System\CronController')->checkAffiliateCommission($getInfo, $amountUSD, 5, 1);
		
        LogMail::insertLog($user, 'Invest From Admin', $user->User_ID.' Invest '.$amount.' '.$symbol.' to '.$getInfo->User_ID);
        return redirect()->back()->with(['flash_level'=>'success','flash_message'=>"Invest $getInfo->User_ID $amount $symbol Success!"]);
	}

	public function postDepositAdmin(Request $req){
		$user = User::find(session('user')->User_ID);
        if($user->User_Level != 1){
	        dd('stop');
	    }
	    $rate = app('App\Http\Controllers\System\CoinbaseController')->coinRateBuy();
	    $arrCoin = [1=>'BTC', 2=>'ETH', 5=>'USD', 8=>'RBD'];
	    $getInfo = User::where('User_ID', $req->user)->first();
	    $amount = $req->amount;
	    $coin = $req->coin;
	    if(!$getInfo){
            return redirect()->back()->with(['flash_level'=>'error','flash_message'=>'Error! User is not exist!']);
	    }
	    if(!$amount || $amount <= 0){
            return redirect()->back()->with(['flash_level'=>'error','flash_message'=>'Error! Enter amount > 0!']);
	    }
	    
	    $symbol = $arrCoin[$coin];
		$priceCoin = $rate[$symbol];
		//deposit
		$money = new Money();
		$money->Money_User = $getInfo->User_ID;
		$money->Money_USDT = $coin == 8 ? $amount/$priceCoin : $amount;
		$money->Money_Time = time();
		$money->Money_Comment = 'Deposit '.$symbol;
		$money->Money_Currency = $coin;
		$money->Money_MoneyAction = 1;
		$money->Money_Address = '';
		$money->Money_CurrentAmount = $amount/$priceCoin;
		$money->Money_Rate = $priceCoin;
		$money->Money_MoneyStatus = 1;
        $money->save();	
        LogMail::insertLog($user, 'Deposit From Admin', $user->User_ID.' Deposit '.$amount.' '.$symbol.' to '.$getInfo->User_ID);
        return redirect()->back()->with(['flash_level'=>'success','flash_message'=>"Deposit $getInfo->User_ID $amount $symbol Success!"]);
	}
	
    public function getMember(Request $req){
        $level = array(1=>'Admin', 0=>'Member', 2=>'Finance', 3=>'Support', 4=>'Customer', 5=>'Bot');
        $user = Session::get('user');
        if ($user->User_Level != 1 && $user->User_Level != 2 && $user->User_Level != 3) {
            dd('Stop');
        }
        $where = null;
        if ($req->UserID) {
            $where .= ' AND User_ID=' . $req->UserID;
        }
        if ($req->Username) {
            $where .= ' AND User_Name LIKE "' . $req->Username . '"';
        }
        if ($req->Email) {
            $where .= ' AND User_Email LIKE "' . $req->Email . '"';
        }
        if ($req->sponsor) {
            $where .= ' AND User_Parent = ' . $req->sponsor;
        }
        if ($req->level) {
            $where .= ' AND User_Agency_Level = ' . $req->level;
        }
        if ($req->datetime) {
            $where .= ' AND date(User_RegisteredDatetime) = "' . date('Y-m-d', strtotime($req->datetime)) . '"';
        }
        if ($req->status != null) {
            $where .= ' AND User_EmailActive = ' . $req->status;
        }
        if ($req->tree != '') {

            $where .= ' AND User_Tree LIKE "' . str_replace(', ', ',', $req->tree) . '%"';
		}
		if ($req->suntree != '') {

            $where .= ' AND User_SunTree LIKE "' . str_replace(', ', ',', $req->suntree) . '%"';
        }
        if ($req->export == 1) {
            if ($user->User_Level != 1 && $user->User_Level != 2) {
                dd('Stop');
            }
            $Member = User::leftJoin('google2fa','google2fa.google2fa_User','users.User_ID')
                ->select('User_SunTree','User_ID', 'google2fa.google2fa_User', 'User_Name', 'User_Email', 'User_RegisteredDatetime', 'User_Tree', 'User_Parent', 'User_EmailActive', 'User_Level')
                ->whereRaw('1 ' . $where)
                ->orderBy('User_RegisteredDatetime', 'DESC')->get();
            $member = array();
            foreach ($Member as $h) {
                if ($h->User_EmailActive == 1) {
                    $h->User_EmailActive = "Active";
                } else {
                    $h->User_EmailActive = "Not Active";
                }
                $member[] = $h;
            }
            // $listMemberExcel[] = array('ID','Email', 'ID Parent','Registred DateTime','Level','Status') ;
            $listMemberExcel[] = array('ID', 'Email', 'Registred DateTime', 'ID Parent', 'Tree', 'Level', 'Status', 'Auth');
            $i = 1;
            foreach ($member as $d) {
                $listMemberExcel[$i][0] = $d->User_ID;
                $listMemberExcel[$i][1] = $d->User_Email;
                $listMemberExcel[$i][2] = $d->User_RegisteredDatetime;
                $listMemberExcel[$i][3] = $d->User_Parent;
				$listMemberExcel[$i][4] = $d->User_Tree;
				$listMemberExcel[$i][5] = $d->User_SunTree;
                $listMemberExcel[$i][6] = $level[$d->User_Level];
                $listMemberExcel[$i][7] = $d->User_EmailActive;
                if($d->google2fa_User){
                    $listMemberExcel[$i][7] = "Enable";
                }
                else{
                    $listMemberExcel[$i][7] = "Disable";
                }
                $i++;
            }

            Excel::create('Member', function ($excel) use ($listMemberExcel) {
                $excel->setTitle('Member');
                $excel->setCreator('Member')->setCompany('SMT');
                $excel->setDescription('Member');
                $excel->sheet('sheet1', function ($sheet) use ($listMemberExcel) {
                    $sheet->fromArray($listMemberExcel, null, 'A1', false, false);
                });
            })->download('xls');
        }
        $memberList = User::leftJoin('google2fa','google2fa.google2fa_User','users.User_ID')
        ->select('User_ID', 'google2fa.google2fa_User', 'User_Name', 'User_Email', 'User_RegisteredDatetime', 'User_Parent', 'User_EmailActive', 'User_Tree','User_Level', 'User_SunTree', 'User_Agency_Level')
        ->whereRaw('1 ' . $where)
        ->orderBy('User_RegisteredDatetime', 'DESC');
        // dd(memberList->get());
        $memberList = $memberList->paginate(15);
        return view('System.Admin.Member', compact('memberList', 'level'));
    }


/*
	public function getDetailMember($id){
		$user = User::find($id);
		$balance = Money::getBalance($user->User_ID);
		$parents = OrderController::getParents($user->User_ID);
		$F1 = User::where('User_Parent',$user->User_ID)->count();
		return view('System.Admin.Profile-Admin',compact('user','balance','parents','F1'));
	}
*/

/*
	public function getHistoryDetail($id){
		$user = Session('user');
		if(Input::get('confirm')){
			if(Input::get('confirm') == 1){
				$checkConfirm = Money::getCheckConfirm($id);

			}
		}

		$detail = Money::GetHistoryDetail($id);

		return view('System.Admin.History-Detail',compact('detail'));

	}
*/

    public function getLoginByID($id){
	    $user = session('user');
        if($user->User_Level == 1 || $user->User_Level == 2 || $user->User_Level == 3){
            $userLogin = User::find($id);
            if($userLogin){
                Session::put('userTemp', $user);
                Session::put('user', $userLogin);
                return redirect()->route('system.dashboard')->with(['flash_level'=>'success','flash_message'=>'Login Success']);
            }
        }else{
            echo 'Stop';exit;
        }
    }
	public function postExportMember(Request $req){
		if(Session('user')->User_Level != 1 && Session('user')->User_Level != 2){
			dd('stop');
		}
		$Member = User::getExportMemberAdmin(' '.$req->member);
		$member = array();
		foreach($Member as $h){
			if($h->User_Verify == 1){
				$h->User_Verify = "Verified";
			}else{
				$h->User_Verify = "Unverified";
			}
			$member[] = $h;
		}
		//xuất excel
		$listMemberExcel[] = array('ID','Email','ID Parent','Registred DateTime','Level','Status') ;
		$i = 1;
			foreach ($member as $d)
			{
				$listMemberExcel[$i][0] = $d->User_ID;
				$listMemberExcel[$i][1] = $d->User_Email;
				$listMemberExcel[$i][2] = $d->User_Parent;
				$listMemberExcel[$i][3] = $d->User_RegisteredDatetime;
				$listMemberExcel[$i][4] = $d->User_Level;
				$listMemberExcel[$i][5] = $d->User_Verify;
				$i++;
			}

		Excel::create('Member', function($excel) use ($listMemberExcel) {
			$excel->setTitle('Member');
			$excel->setCreator('Member')->setCompany('SMT');
			$excel->setDescription('Member');
			$excel->sheet('sheet1', function ($sheet) use ($listMemberExcel) {
				$sheet->fromArray($listMemberExcel, null, 'A1', false, false);
			});
		})->download('xls');

	}


	public function getStatistical(){

        $level = array(1=>'Admin', 0=>'Member', 2=>'Finance', 3=>'Support', 4=>'Customer', 5=>'Bot');
		$where = null;
		$whereBlance = null;
		if(Input::get('from')){
			$from = strtotime(date('Y-m-d',strtotime(Input::get('from'))));
			$where .= ' AND Money_Time >= '.$from;
		}
		if(Input::get('to')){
			$to = strtotime('+1 day',strtotime(date('Y-m-d',strtotime(Input::get('to')))));
			$where .= ' AND Money_Time < '.$to;
		}
		$Statistic = Money::getStatistic($where);

		$Total = Money::StatisticTotal($where);
		if(Input::get('User_ID')){
			$Statistic = $Statistic->where('Money_User', Input::get('User_ID'));
		}

		if(Input::get('User_Level') != null){
			$Statistic = $Statistic->where('User_Level', Input::get('User_Level'));
		}

		$Statistic = $Statistic->get();
		$Total = $Total->get()[0];

		return view('System.Admin.Statistic', compact('Statistic','Total', 'level'));
	}


	public function getWallet(Request $request){
        $level = array(1=>'Admin', 0=>'Member', 2=>'Finance', 3=>'Support', 4=>'Customer', 5=>'Bot');
        $walletList = Money::join('currency', 'Money_Currency', '=', 'currency.Currency_ID')
            ->join('moneyaction', 'Money_MoneyAction', '=', 'moneyaction.MoneyAction_ID')
            ->join('users', 'Money_User', 'users.User_ID')
            ->select('User_Email', 'User_Tree', 'User_SunTree','Money_ID', 'Money_User','users.User_Level','Money_MoneyAction', 'Money_USDT','Money_Currency', 'Money_USDTFee', 'Money_Time','currency.Currency_Name', 'Currency_Symbol', 'moneyaction.MoneyAction_Name', 'Money_Comment', 'Money_MoneyStatus', 'Money_Confirm', 'Money_Rate', 'Money_CurrentAmount', 'Money_Address');
        if ($request->id) {
            $walletList = $walletList->where('Money_ID', intval($request->id));
        }
        if ($request->user_id) {
            $walletList = $walletList->where('Money_User', $request->user_id);
		}
		if ($request->email) {
            $walletList = $walletList->where('User_Email', $request->email);
        }
        if ($request->action) {
            $walletList = $walletList->where('Money_MoneyAction',$request->action);
        }
        if (isset($request->status) and $request->status != 2) {
            $walletList = $walletList->where('Money_Confirm', $request->status);
        }
        if ($request->datefrom and $request->dateto) {
            $walletList = $walletList->where('Money_Time', '>=', strtotime($request->datefrom))
                ->where('Money_Time', '<', strtotime($request->dateto) + 86400);
        }
        if ($request->datefrom and !$request->dateto) {
            $walletList = $walletList->where('Money_Time', '>=',strtotime($request->datefrom));

        }
        if (!$request->datefrom and $request->dateto) {
            $walletList = $walletList->where('Money_Time', '<', strtotime($request->dateto) + 86400);

        }
        if($request->export){
            Excel::create('History-Wallet'.date('YmdHis'), function($excel) use ($walletList, $level) {
                $excel->sheet('report', function($sheet) use($walletList, $level) {
                    $sheet->appendRow(array(
                        'ID','User ID', 'Email', 'User Level', 'Action','Comment','DateTime','Amount Coin', 'Currency','Rate', 'USD', 'Fee Coin', 'Fee USD', 'Status', 'Transaction / Address'
                    ));
                    $walletList->chunk(2000, function($rows) use ($sheet, $level){
                        foreach ($rows as $row){
							
                            // if($row->Money_Confirm == 1){
                            //     $row->Money_Confirm = "Success";
                            // }
                            // if($row->Money_Confirm == 0){
							// 	dd($row);
                            //     $row->Money_Confirm = "Pending";
                            // }
                            // else {
                            //     $row->Money_Confirm = "Cancel";
							// }
							
							if($row->Money_MoneyStatus == 1){
								if($row->Money_MoneyAction == 2 && $row->Money_Confirm == 0){
									$row->Money_Confirm = "Pending";
								}
								else{
									$row->Money_Confirm = "Success";
								}

							}
							else
							{
								$row->Money_Confirm = "Cancel";
							}
                            $sheet->appendRow(array(

								$row->Money_ID,
								$row->Money_User,
								$row->User_Email,
								$level[$row->User_Level],
								$row->MoneyAction_Name,
								$row->Money_Comment,
								date('Y-m-d H:i:s',$row->Money_Time),
								$row->Money_Currency == 8 ? $row->Money_USDT : $row->Money_USDT/$row->Money_Rate,
								$row->Currency_Symbol,
								$row->Money_Rate,
								$row->Money_Currency != 8 ? $row->Money_USDT : $row->Money_USDT*$row->Money_Rate,
								$row->Money_Currency != 8 ? $row->Money_USDTFee/$row->Money_Rate : $row->Money_USDTFee,
								$row->Money_Currency == 8 ? $row->Money_USDTFee*$row->Money_Rate : $row->Money_USDTFee,
								$row->Money_Confirm,
								$row->Money_Address,
                            ));
                        }
                    });

                });
            })->export('xlsx');
        }
        $walletList = $walletList->orderByDesc('Money_ID')->paginate(50);
        $action = DB::table('moneyaction')->get();
		return view('System.Admin.Wallet', compact('walletList', 'action', 'level'));
	}

	public function getFindWallet(){
		$user = Session('user');
		if($user->User_Level != 1 and $user->User_Level != 2 and $user->User_Level != 3){
			return redirect()->back();
		}
		$level = array(1=>'Admin', 0=>'Member', 2=>'Finance', 3=>'Support', 4=>'Customer');

		$wallet = Money::Select('Money_ID', 'Money_User','User_Level','Money_Confirm', 'User_Name','user_level_Name','Money_MoneyAction', 'MoneyAction_Name','Money_USDT', 'Money_USDTFee', 'Money_Comment', 'Money_MoneyStatus', 'Money_Time', 'Money_Currency', 'Currency_Symbol', 'Money_CurrentAmount', 'Money_Rate')
						->Join('users', 'Money_User', 'User_ID')
						->Join('currency', 'Money_Currency', 'Currency_ID')
						->join('moneyaction', 'MoneyAction_ID', 'Money_MoneyAction')
						->join('user_level', 'User_Agency_Level', 'user_level_ID')
						->OrderBy('Money_ID', 'DESC');

		if(Input::get('Money_ID')){
			$wallet = $wallet->where('Money_ID',(int)Input::get('Money_ID'));
		}
		if(Input::get('Money_User')){
			$wallet = $wallet->where('Money_User',(int)Input::get('Money_User'));
		}
		if(Input::get('Money_MoneyAction')){
			$wallet = $wallet->where('Money_MoneyAction',(int)Input::get('Money_MoneyAction'));
		}
		if(Input::get('Money_Comment')){
			$wallet = $wallet->where('Money_Comment', 'like', '%'.Input::get('Money_Comment').'%');
		}
		if(Input::get('from') && Input::get('to')){
			$startDate = strtotime(date('Y-m-d',strtotime(Input::get('from'))));
			$endDate = strtotime('+1 day',strtotime(date('Y-m-d',strtotime(Input::get('to')))));
			$wallet = $wallet->where('Money_Time', '>=', $startDate);
			$wallet = $wallet->where('Money_Time', '<', $endDate);
		}

		if(Input::get('export')){
			if(Session('user')->User_Level != 1 && Session('user')->User_Level != 2){
				dd('stop');
			}
			$history = $wallet->get();

			$listHistory = array();
			//convert data
			foreach($history as $h){

				if($h->Money_MoneyStatus == 1){
					if($h->Money_MoneyAction == 2 && $h->Money_Confirm == 0){
						$h->Money_MoneyStatus = "Processing";
					}else{
						$h->Money_MoneyStatus = "Success";
					}
				}else{
					$h->Money_MoneyStatus = "Cancel";
				}

				$listHistory[] = $h;
			}
			//xuất excel
			$listHistoryExcel[] = array('ID','User ID', 'User Level', 'Action','Comment','DateTime','Amount Coin', 'Currency', 'USD', 'Fee', 'Fee USD', 'Status') ;
			$i = 1;

			foreach ($listHistory as $d)
			{
				$listHistoryExcel[$i][0] = $d->Money_ID;
				$listHistoryExcel[$i][1] = $d->Money_User;
				$listHistoryExcel[$i][2] = $level[$d->User_Level];
				$listHistoryExcel[$i][3] = $d->MoneyAction_Name;
				$listHistoryExcel[$i][4] = $d->Money_Comment;
				$listHistoryExcel[$i][5] = date('Y-m-d H:i:s',$d->Money_Time);
				$listHistoryExcel[$i][6] = $d->Money_USDT+0;
				$listHistoryExcel[$i][7] = $d->Currency_Symbol;
				$listHistoryExcel[$i][8] = $d->Money_USDT*$d->Money_Rate+0;
				$listHistoryExcel[$i][9] = $d->Money_USDTFee+0;
				$listHistoryExcel[$i][10] = $d->Money_USDTFee*$d->Money_Rate+0;
				$listHistoryExcel[$i][11] = $d->Money_MoneyStatus;
				$i++;
			}

			Excel::create('History-Wallet'.date('YmdHis'), function($excel) use ($listHistoryExcel) {
				$excel->setTitle('History-Wallet'.date('YmdHis'));
				$excel->setCreator('History-Wallet'.date('YmdHis'))->setCompany('UPBANK');
				$excel->setDescription('History-Wallet'.date('YmdHis'));
				$excel->sheet('sheet1', function ($sheet) use ($listHistoryExcel) {
					$sheet->fromArray($listHistoryExcel, null, 'A1', false, false);
				});
			})->download('xls');
		}
		$total = $wallet->count();
		$wallet = $wallet->paginate(50);
		$action = DB::table('moneyaction')->get();
		return view('System.FindWallet.FindWallet', compact('wallet','action', 'total', 'level'));
	}
	public function getWalletDetail($id){
		if(Session('user')->User_Level != 1 && Session('user')->User_Level != 2){
			return redirect()->back();
		}
		$detail = Money::Join('currency', 'Money_Currency', 'Currency_ID')->Join('users', 'Money_User', 'User_ID')->join('moneyaction', 'MoneyAction_ID', 'Money_MoneyAction')->where('Money_ID', $id)->first();

		if(Input::get('confirm')){
			if(Session('user')->User_Level != 1 && Session('user')->User_Level != 2){
				return redirect()->route('system.admin.getWallet')->with(['flash_level'=>'error', 'flash_message'=>'You cannot use this function']);
			}
			if(Input::get('confirm') == 1){
				LogMail::insertLog(Session('user'), 'Confirm Withdraw', Session('user')->User_ID.' Confirm Withdraw ID: '.$id);
				$checkConfirm = Money::getCheckConfirm($id);

				if($checkConfirm && $checkConfirm->Money_Confirm == 0){
					// Update


					if(($checkConfirm->Money_Currency == 1 || $checkConfirm->Money_Currency == 2)){

						// kiểm tra ví đó nội sàn hay ngoại sàn
						$address = DB::table('address')->where('Address_Currency', $checkConfirm->Money_Currency)->where('Address_Address', $checkConfirm->Money_Address)->first();
						if($address){
							// chuyển tiền nội sàn coinbase
							Money::where('Money_ID',$id)->update(['Money_Confirm'=>1]);

							$Currency = DB::table('currency')->where('Currency_ID', $checkConfirm->Money_Currency)->first();
							$rate = $this->coinbase()->getSellPrice($Currency->Currency_Symbol.'-USD')->getamount();
							// nạp tiền cho user cần chuyển
							$moneyArray = array(
							    'Money_User' => $address->Address_User,
							    'Money_USDT' => abs($checkConfirm->Money_USDT),
							    'Money_USDTFee' => 0,
							    'Money_Time' => time(),
								'Money_Comment' => 'Deposit '.$Currency->Currency_Symbol,
								'Money_MoneyAction' => 1,
								'Money_MoneyStatus' => 1,
								'Money_CurrentAmount' => $checkConfirm->Money_CurrentAmount,
								'Money_Rate' => $rate,
								'Money_Address' => 'Deposit from UserID: '.$checkConfirm->Money_User,
								'Money_Currency' => $checkConfirm->Money_Currency,

							);
							DB::table('money')->insert($moneyArray);
							return redirect()->route('system.admin.getWallet')->with(['flash_level'=>'success', 'flash_message'=>'Confirm Successfully.']);
						}else{
							// rút tiền ra khỏi coinbase
							$Currency = $checkConfirm->Money_Currency == 1 ? "BTC" : "ETH";
							$amountReal = abs($checkConfirm->Money_CurrentAmount);
							if($checkConfirm->Money_Currency == 2){
								$cb_account = 'ETH';
								$rate = $this->coinbase()->getSellPrice('ETH-USD')->getamount();
								$newMoney = new CB_Money($amountReal, CurrencyCode::ETH);
							}elseif($checkConfirm->Money_Currency == 1){
								$cb_account = 'BTC';
								$rate = $this->coinbase()->getSellPrice('BTC-USD')->getamount();
								$newMoney = new CB_Money($amountReal, CurrencyCode::BTC);
							}

							// Amount

							$transaction = Transaction::send([
								'toBitcoinAddress' => $checkConfirm->Money_Address,
								'amount'           => $newMoney,
								'description'      => $checkConfirm->Money_User.' Withdraw!'
							]);


							$account = $this->coinbase()->getAccount($cb_account);

							try {
								$a = $this->coinbase()->createAccountTransaction($account, $transaction);

								Money::where('Money_ID',$id)->update(['Money_Confirm'=>1]);
								//Money::where('Money_ID',$id)->update(['Money_MoneyStatus'=>1]);


								return redirect()->route('system.admin.getWallet')->with(['flash_level'=>'success', 'flash_message'=>'Confirm Successfully.']);
							}catch (\Exception $e) {
								return redirect()->route('system.admin.getWallet')->with(['flash_level'=>'error', 'flash_message'=>$e->getMessage()]);
							}
						}
					}elseif($checkConfirm && ($checkConfirm->Money_Currency == 8 || $checkConfirm->Money_Currency == 9)){
						Money::where('Money_ID',$id)->update(['Money_Confirm'=>1,'Money_MoneyStatus'=>1]);
					}
					
				}else{
					return redirect()->route('system.admin.getWallet')->with(['flash_level'=>'error', 'flash_message'=>'Error!']);
				}
			}elseif(Input::get('confirm') == -1){
				LogMail::insertLog(Session('user'), 'Cancel Withdraw', Session('user')->User_ID.' Cancel Withdraw ID: '.$id);

				$checkConfirm = Money::getCheckConfirm($id);
				if(!$checkConfirm && $checkConfirm->Money_Confirm != 0){
					return redirect()->route('system.admin.getWallet')->with(['flash_level'=>'error', 'flash_message'=>'Error!']);
				}
				Money::where('Money_ID',$id)->update(['Money_Confirm'=>-1,'Money_MoneyStatus'=>-1]);
				//Gửi telegram thông báo Cancel Withdraw
/*
				$message = "Cancel Withdraw \n"
						. "<b>Withdraw ID: </b>\n"
						. "$id\n"
						. "<b>Email Cancel: </b>\n"
						. "$user->User_Email\n"
						. "<b>Cancel Withdraw Time: </b>\n"
						. date('d-m-Y H:i:s',time());

				TelegramBotController::sendMessage($message);
*/
				return redirect()->route('system.admin.getWallet')->with(['flash_type'=>'error', 'flash_message'=>'Cancel Success!']);
			}
		}

		return view('System.Admin.WalletDetail', compact('detail'));
	}

	public function getPercent(){
		if(Session('user')->User_Level != 1){
			return redirect()->back();
		}
		$percentBTC = DB::table('percent')->where('Percent_Coin', 1)->where('Percent_Time', '>=', date('Y-m-d'))->orderBy('Percent_Time')->get();
		$percentETH = DB::table('percent')->where('Percent_Coin', 2)->where('Percent_Time', '>=', date('Y-m-d'))->orderBy('Percent_Time')->get();
		$percentBCH = DB::table('percent')->where('Percent_Coin', 6)->where('Percent_Time', '>=', date('Y-m-d'))->orderBy('Percent_Time')->get();
		$percentLTC = DB::table('percent')->where('Percent_Coin', 7)->where('Percent_Time', '>=', date('Y-m-d'))->orderBy('Percent_Time')->get();
		$percentUPT1 = DB::table('percent')->where('Percent_Coin', 8)->where('Percent_Time', '>=', date('Y-m-d'))->where('Percent_Min', 50)->orderBy('Percent_Time')->get();
		$percentUPT2 = DB::table('percent')->where('Percent_Coin', 8)->where('Percent_Time', '>=', date('Y-m-d'))->where('Percent_Min', 1001)->orderBy('Percent_Time')->get();
		$percentUPT3 = DB::table('percent')->where('Percent_Coin', 8)->where('Percent_Time', '>=', date('Y-m-d'))->where('Percent_Min', 5001)->orderBy('Percent_Time')->get();
		$percentUPT4 = DB::table('percent')->where('Percent_Coin', 8)->where('Percent_Time', '>=', date('Y-m-d'))->where('Percent_Min', 50001)->orderBy('Percent_Time')->get();
// 		dd($percentUPT1,$percentUPT2,$percentUPT3,$percentUPT4);
		return view('System.Admin.Percent', compact('percentBTC', 'percentETH', 'percentBCH', 'percentLTC', 'percentUPT1', 'percentUPT2', 'percentUPT3', 'percentUPT4'));
	}

	public function postChangePercent(Request $req){
		if(Session('user')->User_Level != 1){
			dd('stop');
		}
		$percent = DB::table('percent')->where('Percent_ID', $req->ID)->update(['Percent_Percent'=>$req->Percent]);

		return redirect()->back()->with(['flash_level'=>'success','flash_message'=>'Change % Success!']);

	}

	public function getPriceToken(){
		if(Session('user')->User_Level != 1 && Session('user')->User_Level != 3){
			return redirect()->back();
		}
		$PriceToken = DB::table('changes')->where('Changes_Time', '>=', date('Y-m-d'))->where('Changes_Time', '<=', date('Y-m-d', strtotime('+3 month')))->orderBy('Changes_Time')->paginate(50);
		return view('System.Admin.PriceToken', compact('PriceToken'));
	}

	public function postPriceToken(Request $req){
		if(Session('user')->User_Level != 1){
			dd('stop');
		}
		$priceOld = $req->priceOld;
		$percent = DB::table('changes')->where('Changes_ID', $req->ID)->update(['Changes_Price'=>$req->Price, 'Changes_User'=>Session('user')->User_ID]);
        LogMail::insertLog(Session('user'), 'Update Price Token', Session('user')->User_ID.' Update Price From '.$priceOld.' To '.$req->Price);

		return redirect()->back()->with(['flash_level'=>'success','flash_message'=>'Change Price Success!']);
	}

	public function getInvestment(Request $request){
        $investmentList = Investment::join('currency', 'investment_Currency', '=', 'currency.Currency_ID')
            ->join('users', 'investment_User', 'users.User_ID')
            ->select(DB::raw('investment_ID, users.User_Level, investment_User, investment_Currency, investment_Amount, investment_Rate, investment_Time, currency.Currency_Name, investment_Status, investment_Amount* investment_Rate as amountUSD'));
        if ($request->id) {
            $investmentList = $investmentList->where('investment_ID', intval($request->id));
        }
        if ($request->user_id) {
            $investmentList = $investmentList->where('investment_User', $request->user_id);
        }
        if ($request->email) {
            $searchUserID = User::where('User_Email', $request->email)->value('User_ID');
            $investmentList = $investmentList->where('investment_User', $searchUserID);
        }
        if ($request->status) {
            $investmentList = $investmentList->where('investment_Status', $request->status);
        }
        if ($request->datefrom and $request->dateto) {
            $investmentList = $investmentList->where('investment_Time', '>=', strtotime($request->datefrom))
                ->where('investment_Time', '<', strtotime($request->dateto) + 86400);
        }
        if ($request->datefrom and !$request->dateto) {
            $investmentList = $investmentList->where('investment_Time', '>=',strtotime($request->datefrom));

        }
        if (!$request->datefrom and $request->dateto) {
            $investmentList = $investmentList->where('investment_Time', '<', strtotime($request->dateto) + 86400);

        }
        $investmentList = $investmentList->orderByDesc('investment_Time')->paginate(30);
		return view('System.Admin.Investment', compact('investmentList'));
	}
	public function getWithdraw(){
		return view('System.Admin.Withdraw');
	}
	public function getProfile(Request $request){
        $profileList =  new Profile();
        if ($request->email) {
            $searchUserID = User::where('User_Email', $request->email)->value('User_ID');
            if ($searchUserID) {
                $profileList = Profile::where('Profile_User', $searchUserID);
            }
        }
        if ($request->user_id){
            $profileList = $profileList->where('Profile_User', $request->user_id);
        }

        if ($request->id) {
            $profileList = $profileList->where('Profile_ID', $request->id);
        }
        if ($request->status != null){
            $profileList = $profileList->where('Profile_Status', $request->status);
        }
        if ($request->datefrom and $request->dateto) {
            $profileList = $profileList->whereRaw("DATE_FORMAT(Profile_Time, '%Y-%m-%d') >= '$request->datefrom' AND DATE_FORMAT(Profile_Time, '%Y-%m-%d') <= '$request->dateto' ");
        }
        if ($request->datefrom and !$request->dateto) {
            $profileList = $profileList->whereRaw("DATE_FORMAT(Profile_Time, '%Y-%m-%d') >= '$request->datefrom'");

        }
        if (!$request->datefrom and $request->dateto) {
            $profileList = $profileList->whereRaw("DATE_FORMAT(Profile_Time, '%Y-%m-%d') <= '$request->dateto'");

        }
        $profileList = $profileList->get();

        return view('System.Admin.Profile', compact('profileList'));
	}
    public function confirmProfile(Request $request) {
        if ($request->action == 1){
            $updateProfileStatus = Profile::where('Profile_ID', $request->id)->update(['Profile_Status' => 1]);
            if ($updateProfileStatus) {
                $data = [];
                $user = Profile::join('users', 'Profile_User', 'users.User_ID')
                    ->where('Profile_ID', $request->id)
                    ->select('users.User_Email')
                    ->first();
                MailConfirmProfileSuccess($data, $user->User_Email);

                return response()->json(['status' => 'success', 'message' =>'confirmed!'], 200);
            }
            return response()->json(['status' => 'error', 'message' =>'Error, please contact admin!'], 200);
        }
        if ($request->action == -1) {
            $user = Profile::join('users', 'Profile_User', 'users.User_ID')
                ->where('Profile_ID', $request->id)
                ->select('users.User_Email')->first();
            $updateProfileStatus = Profile::where('Profile_ID', $request->id)->delete();
            if ($updateProfileStatus) {
                $data = [];
                MailConfirmProfileError($data, $user->User_Email);
                return response()->json(['status' => 'success', 'message' =>'Disagreed!'], 200);
            }
            return response()->json(['status' => 'error', 'message' =>'Error, please contact admin!'], 200);
        }

    }
	public function getTicket(){
		return view('System.Admin.Ticket');
	}
	public function getDetailTicket(){
		return view('System.Admin.DetailTicket');
	}

	public function postAddPriceToken(Request $req){
/*
		if(!$req->time0){
			return redirect()->back()->with(['flash_level'=>'error','flash_message'=>'Add Price 0 Hour!']);
		}
*/
		$user = Session('user');

		if(Session('user')->User_Level != 1){
			dd('stop');
		}
		if(!$req->datetime){
			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Chose Date For Price']);
		}

		$changes = array(
			'Changes_User'=>$user->User_ID,
			'Changes_Time'=>date('Y-m-d',strtotime($req->datetime)),
		);

		if($req->time0){

			$changes['Changes_Price'] = $req->time0;
			$changes['Changes_Hour'] = 00;
			DB::table('changes')->insert($changes);

		}
		if($req->time12){

			$changes['Changes_Price'] = $req->time12;
			$changes['Changes_Hour'] = 12;
			DB::table('changes')->insert($changes);

		}
		if($req->time18){
			$changes['Changes_Price'] = $req->time18;
			$changes['Changes_Hour'] = 18;

			DB::table('changes')->insert($changes);
		}


		return redirect()->back()->with(['flash_level'=>'error','flash_message'=>'Chose Date Of Price!']);

	}
	public function getFindWallet1(Request $req){
		$result = DB::table('address')
    					->join('currency', 'Address_Currency', 'Currency_ID')
                        ->select('Address_Address','Address_ID','Address_User', 'Currency_Symbol', 'Address_Currency')
                        ->where('Address_IsUse',0);
		if($req->UserID){
			$result ->where('Address_User',$req->UserID);
		}
		if($req->Address){
			$result ->where('Address_Address',$req->Address);
		}
		if($req->Currency){
			$result ->where('Address_Currency',$req->Currency);

		}
		$result = $result->paginate(20);
		return view('System.Admin.FindWallet',compact('result'));
	}
	public function getDeposit(){
		return view('System.Admin.Deposit');
	}
	public function postDeposit(Request $req){
		$user = Session('user');
		$this->validate($req,[
            'UserID' => 'required|numeric',
            'Currency' => 'required|numeric',
            'Amount' => 'required|numeric|min:0',
            'AddressWallet' => 'required',

		]);
		if($user->User_Level != 1){
			dd('stop');
		}
        //check money_address
        $addressExit = DB::table('money')->where('Money_Address', $req->AddressWallet)->first();

        if($addressExit != null){
			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'
The transaction already exists!']);
		}

		if($req->Currency == 0){
			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Please select the coin']);
		}

		//kiểm tra user có chưa
		$userExit = DB::table('users')->where('User_EmailActive', 1)->where('User_ID',$req->UserID)->first();
		if($userExit == null){
			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'User does not exist!']);
		}
		//kiẻm tra ví có đủ tiền ko???
		$balance = Money::getBalance($user->User_ID);
		$getCoinBalance = 0;
		$coinArr = [1=>'BTC', 2=>'ETH', 5=>'USD', 8=>'UPBT', 9=>'TRX'];
		$coinSymbol = $coinArr[$req->Currency];
		$getCoinBalance = $balance->$coinSymbol;

		if($req->Amount > $getCoinBalance){
// 			return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Not enough balance!']);
		}
		// $checkCoin[1] = 'BTC';
		// $checkCoin[2] = 'ETH';
		// $checkCoin[5] = 'USD';
		// $checkCoin[8] = 'ONZ';

		//tỉ giá
		$coin = array('BTC'=>0, 'ETH'=>0, 'LTC'=>0, 'BCH'=>0, 'USD'=>1);
		$priceCoin = app('App\Http\Controllers\System\InvestmentController')->getPrice();
		$coin['TRX'] = $priceCoin->tron;
	    $coin['BTC'] = $priceCoin->bitcoin;
	    $coin['ETH'] = $priceCoin->ethereum;
	    $coin['LTC'] = $priceCoin->litecoin;
	    $coin['BCH'] = $priceCoin->bitcoincash;

		$tokenPrice = DB::table('changes')->where('Changes_Time', date('Y-m-d'))->where('Changes_Hour', '<=', date('H'))->orderBy('Changes_Hour', 'DESC')->first();
		if(!$tokenPrice){
			$getPrice = DB::table('changes')->where('Changes_Time', '<', date('Y-m-d'))->orderByDesc('Changes_Time')->first();
			$data = ['Changes_Price'=>$getPrice->Changes_Price, 'Changes_Time'=>date('Y-m-d'), 'Changes_Status'=>1, 'Changes_User'=>$user->User_ID ];
			DB::table('changes')->insert($data);
			$tokenPrice = DB::table('changes')->where('Changes_Time', date('Y-m-d'))->first();
		}
		$coin['ONZ'] = $tokenPrice->Changes_Price;
		$rate[1] = $coin['BTC'];
		$rate[2] = $coin['ETH'];
		$rate[9] = $coin['TRX'];
		$rate[8] = $coin['ONZ'];
		$rate[5] = 1;
		// trừ tiền
	    $moneyArray = array(
		    'Money_User' => $user->User_ID,
		    'Money_USDT' => -$req->Amount,
		    'Money_USDTFee' => 0,
		    'Money_Time' => time(),
			'Money_Comment' => $req->Comment,
			'Money_MoneyAction' => 1,
			'Money_MoneyStatus' => 1,
			'Money_Rate' => $rate[$req->Currency],
			'Money_Currency' => $req->Currency
	    );

	    //DB::table('money')->insert($moneyArray);
		//Cộng tieèn
	    $moneyArray = array(
		    'Money_User' => $req->UserID,
		    'Money_USDT' => $req->Amount,
		    'Money_USDTFee' => 0,
		    'Money_Time' => time(),
			'Money_Comment' => $req->Comment,
			'Money_MoneyAction' => 1,
			'Money_MoneyStatus' => 1,
			'Money_Rate' => $rate[$req->Currency],
			'Money_Address' => $req->AddressWallet,
			'Money_Currency' => $req->Currency,

		);
		DB::table('money')->insert($moneyArray);
		return redirect()->back()->with(['flash_level'=>'success', 'flash_message'=>'Success']);
	}
	

    public function getEditMailByID(Request $req){
        // dd($req->new_email);
        $check_id = User::where('User_ID',$req->id_user)->first();
        if($check_id){
            $check_mail = User::where('User_Email',$req->new_email)->first();
            if(!$check_mail){
                $cmt_log = "Change mail: ".$check_id->User_Email ." -> ". $req->new_email;
                LogMail::insertLog(Session('user'), "Change Mail", $cmt_log);
                $check_id->User_Email = $req->new_email;
                $check_id->save();
                return 1;
            }
            return 0;
        }
        return -1;
	}
	public function getActiveMail($id){
        $check_user = User::where('User_ID',$id)->first();
        if(!$check_user){
            return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => 'User ID is not exits!']);
        }
        $cmt_log = "Active Mail ID User: " . $id;
        LogMail::insertLog(Session('user'), "Active Mail", $cmt_log);
        $check_user->User_EmailActive = 1;
        $check_user->save();
        return redirect()->back()->with(['flash_level' => 'success', 'flash_message' => 'Active mail!']);
	}
	public function getDisableAuth($id){
        if(Session('user')->User_Level == 1){
            $check_auth = GoogleAuth::where('google2fa_User',$id)->delete();
            if($check_auth){
                $cmt_log = "Disable Auth ID User: " . $id;
                LogMail::insertLog(Session('user'), "Disable Auth", $cmt_log);
                return redirect()->back()->with(['flash_level' => 'success', 'flash_message' => 'Successfully Deleted Auth!']);
            }
            return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => 'Auth Delete Failed!']);
        }
        return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => 'Error!']);
	}
	//Log Mail List
    public function getLogMail(Request $request)
    {
        $logMails = LogMail::join('users', 'Log_User', 'users.User_ID')
            ->select('User_Email', 'Log_User', 'Log_Content', 'Log_Datetime', 'Log_User', 'Log_Action', 'Log_ID');
        if ($request->UserID) {
            $logMails = $logMails->where('Log_User', $request->UserID);
        }
        if ($request->Email) {
            $logMails = $logMails->where('User_Email', $request->Email);
        }
        if ($request->Content) {
            $logMails = $logMails->where('Log_Comment', 'like', "%$request->Content%");
        }
        $logMails = $logMails->orderByDesc('Log_Datetime')->paginate(15);
        return view('System.Admin.Log-Mail', compact('logMails'));
    }
}
