<?php
namespace App\Http\Controllers\Cron;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Money;
use App\Models\User;
use App\Models\Investment;
use App\Models\Wallet;
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money as CB_Money;
use IEXBase\TronAPI\Tron;
use Carbon\Carbon;

use DB;
// Queue
use App\Jobs\SendCoinJobs;
use App\Jobs\SendMailJobs;
use App\Jobs\SendTelegramJobs;

class CronController extends Controller{
	public static function coinbase(){
        $apiKey = 'XlIdz7GYS3OfgPkb';
        $apiSecret = 'a3RR59mcFqAtlQ8KlPs0vTViVxP6Is3b';

        $configuration = Configuration::apiKey($apiKey, $apiSecret);
        $client = Client::create($configuration);

        return $client;
    }
    
    public function getCheckSendMailRefund(){
	    $ListMoney = Money::where('Money_MoneyAction', 9)->where('Money_Confirm', 0)->where('Money_MoneyStatus', 1)->get();
	    foreach($ListMoney as $money){
		    $user = User::find($money->Money_User);
		    if( $user->User_ID != 123123){
			    continue;
		    }
		    $data = array('ID'=>$user->User_ID, 'amount'=>$money->Money_USDT+0, 'address'=>$user->User_WalletETH, 'id'=>$money->Money_ID);
			$token = urlencode(encrypt($data));
			$data['token'] = $token;
	        dispatch(new SendMailJobs($user, $data, 'RefundInvest', 'Refund Investment'));
	    }
	    dd('check and send mail refund success!');
    }
    
    public function getSendMail(){
	    $timeStartSendMail = 1568689210;
	    $transactions = app('App\Http\Controllers\System\CoinbaseController')->getAccountTransactions('ETH');
	    $arrAction = ['Interest'=>4, 'Commission'=>10, 'Invest'=>13];
        foreach($transactions as $v){
	        $amount = $v->getamount()->getamount();
	        if($amount < 0 && $v->getStatus() == "completed"){
// 		        dd($v);
		        $getDescription = $v->getdescription();
				$arrDescription = explode(' ', $getDescription);
				if(!isset($arrDescription[0])){
					continue;
				}
				$userID = $arrDescription[0];
		        $action = $arrDescription[count($arrDescription) - 1];
				if(!isset($arrAction[$action])){
					continue;
				}
				$moneyAction = $arrAction[$action];
		        $money = Money::where('Money_Time', '>=', $timeStartSendMail)
		        				->where('Money_User', $userID)
		        				->where('Money_MoneyAction', $moneyAction)->where('Money_Confirm', 0)->first();
		        if(!$money){
			        continue;
		        }
		        $address = $v->getTo()->getaddress();
		        $transaction = $v->getNetwork()->gethash();
		        $money->Money_Confirm = 1;
		        $money->save();
		        $user = User::find($money->Money_User);
		        if($action == 'Interest'){
			        $data = array('ID'=>$user->User_ID, 'amount'=>abs($amount), 'address'=>$address, 'investID'=>$money->Money_Investment, 'transaction'=>$transaction);
					dispatch(new SendMailJobs($user, $data, 'MailProfit', 'Send Profit To Your Wallet'));
		        }elseif($action == 'Commission'){
			        $data = array('ID'=>$user->User_ID, 'amount'=>abs($amount), 'address'=>$address, 'transaction'=>$transaction);
					dispatch(new SendMailJobs($user, $data, 'MailCommission', 'Send Commission To Your Wallet'));
		        }elseif($action == 'Invest'){
			        $data = array('ID'=>$user->User_ID, 'amount'=>abs($amount), 'address'=>$address, 'investID'=>$money->Money_Investment, 'transaction'=>$transaction);
					dispatch(new SendMailJobs($user, $data, 'MailRefund', 'Send Refund Invest To Your Wallet'));
		        }
	        }
        }
    }
    
