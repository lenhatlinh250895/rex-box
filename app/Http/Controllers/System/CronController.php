<?php
namespace App\Http\Controllers\System;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth;
use DB;

use App\Models\Investment;
use App\Models\Money;
use App\Models\User;
use App\Models\LogMail;
use Hash;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;
use Sop\CryptoTypes\Asymmetric\EC\ECPublicKey;
use Sop\CryptoTypes\Asymmetric\EC\ECPrivateKey;
use Sop\CryptoEncoding\PEM;
use kornrunner\Keccak;


class CronController extends Controller{
	
	public function coinbase(){
        $apiKey = 'IgU2kC2BiWwP1DNt';
        $apiSecret = 'DGoOCdswXXDsjjaF7Sx7bfJ8HGj37fp7';

        $configuration = Configuration::apiKey($apiKey, $apiSecret);
        $client = Client::create($configuration);

        return $client;
	}

	public function checkInvestmentDPA(){
		$bonus = 0.05;
		$client = new \GuzzleHttp\Client(['http_errors' => false]);
		$res = $client->request('GET', 'http://api.ethplorer.io/getTokenHistory/0x7105ec15995a97496ec25de36cf7eec47b703375?apiKey=freekey');
		$response = $res->getBody(); 
		
		$TokenHistory = json_decode($response);
		
		$tokenPrice = DB::table('changes')->select('Changes_Price')->where('Changes_Time', '<=', date('Y-m-d'))->orderByDesc('Changes_Time')->first()->Changes_Price;
// 		dd($TokenHistory);
		foreach($TokenHistory->operations as $v2){
			if(strtoupper($v2->to) == strtoupper('0x6be9469057587d3fab951a17dda3745ae2f7d581')){
				$hash = Investment::where('investment_Hash', $v2->transactionHash)->first();
			
				if(!$hash){
					$thisUser = User::where('User_WalletAddress', $v2->from)->first();
					if($thisUser){
						$amount = $v2->value/1000000000000000000;
						$amountUSD = ($amount)*$tokenPrice;
						// thêm gói mới
						$insertInvest = array(
							'investment_User'=>$thisUser->User_ID,
							'investment_Amount'=>$amount,
							'investment_Currency'=>8,
							'investment_Rate'=>$tokenPrice,
							'investment_AddressTo'=>$v2->to,
							'investment_Hash'=>$v2->transactionHash,
							'investment_Time'=>time(),
							'investment_Status'=>1
						);
						
						$invest = Investment::insertGetId($insertInvest);
						
						
						// tăng ví mining lên 200%
						$percent = 1.5;
						if($amountUSD > 1000){
							$percent = 2;
						}
						if($amountUSD > 5000){
							$percent = 2.5;
						}
						if($amountUSD > 20000){
							$percent = 3;
						}
						$miningWallet = array(
							'Money_User' => $thisUser->User_ID,
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
						
						$commission = $this->checkCommission($thisUser, $amountUSD, 5, 1);
						$commission = $this->checkAffiliateCommission($thisUser, $amountUSD, 5, 1);
					}
					
				}	
			}
		}
		
		dd('stop');
	}
	
	public function checkInvestmentETH(){
		$client = new \GuzzleHttp\Client(['http_errors' => false]);
		$res = $client->request('GET', 'http://api.ethplorer.io/getAddressTransactions/0xde157b41db77079e9e36db9762eaaa1456c26de9?apiKey=freekey');
		$response = $res->getBody(); 
		$TokenHistory = json_decode($response);

		$rate = $this->coinbase()->getBuyPrice('ETH-USD')->getAmount();
		foreach($TokenHistory as $v2){
			if(strtoupper($v2->to) == strtoupper('0xde157b41db77079e9e36db9762eaaa1456c26de9')){
				$hash = Investment::where('investment_Hash', $v2->hash)->first();
			
				if(!$hash){
					$thisUser = User::where('User_WalletAddress', $v2->from)->first();
					if($thisUser){
						$amount = $v2->value;
						$amountUSD = $amount*$rate;
						// thêm gói mới
						$insertInvest = array(
							'investment_User'=>$thisUser->User_ID,
							'investment_Amount'=>$amount,
							'investment_Currency'=>2,
							'investment_Rate'=>$rate,
							'investment_AddressTo'=>$v2->to,
							'investment_Hash'=>$v2->hash,
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
							'Money_User' => $thisUser->User_ID,
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
						
						$commission = $this->checkCommission($thisUser, $amountUSD, 5, 1);
						$commission = $this->checkAffiliateCommission($thisUser, $amountUSD, 5, 1);
					}
					
					
				}	
			}
		}
		dd('stop');
	}
	
    public function UpdateLevel($u){

		$user = User::where('User_ID', $u)->first();
		
		$userParent = User::where('User_ID', $user->User_Parent)->first();
		if($userParent){
			// lấy tất cả f1 của member
				$userf1 = User::where('User_Parent', $user->User_ID)->select('User_Tree', 'User_ID')->get();
				$arrayTemp = array();
				foreach($userf1 as $v){
					$sales = Investment::join('users', 'User_ID', 'investment_User')->where('investment_Status', 1)->whereRaw('`User_Tree` LIKE "'.$v->User_Tree.'%"')->selectRaw('COALESCE(sum(`investment_Amount`*`investment_Rate`), 0) as `TotalSale`')->first();
					
					$arrayTemp[$v->User_ID] = $sales->TotalSale;
				}
				
				arsort($arrayTemp);
				
				$total = 0;
				if(count($arrayTemp) > 2){
					
					$i = 0;
					foreach($arrayTemp as $v){
						if($i>=2){
							$total+=$v;
						}
						$i++;
					}
				}
				
				if($total>=10000000){
					$level = 10;
				}elseif($total>=5000000){
					$level = 9;
				}elseif($total>=2000000){
					$level = 8;
				}elseif($total>=1000000){
					$level = 7;
				}elseif($total>=300000){
					$level = 6;
				}elseif($total>=100000){
					$level = 5;
				}elseif($total>=40000){
					$level = 4;
				}elseif($total>=10000){
					$level = 3;
				}elseif($total>=3000){
					$level = 2;
				}elseif($total>=1000){
					$level = 1;
				}else{
					$level = 0;
				}
				
				// cập nhật lại cấp
				if($level > $userParent->User_Agency_Level){
					User::where('User_ID', $userParent->User_ID)->update(['User_Agency_Level'=>$level]);
				}
				
				$MoneyBonus = array(0 => 0,1 => 0,2 => 0,3 => 0,4 => 1000,5 => 2000,6 => 6000,7 => 20000,8 => 50000,9 => 150000,10 => 500000);
				$levelName = array(0 => '',1 => '',2 => '',3 => '',4 => 'Senior Manager',5 => 'Vice President',6 => 'President',7 => 'Diamond',8 => 'Crown Diamond',9 => 'Ambassador',10 => 'Crown Ambassador');
				
				if($MoneyBonus[$level] > 0 && $level > $userParent->User_Agency_Level){
					// cộng tiền thưởng cho member
					$bonusWallet = array(
						'Money_User' => $userParent->User_ID,
						'Money_USDT' => $MoneyBonus[$level],
						'Money_USDTFee' => 0,
						'Money_Investment' => 0,
						'Money_Time' => time(),
						'Money_Comment' => 'Congratulation to up level '.$levelName[$level],
						'Money_MoneyAction' => 9,
						'Money_MoneyStatus' => 1,
						'Money_Currency' => 5,
						'Money_Rate' => 1
					);
		
					$money = Money::insert($bonusWallet);
				}
		
				if($u != 650415){
					self::UpdateLevel($user->User_Parent);
				}
		}
		
		
    }
    
    public function UpdateLevel2($idParent, $arrLevel = []){

		if($idParent==666666){
			return $arrLevel;
			return false; 
		}

		$UserTHis = User::find($idParent);
		if(!$UserTHis){
			return $arrLevel;
			return false; 
		}
		$level = 0;
		$getF1 = User::where('User_Parent', $UserTHis->User_ID)
					->get();
		$countF1True = 0;
		$countRED1 = 0;
		$countRED2 = 0;
		$countRED3 = 0;
		$countRED4 = 0;
		foreach($getF1 as $user){
			$sales = Investment::join('users', 'User_ID', 'investment_User')->where('investment_Status', 1)->whereRaw('`User_Tree` LIKE "'.$user->User_Tree.'%"')->selectRaw('COALESCE(sum(`investment_Amount`*`investment_Rate`), 0) as `TotalSale`')->value('TotalSale');
			if($sales >= 150000){
				$countF1True++;
			}
			$getRED1 = User::whereRaw('`User_Tree` LIKE "'.$user->User_Tree.'%"')->where('User_Agency_Level', '>=', 1)->first();
			if($getRED1){
				$countRED1++;
			}
			$getRED2 = User::whereRaw('`User_Tree` LIKE "'.$user->User_Tree.'%"')->where('User_Agency_Level', '>=', 2)->first();
			if($getRED2){
				$countRED2++;
			}
			$getRED3 = User::whereRaw('`User_Tree` LIKE "'.$user->User_Tree.'%"')->where('User_Agency_Level', '>=', 3)->first();
			if($getRED3){
				$countRED3++;
			}
			$getRED4 = User::whereRaw('`User_Tree` LIKE "'.$user->User_Tree.'%"')->where('User_Agency_Level', '>=', 4)->first();
			if($getRED4){
				$countRED4++;
			}
		}
		
		if($countF1True >= 2){
			$level = 1;
		}
		
		if($countRED1 >= 2){
			$level = 2;
		}
		
		if($countRED2 >= 2){
			$level = 3;
		}
		
		if($countRED3 >= 2){
			$level = 4;
		}
		
		if($countRED4 >= 2){
			$level = 5;
		}

		$arrLevel[] = [$idParent, $level];
// 	    if($level>=1 && $level > $UserTHis->User_Agency_Level){

		    User::where('User_ID', $idParent)->update(['User_Agency_Level'=>$level]);
// 	    }

	    return $this->UpdateLevel($UserTHis->User_Parent, $arrLevel);
    }
    
    public static function checkBonusLevel($idUser, $comment, $level){
		$checkBonus = Money::where('Money_MoneyAction', 9)->where('Money_User', $idUser)->where('Money_Comment', $comment)->first();
		if(!$checkBonus){
			$arrAmount = [4=>1000, 5=>2000, 6=>6000, 7=>10000, 8=>50000, 9=>100000, 10=>300000];
			$amount = $arrAmount[$level];
			// cộng hoa hồng bonus vào balance USD của User
			$directCom[] = array(
				'Money_User' => $idUser,
				'Money_USDT' => $amount,
				'Money_USDTFee' => 0,
				'Money_Time' => time(),
				'Money_Comment' => $comment,
				'Money_MoneyAction' => 9,
				'Money_MoneyStatus' => 1,
				'Money_Currency' => 5,
				'Money_Rate' => 1
			);
			$money = Money::insert($directCom);
			return true;
		}
		return false;
    }
	
	// function cộng tiền hoa hồng cho user
    public function checkDirectCommission($user, $amount, $currency, $rate){
        //kiểm tra tổng gói của user có trên 250$ chưa 
        //$checkTotalInvestUser = Investment::where('investment_User', $user->User_ID)->where('investment_Status', 1)->sum(DB::Raw('investment_Amount * investment_Rate'));
		// if($checkTotalInvestUser < 250){
		// 	return 0;
		// }
        // hoa hồng trực tiếp 10%
        $percent = 0.1;
		$amountCom = $amount * $percent;
		//Lây người giới thiệu trực tiếp
        $parent = User::where('User_ID', $user->User_Parent)->first();
        if($parent){
	        $directCom = array();
	        $amountCom = $amountCom * $rate;
			// $totalInvestParent = Investment::where('investment_User', $parent->User_ID)
			// 					->where('investment_Status', 1)
			// 					->sum(DB::raw('investment_Amount * investment_Rate'));
			// if($totalInvestParent < 250){
					//return false;
			// }

			$directCom[] = array(
				'Money_User' => $parent->User_ID,
				'Money_USDT' => $amountCom*0.5,
				'Money_USDTFee' => 0,
				'Money_Time' => time(),
				'Money_Comment' => 'Direct Commission From User ID: '.$user->User_ID,
				'Money_MoneyAction' => 7,
				'Money_MoneyStatus' => 1,
				'Money_Currency' => $currency,
				'Money_Rate' => $rate
			);
			// cộng hoa hồng trên lãi vào balance mining của parent
			$directCom[] = array(
				'Money_User' => $parent->User_ID,
				'Money_USDT' => $amountCom*0.5,
				'Money_USDTFee' => 0,
				'Money_Time' => time(),
				'Money_Comment' => 'Direct Commission From User ID: '.$user->User_ID.' (Mining Box)',
				'Money_MoneyAction' => 7,
				'Money_MoneyStatus' => 2,
				'Money_Currency' => $currency,
				'Money_Rate' => $rate
			);
			$money = Money::insert($directCom);	
        }
	}
	//Nhị phân
	public function checkBinaryCommission($user, $amount, $currency, $rate){
		//phần trăm hoa hồng
        $percentBinary = 0.06;
        //lấy tree
        $tree = explode(',', $user->User_Tree);
        //đảo chuổi
        $tree = array_reverse($tree);
        //loop tree
        for($i = 1; $i < count($tree); $i++){
            //User ID
			$find_user = User::find($tree[$i]);
			//nếu không tìm thấy ID đó
            if(!$find_user){
                continue;
            }
            //Phải đầu tư mói nhận doanh số
            $have_invest = Investment::where('investment_User', $find_user->User_ID)->where('investment_Status', '<>', -1)->orderBy('investment_ID')->first();
            if(!$have_invest){
	            continue;
            }
            //tìm doánh số nhánh yếu
            $arr_branch_sales = $this->branchSales($find_user->User_ID);
            //fillter nhánh yếu
			$total_branch_min = min($arr_branch_sales);
			//nếu nhánh yêu có doánh số nhỏ hơn không
			if($total_branch_min <= 0){
				continue;
			}
            //doanh số nhị phân đã trả trước đó
			$before_sales_binary = Money::where('Money_User', $find_user->User_ID)->where('Money_MoneyStatus', 1)->where('Money_MoneyAction', 18)->orderBy('Money_ID', 'DESC')->first();
			if($before_sales_binary){
				//nếu tìm thấy
				$before_sales_binary = $before_sales_binary->Money_SaleBinary;
			}
			else{
				$before_sales_binary = 0;
			}
			//Doanh số được nhận
			//Tìm số tiền có thể nhận được
            $total_com = $total_branch_min - $before_sales_binary;
            if($total_com <= 0){
                continue;
            }
            //tăng phần trăm
            // if($find_user->User_Agency_Level >= 1){
            //     $percentBinary = 0;

			// }
			
            $amountComBinary = $total_com / $rate * $percentBinary;
			//Check maxout gói trong ngày
			$checkMaxOutInDay = $this->checkMaxOutInDay($find_user->User_ID, $amountComBinary, $rate);
			if($checkMaxOutInDay !== true){

				if($checkMaxOutInDay > 0){
					$amountComBinary = $checkMaxOutInDay/$rate;
				}else{
					continue;
				}
				//chia ví
				$insertCom = [];
				$insertCom[] = array(
					'Money_User' => $find_user->User_ID,
					'Money_USDT' => $amountComBinary*0.5,
					'Money_USDTFee' => 0,
					'Money_Time' => time(),
					'Money_Comment' => 'Binary Commission From User ID: '.$user->User_ID,
					'Money_MoneyAction' => 18,
					'Money_MoneyStatus' => 1,
					'Money_Currency' => $currency,
					'Money_Rate' => $rate,
					'Money_SaleBinary' => $total_branch_min
				);
				// cộng hoa hồng trên lãi vào balance mining của parent
				$insertCom[] = array(
					'Money_User' => $find_user->User_ID,
					'Money_USDT' => $amountComBinary*0.5,
					'Money_USDTFee' => 0,
					'Money_Time' => time(),
					'Money_Comment' => 'Binary Commission From User ID: '.$user->User_ID.' (Mining Box)',
					'Money_MoneyAction' => 18,
					'Money_MoneyStatus' => 2,
					'Money_Currency' => $currency,
					'Money_Rate' => $rate,
					'Money_SaleBinary' => $total_branch_min
				);
				$money = Money::insert($insertCom);
			}
        }
	}
	//upldate level
	public function checkLevelUp($user){
		//lấy tree
        $tree = explode(',', $user->User_Tree);
        //đảo chuổi
        $tree = array_reverse($tree);
        //loop tree
        for($i = 1; $i < count($tree); $i++){
			$find_user = User::find($tree[$i]);
			//nếu không tìm thấy ID đó
            if(!$find_user){
                continue;
            }
			//tìm doánh số nhánh yếu
            $arr_branch_sales = $this->branchSales($find_user->User_ID);
            //fillter nhánh yếu
			$total_branch_min = min($arr_branch_sales);
			//nếu nhánh yêu có doánh số nhỏ hơn không
			if($total_branch_min <= 0){
				continue;
			}
			//check level
			$level = 0;
			if($total_branch_min >= 150000)
			{
				$level = 1;
			}
			//có 2 nhánh đạt RED1
			$agencyLevel = $this->Agency_Level($find_user->User_ID);
			if($agencyLevel !== false){
				$level = $agencyLevel;
			}
			//update level
			if($level != $find_user->User_Agency_Level){
				LogMail::insertLog($find_user->User_ID, 'Level Up Affiliate',  "Up to Level $level");
				//Cập nhập lại level mới nhất
				User::where('User_ID', $find_user->User_ID)->update(['User_Agency_Level'=> $level]);
				//thưởng
				$bonusLevel = [1 => 0.01, 2 => 0.02, 3 => 0.03, 4 => 0.04, 5 => 0.05];
				$amountBonus = $total_branch_min * $bonusLevel[$level];
				//save
				$insertCom = [];
				$insertCom[] = array(
					'Money_User' => $find_user->User_ID,
					'Money_USDT' => $amountBonus*0.3,
					'Money_USDTFee' => 0,
					'Money_Time' => time(),
					'Money_Comment' => 'Binary Commission From User ID: '.$user->User_ID,
					'Money_MoneyAction' => 18,
					'Money_MoneyStatus' => 1,
					'Money_Currency' => 5,
					'Money_Rate' => 1,
					'Money_SaleBinary' => $total_branch_min
				);
				// cộng hoa hồng trên lãi vào balance mining của parent
				$insertCom[] = array(
					'Money_User' => $find_user->User_ID,
					'Money_USDT' => $amountBonus*0.7,
					'Money_USDTFee' => 0,
					'Money_Time' => time(),
					'Money_Comment' => 'Binary Commission From User ID: '.$user->User_ID.' (Mining Box)',
					'Money_MoneyAction' => 18,
					'Money_MoneyStatus' => 2,
					'Money_Currency' => 5,
					'Money_Rate' => 1,
					'Money_SaleBinary' => $total_branch_min
				);
				$money = Money::insert($insertCom);
			}

		}
	}
	//Tính doanh số 2 nhánh
	public function branchSales($user_ID){
		$branch_sales = [];
		$branch_sales['left'] = 0;
		$branch_sales['right'] = 0;
		$result = User::where('User_ID', $user_ID)->first();
		if(!$result){
			return $branch_sales;
		}
		$branch  = User::select('User_Email','User_ID', 'User_Tree', 'User_IsRight')->whereRaw("( User_Tree LIKE CONCAT($user_ID,',',User_ID) OR User_Tree LIKE CONCAT('%,' , $user_ID, ',' ,User_ID) )")->orderBy('User_IsRight')->get();

		if(count($branch) > 0){
            for($i=0; $i<2; $i++){
                if(isset($branch[$i])){
                    if($branch[$i]->User_IsRight == 0){
						
						$left = Investment::join('users', 'User_ID', 'investment_User')
								->where('User_Tree', $branch[$i]->User_Tree.'%')
								->sum(DB::raw('investment_Amount * investment_Rate'));
						$branch_sales['left'] = $left;
                        
					}
                    elseif($branch[$i]->User_IsRight == 1){
						
						$right = Investment::join('users', 'User_ID', 'investment_User')
								->where('User_Tree', $branch[$i]->User_Tree.'%')
								->sum(DB::raw('investment_Amount * investment_Rate'));
						$branch_sales['right'] = $right;

                    }
                    
                }
                
    
            }
		}
		return $branch_sales;


	}
	//Tìm level trong nhánh
	public function Agency_Level($user_ID){
		$branch = User::select('User_Agency_Level')
					->whereRaw("( User_Tree LIKE CONCAT($user_ID,',',User_ID) OR User_Tree LIKE CONCAT('%,' , $user_ID, ',' ,User_ID) )")
					->orderBy('User_IsRight')
					->get();
		if(count($branch) == 2){
			$countLevel1 = $branch->where('User_Agency_Level', '>=', 1)->count();
			$countLevel2 = $branch->where('User_Agency_Level', '>=', 2)->count();
			$countLevel3 = $branch->where('User_Agency_Level', '>=', 3)->count();
			$countLevel4 = $branch->where('User_Agency_Level', '>=', 4)->count();
			if($countLevel4 >= 2){
				$level = 5;
			}elseif($countLevel3 >= 2){
				$level = 4;
			}elseif($countLevel2 >= 2){
				$level = 3;
			}elseif($countLevel1 >= 2){
				$level = 2;
			}
		}
		return false;
	}



	//Tìm maxout trong ngày
	public function checkMaxOutInDay($user, $amount, $rate){
        //Số tiền hoa hồng sắp được nhận
        $commissionPrepare = $amount * $rate;
        //Lấy tổng đầu tư
		$sumInvest = Investment::whereIn('investment_Status', [1,2])
								->where('investment_User', $user)
								->where('investment_Time','>=', strtotime("today"))
								->sum(DB::raw('investment_Amount * investment_Rate'));
        //x 500% tổng đầu tư
        $sumInvest = $sumInvest * 5;
		//tổng lãi và hoa hồng
		
		$sumCommission = Money::where('Money_MoneyStatus', '<>', -1)
								->where('Money_User', $user)
								->whereIn('Money_MoneyAction', [5, 6, 7, 18])
								->where('Money_Time', '>=', strtotime("today"))
								->sum('Money_USDT');
        // lãi và hoa hồng không được vượt quá 500% của tổng đầu tư
		if(($sumInvest - $sumCommission) <= $commissionPrepare){
	        if($sumInvest >= $sumCommission){
			    return ($sumInvest - $sumCommission);
	        }else{
		        return false;
	        }
	    }
	    return true;
	}


    public function checkAffiliateCommission($user, $amount, $currency, $rate){
	    
    	//trả thưởng affiliate
    	$arrParent = explode(',', $user->User_Tree);
		$arrParent = array_reverse($arrParent);
		for($i = 1; $i<=12; $i++){
			if(!isset($arrParent[$i])){
				continue;
			}
			
			if($i >= 11){
				$this->insertAffiliate($arrParent[$i], $user, $amount, $rate, $currency, 5);
			}elseif($i >= 8){
				$this->insertAffiliate($arrParent[$i], $user, $amount, $rate, $currency, 4);
			}elseif($i >= 6){
				$this->insertAffiliate($arrParent[$i], $user, $amount, $rate, $currency, 3);
			}elseif($i >= 4){
				$this->insertAffiliate($arrParent[$i], $user, $amount, $rate, $currency, 2);
			}else{
				$this->insertAffiliate($arrParent[$i], $user, $amount, $rate, $currency, 1);
			}
		}
    }
    
    public function insertAffiliate($parent, $user, $amount, $rate, $currency, $level){
	    
    	$aff = User::where('User_Agency_Level', '>=', $level)->where('User_ID', $parent)->first();
		$percent = 0.05;
		if(!$aff){
			return false;
		}
    	$amountAffiliate = $amount * $percent;
		// cộng hoa hồng trực tiếp vào balance của parent
		$indirect = array(
			'Money_User' => $aff->User_ID,
			'Money_USDT' => $amountAffiliate*0.5,
			'Money_USDTFee' => 0,
			'Money_Time' => time(),
			'Money_Comment' => 'Affiliate Commission From User ID: '.$user->User_ID,
			'Money_MoneyAction' => 6,
			'Money_MoneyStatus' => 1,
			'Money_Currency' => $currency,
			'Money_Rate' => $rate
		);
		$money = Money::insert($indirect);
		// cộng hoa hồng trên lãi vào balance mining của parent
		$indirect = array(
			'Money_User' => $aff->User_ID,
			'Money_USDT' => $amountAffiliate*0.5,
			'Money_USDTFee' => 0,
			'Money_Time' => time(),
			'Money_Comment' => 'Affiliate Commission From User ID: '.$user->User_ID.' (Mining Box)',
			'Money_MoneyAction' => 6,
			'Money_MoneyStatus' => 2,
			'Money_Currency' => $currency,
			'Money_Rate' => $rate
		);
		$money = Money::insert($indirect);

		return true;
    }
	// function check số tiền nhận từ lãi có vượt quá 500% số tiền invest chưa
    public static function checkInvestBalance($user, $amount = 0, $rate = 1){
		$tokenPrice = DB::table('changes')->where('Changes_Time', '<=', date('Y-m-d'))->orderByDesc('Changes_Time')->first();
		$tokenPrice = $tokenPrice->Changes_Price;
		$amountUSD = $amount * $rate;
	    $getInvest = Investment::whereIn('investment_Status', [1,2])->where('investment_User', $user)->selectRaw('SUM(`investment_Amount` * `investment_Rate`) as SumInvest ')->first();
	    $amountCom = 0;
	    if($getInvest){
		    //cũ 300% sửa thành 500%
		    $amountCom = $getInvest->SumInvest * 5;
	    }
	    $sumCom = Money::where('Money_MoneyStatus', 1)->where('Money_User', $user)->whereIn('Money_MoneyAction', [5,6,7,8])->sum('Money_USDT');
		$checkMaxout = User::where('User_ID', $user)->value('User_UnMaxout');
		if($checkMaxout == 1){
			return true;
		}
        if(($amountCom - $sumCom) <= $amountUSD){
	        if($amountCom >= $sumCom){
			    return ($amountCom - $sumCom);
	        }else{
		        return false;
	        }
	    }
	    return true;
    }
    
    public function getProfits(){
	    if(date('H') != '00'){
		    dd('time out');
	    }
		$percentInterest = 0.005;
		
		$tokenPrice = 1;
		$getUserHaveMining = Money::join('users', 'Money_User', 'User_ID')
									->where('Money_Currency', 5)
									->where('Money_MoneyStatus', 2)
									->groupBy('Money_User')
									->selectRaw('SUM(`Money_USDT`) as BalanceMining, User_Name, Money_User, User_Parent, User_Tree, User_Agency_Level')
									->get();	
		$currencyInterest = 5;
		$rate = 1;
		foreach($getUserHaveMining as $b){
			
	        //kiểm tra tổng gói của user có trên 250$ chưa 
	        $checkTotalInvestUser = Investment::where('investment_User', $b->Money_User)->where('investment_Status', 1)->sum(DB::Raw('investment_Amount*investment_Rate'));
			if($checkTotalInvestUser < 250){
// 				continue;
			}
				
		    $checkProfits = Money::where('Money_MoneyStatus', 1)
		    						->where('Money_MoneyAction', 5)
		    						->where('Money_User', $b->Money_User)
		    						->orderByDesc('Money_Time')
		    						->first();
			if($checkProfits && date('d-m-Y') == date('d-m-Y',$checkProfits->Money_Time)){
				continue;
			}
				$amountInterest = $b->BalanceMining * $percentInterest;
		        
				// cộng lãi vào balance
				$interestWallet = array(
					'Money_User' => $b->Money_User,
					'Money_USDT' => $amountInterest,
					'Money_USDTFee' => 0,
					'Money_Time' => time(),
					'Money_Comment' => 'Daily Mining',
					'Money_MoneyAction' => 5,
					'Money_MoneyStatus' => 1,
					'Money_Currency' => $currencyInterest,
					'Money_Rate' => $tokenPrice
				);
				$money = Money::insert($interestWallet);
				// trừ ví mining
				$interestMining = array(
					'Money_User' => $b->Money_User,
					'Money_USDT' => -$amountInterest,
					'Money_USDTFee' => 0,
					'Money_Time' => time(),
					'Money_Comment' => 'Daily Mining',
					'Money_MoneyAction' => 5,
					'Money_MoneyStatus' => 2,
					'Money_Currency' => $currencyInterest,
					'Money_Rate' => $tokenPrice
				);
				$money = Money::insert($interestMining);	
			
		}
		dd('done');
    }
    
    public static function checkPackageUser($user){
	    $getInvestment = Investment::where('investment_User', $user)->where('investment_Status', 1)->selectRaw('SUM(`investment_Amount` * `investment_Rate`) as SumInvest')->groupBy('investment_User')->first();
	    $package = 0;
	    if($getInvestment){
		    $amount = $getInvestment->SumInvest;
		    if($amount >= 10000){
			    $package = 6;
		    }elseif($amount >= 5000){
			    $package = 5;		    
		    }elseif($amount >= 3000){
			    $package = 4;		    
		    }elseif($amount >= 1000){
			    $package = 3;		    
		    }elseif($amount >= 500){
			    $package = 2;		    
		    }elseif($amount >= 200){
			    $package = 1;		    
		    }
	    }
	    return $package;
    }
    
    public static function checkInvestBalanceOld($user, $amount = 0){
		$tokenPrice = DB::table('changes')->where('Changes_Time', '<=', date('Y-m-d'))->orderByDesc('Changes_Time')->first();
		$tokenPrice = $tokenPrice->Changes_Price;
		
	    $getInvest = Investment::where('investment_Status', 1)->where('investment_User', $user)->selectRaw('SUM(`investment_Amount` * `investment_Rate`) as SumInvest ')->first();

	    $amountCom = 0;
	    if($getInvest){
		    $amountCom = $getInvest->SumInvest * 10;
	    }

	    $sumCom = Money::where('Money_MoneyStatus', '<>', -1)->where('Money_User', $user)->where('Money_Currency', 5)->whereIn('Money_MoneyAction', [6,7,8])->sum('Money_USDT');
	    
	    if(($amountCom - $sumCom) < $amount){
		    return false;
	    }
	    return ($amountCom - $sumCom);
    }
    
	public function getDeposit(Request $req){
	    
	    $coin = DB::table('currency')->where('Currency_Symbol', $req->coin)->first();
		
		if(!$coin || $coin->Currency_ID == 1 || $coin->Currency_ID == 5){

		    dd('coin not exit');
		}
	    $symbol = $coin->Currency_Symbol;
	    $blockcypher = 'https://api.blockcypher.com/v1/'.strtolower($symbol).'/main/txs/';
		$rate = app('App\Http\Controllers\System\CoinbaseController')->coinRateBuy();
	    $transactions = app('App\Http\Controllers\System\CoinbaseController')->getAccountTransactions($symbol);
	    $priceCoin = $rate[$symbol];
        foreach($transactions as $v){	        

	        if($v->getamount()->getamount() > 0){
				//$hash = Money::where('Money_Address', $v->getnetwork()->gethash())->first();
				$hash = Investment::where('investment_Hash', $v->getnetwork()->gethash())->first();
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
						$thisUser = User::find($address->Address_User);
                        $amount = $v->getamount()->getamount();
						$amountUSD = $amount*$priceCoin;
						// thêm gói mới
						$insertInvest = array(
							'investment_User'=>$address->Address_User,
							'investment_Amount'=>$amount,
							'investment_Currency'=>$coin->Currency_ID,
							'investment_Rate'=>$priceCoin,
							'investment_AddressTo'=>'',
							'investment_Hash'=>$v->getnetwork()->gethash(),
							'investment_Time'=>time(),
							'investment_Status'=>1
						);
						//insert and get last id
						$invest = Investment::insertGetId($insertInvest);
						// tăng ví mining lên 150%
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
							'Money_User' => $thisUser->User_ID,
							'Money_USDT' => $amountUSD*$percent,
							'Money_USDTFee' => 0,
							'Money_Investment' => $invest,
							'Money_Time' => time(),
							'Money_Comment' => 'Insert Energy Pool Investment $'.$amountUSD,
							'Money_MoneyAction' => 4,
							'Money_MoneyStatus' => 2,
							'Money_Currency' => 5,
							'Money_Rate' => 1
						);
						//save
						$money = Money::insert($miningWallet);
						//insert hoa hồng trực tiếp
						$direct = $this->checkDirectCommission($thisUser, $amountUSD, 5, 1);
						//hoa hồng nhị phân
						$binary = $this->checkBinaryCommission($thisUser, $amountUSD, 5, 1);
					}
					
				}   
		    }
        }
		echo 123;exit;
    }
	
    public static function RandonIDUser(){
	    
	    $id = rand(100000, 999999);
        $user = User::where('User_ID',$id)->first();
        if(!$user){
            return $id;
        }else{
            return $this->RandonIDUser();
        }
	}

}