    public function getDeposit(Request $req){
	    
	    $coin = DB::table('currency')->where('Currency_Symbol', $req->coin)->first();
	    if(!$coin){
		    dd('coin not exit');
	    }
	    $symbol = $coin->Currency_Symbol;
	    $blockcypher = 'https://api.blockcypher.com/v1/'.strtolower($symbol).'/main/txs/';
	    $rate = app('App\Http\Controllers\System\CoinbaseController')->coinRateBuy();
	    $transactions = app('App\Http\Controllers\System\CoinbaseController')->getAccountTransactions($symbol);
	    $priceCoin = $rate[$symbol];
	    $tokenPrice = $rate['RBD'];
	    
        foreach($transactions as $v){
	        if($v->getamount()->getamount() > 0){
				$hash = Money::where('Money_Address', $v->getnetwork()->gethash())->first();
				
				if(!$hash){
					$client = new \GuzzleHttp\Client();
					$res = $client->request('GET', $blockcypher.$v->getnetwork()->gethash());
					$response = $res->getBody(); 
					$json = json_decode($response);
					
					$addArray = array();
					
					foreach($json->addresses as $j){
						if($coin->Currency_Symbol == 'ETH'){
							$addArray[] = '0x'.$j;	
						}else{
							$addArray[] = $j;	
						}
					}
					
					$address = Wallet::select('Address_User')->whereIn('Address_Address', $addArray)->first();

					if($address){
                        $amount = $v->getamount()->getamount();

						$money = new Money();
						$money->Money_User = $address->Address_User;
						$money->Money_USDT = $amount*$priceCoin;
						$money->Money_Time = time();
						$money->Money_Comment = 'Deposit '.($amount+0).' '.$symbol;
						$money->Money_Currency = $coin->Currency_ID;
						$money->Money_MoneyAction = 1;
						$money->Money_Address = $v->getnetwork()->gethash();
						$money->Money_CurrentAmount = $amount;
						$money->Money_Rate = $priceCoin;
						$money->Money_MoneyStatus = 1;
                        $money->save();	

					}
					
				}   
		    }
        }
		echo 123;exit;
    }
// function cộng tiền hoa hồng cho user
    public function checkCommission($user, $amount, $currency, $rate){
        // hoa hồng trực tiếp 
        $percent = 0.08;
/*
        $getInvestRefund = Investment::where('investment_User', $user->User_ID)->where('investment_Status', 2)->max('investment_Amount');
        
        if($getInvestRefund){
	        if($amount >= $getInvestRefund){
		        $amount -= $getInvestRefund;
	        }else{
		        return false;
	        }
        }
*/
        $getMaxPackage = Money::where('Money_User', $user->User_ID)->where('Money_MoneyAction', 9)->where('Money_MoneyStatus', 1)->max('Money_USDT');
        if($getMaxPackage && $getMaxPackage > 0){
	        $getInvestActive = (Investment::where('investment_User', $user->User_ID)->where('investment_Status', 1)->sum('investment_Amount'));
	        if($getInvestActive < $getMaxPackage){
		        return false;
	        }
	        if(($getInvestActive - $amount) < $getMaxPackage){
		        $amount = $getInvestActive - $getMaxPackage;
		        if($amount <= 0){
			        return false;
		        }
	        }
        }
        $amountCom = $amount * $percent;
        $user = User::find($user->User_ID);
        if($user->User_Level == 4 || $user->User_Level == 5){
	        return false;
        }
        $parent = User::where('User_ID', $user->User_Parent)->first();
        if(!$parent){
            return false;
        }
        $amountCom = $amountCom * $rate;
        $checkCom = $this->checkInvestBalance($parent->User_ID, $amountCom, $rate);
        if($checkCom === true || $checkCom > 0){
	        if($checkCom !== true){
		        $amountCom = $checkCom/$rate;
	        }
            $money = new Money();
            $money->Money_User = $parent->User_ID;
            $money->Money_USDT = $amountCom;
            $money->Money_Time = time();
            $money->Money_Comment = 'Direct Commission From User ID: '.$user->User_ID;
            $money->Money_Currency = $currency;
            $money->Money_MoneyAction = 5;
            $money->Money_Address = '';
            $money->Money_Rate = $rate;
            $money->Money_MoneyStatus = 1;
            $money->save();
			//check refund gói
			$this->checkRefundInvest($parent->User_ID);
        }
        
	    $this->sendCoin([5,6,7,8,10,12], 12);
    }
// function check update level
    public function UpdateLevel($user, $arrLevel = []){
		
        // hoa hồng nhị phân 
        $arrParent = explode(',', $user->User_Tree);
        $arrParent = array_reverse($arrParent);
        
        for($i = 1; $i<count($arrParent); $i++){
//             $parentTree = User::find($arrParent[$i]);
            $parentTree = User::find(216185);
            if(!$parentTree){
                continue;
            }
            $getInvestUser = Investment::where('investment_User', $parentTree->User_ID)->where('investment_Status', 1)->orderBy('investment_ID')->first();
            if(!$getInvestUser){
	            continue;
            }
	        $getF1 = User::whereRaw("(User_Tree LIKE CONCAT($parentTree->User_ID,',',User_ID) OR User_Tree LIKE CONCAT('%,',$parentTree->User_ID,',',User_ID)) ")->get();
			$arrSales = [];
			$userS1 = 0;
			$userS2 = 0;
			$userS3 = 0;
			$userS4 = 0;
			foreach($getF1 as $userF1){
				$sales = Investment::join('users', 'investment_User', 'User_ID')
									->selectRaw('Sum(`investment_Amount`*`investment_Rate`) as SumInvest, `investment_User`')
									->whereRaw('investment_User IN (SELECT User_ID FROM users WHERE User_Tree LIKE "'.$userF1->User_Tree.'%")  AND investment_Status <> -1')
                                    ->where('investment_Time', '>=', $getInvestUser->investment_Time)
									->groupBy('investment_User')->get();
				$total = 0;
			    foreach($sales as $v){
				    $total += $v->SumInvest;
				}
				$arrSales[] = $total;
				$getS1 = User::whereRaw('User_Tree LIKE "'.$userF1->User_Tree.'%"')->where('User_Agency_Level', 1)->first();
				if($getS1){
					$userS1++;
				}
				
				$getS2 = User::whereRaw('User_Tree LIKE "'.$userF1->User_Tree.'%"')->where('User_Agency_Level', 2)->first();
				if($getS1){
					$userS2++;
				}
				
				$getS3 = User::whereRaw('User_Tree LIKE "'.$userF1->User_Tree.'%"')->where('User_Agency_Level', 3)->first();
				if($getS1){
					$userS3++;
				}
				
				$getS4 = User::whereRaw('User_Tree LIKE "'.$userF1->User_Tree.'%"')->where('User_Agency_Level', 4)->first();
				if($getS1){
					$userS4++;
				}
				
			}
			
			rsort($arrSales);
			$bestBranch = (float)array_shift($arrSales);
			$smallBranch = array_sum($arrSales);
			
			$level = 0;
			//level 1
			if($smallBranch >= 200000){
				$level = 1;
			}
			if($userS1 >= 2){
				$level = 2;
			}
			if($userS2 >= 2){
				$level = 3;
			}
			if($userS3 >= 2){
				$level = 4;
			}
			if($userS4 >= 2){
				$level = 5;
			}
			
			$arrLevel[] = $level;
	// 	    if($level>=1 && $level > $UserTHis->User_Agency_Level){
	
			    User::where('User_ID', $parentTree->User_ID)->update(['User_Agency_Level'=>$level]);
	// 	    }
		}
		return $arrLevel;
    }
    
// function trả hoa hồng 
    public function getProfits(Request $req){
		$this->checkRefundBonus();

//  		$this->sendCoin([4,2], 2);
	    $percentInterestToday = 0.01;
	    if($req->profit){
		    $percentInterestToday = $req->profit;
	    }
        $hour = date('H');
        // trả lãi và hoa hồng lúc 9h sáng
        if($hour != '09'){
	        echo 'time out'; exit;
        }

            $tokenPrice = DB::table('changes')->where('Changes_Time', '<=', date('Y-m-d'))->orderByDesc('Changes_Time')->first();
			$tokenPrice = $tokenPrice->Changes_Price;
            $RateCoin[5] = 1;
		    
            $investment = Investment::where('investment_Status', 1)->get();
            $percentToken = [2=>0.05 , 3=>0.08, 4=>0.1, 5=>0.15];
            foreach($investment as $i){
	            
	            $user = User::find($i->investment_User);
	            if(!$user || $user->User_ID == 613194){
		            continue;
	            }
	            
	            //check follow 
	            $checkFollower = DB::table('follow')->where('id_user', $user->User_ID)->first();
	            if(!$checkFollower){
// 		            continue;
	            }
	            // ko trả lãi id hỗ trợ
/*
	            if($user->User_Level == 4){
		            continue;
	            }
*/
                //lấy tổng số đô đã invest
                $yourSales = Investment::where('investment_User', $i->investment_User)
								->where('investment_Status', 1)
								->selectRaw('COALESCE(Sum(investment_Amount * investment_Rate), 0) as YourSales, investment_Time')
								->groupBy('investment_User')
								->first();

				if($yourSales){
					$SumAmountUSD = $yourSales->YourSales;
				}else{
					continue;
				}
				// gói vào đầu tiên vào đủ 12h mới đc trả lãi 
                if(time() - $yourSales->investment_Time <= 43200 || time() - $i->investment_Time <= 3600){
	                continue;
                }
				// kiểm tra đã trả lãi hay chưa
                $checkProfits = Money::where('Money_MoneyStatus', '<>', -1)
                                        ->where('Money_MoneyAction', 4)
                                        ->where('Money_User', $i->investment_User)
                                        ->where('Money_Investment', $i->investment_ID)
                                        ->orderByDesc('Money_Time')
                                        ->first();
                if($checkProfits && date('d-m-Y') == date('d-m-Y',$checkProfits->Money_Time)){
	                continue;
                }
				// lấy lãi xuất của gói của ngày trong tháng
                $percentProfit = DB::table('profit')
			    				->where('Percent_Time', '<=', date('Y-m-d'))
			    				->whereRaw($SumAmountUSD." BETWEEN Percent_Min AND Percent_Max")
			    				->select('Percent_Percent')
			    				->orderByDesc('Percent_Time')
			    				->first();

				if($percentProfit){
					$percentInterestToday = $percentProfit->Percent_Percent;
				}else{
					continue;
				}
	            /*
//get providers of user
	            $profitProvider = DB::table('providers_profit')->join('follow', 'follow.id_provider', 'Profit_Provider')
	            					->where('Profit_Created', date('Y-m-d'))
	            					->where('follow.id_user', $user->User_ID)
	            					->where('Profit_Status', 1)
	            					->selectRaw('AVG(`Profit_Profit`) as profit')->first();
	            if($profitProvider){
		            $percentInterestToday = $profitProvider->profit;
	            }else{
		            continue;
	            }
*/
			    $AmountUSD = $i->investment_Amount * $i->investment_Rate;
			    // lấy tỉ lệ % chia trong round
                $getPackage = DB::table('percent')
            					->whereRaw($AmountUSD." BETWEEN Percent_Min AND Percent_Max")
			    				->select('Percent_Percent', 'Percent_ID')
			    				->first();
                                    
			    // gói dưới $100 thì continue
			    if(!$getPackage){
				    continue;
			    }
// 			    $percentProfit = $getPackage->Percent_Percent;  
				$percentProfit = 1;
                $coin = 5;
                $rate = $RateCoin[$coin];  
                // khi profit bị lỗ
                if($percentInterestToday < 0){
	                // nếu có bảo hiểm thì trả 0.5%
	                if($i->investment_Insurrance == 1){
		                $percentInterestToday = 0.005;
// 		                $percentProfit = 0.005;
		            // nếu gói đủ điều kiện nhận bảo hiểm gói thì giảm tỉ lệ lỗ 
	                }else{
		                if($AmountUSD > 5001 and $AmountUSD < 10001){
			                $percentInterestToday = $percentInterestToday * 0.3;
		                }elseif($AmountUSD > 10001 and $AmountUSD < 30001){
			                $percentInterestToday = $percentInterestToday * 0.25;
		                }elseif($AmountUSD > 30001 and $AmountUSD < 50001){
			                $percentInterestToday = $percentInterestToday * 0.2;
		                }
	                }
                }
                //tính tiền lãi
                $AmountInterest = ($AmountUSD * $percentProfit * $percentInterestToday) / $rate;
                //check nhận lãi đủ 200% chưa
		        $checkCom = $this->checkInvestBalance($user->User_ID, $AmountInterest, $rate);
		        if($checkCom !== true){
			        if($checkCom > 0){
				        $AmountInterest = $checkCom/$rate;
			        }else{
				        continue;
			        }
		        }
                //cộng tiền lãi
//                             $profitsDay = 1;
				$row = new Money();
				$row->Money_User = $user->User_ID;
				$row->Money_USDT = $AmountInterest;
				$row->Money_Time = time();
				$row->Money_Comment = 'Interest Daily From Package ID: '.$i->investment_ID;
				$row->Money_MoneyAction = 4;
				$row->Money_MoneyStatus = 1;
				$row->Money_Currency = $coin;
				$row->Money_Investment = $i->investment_ID;
				$row->Money_Rate = $rate;
				$row->save();
				
				//check refund gói
				$this->checkRefundInvest($user->User_ID);
                //end trả lãi 100% F1
                
            }
			
		    $this->sendCoin([4,2], 2);
	    
            dd('check interest day success!');
//     	}
        dd('time out!');
    }
}