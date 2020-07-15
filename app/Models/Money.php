<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;


class Money extends Model
{
	protected $table = "money";
    
    protected $fillable = ['Money_ID', 'Money_Game', 'Money_User', 'Money_BetAction', 'Money_USDT', 'Money_USDT_Return', 'Money_USDTFee', 'Money_Time', 'Money_Comment', 'Money_MoneyAction', 'Money_MoneyStatus', 'Money_BinaryWeak', 'Money_Package', 'Money_TXID', 'Money_Address', 'Money_Currency', 'Money_Rate', 'Money_Confirm','Money_Active'];
    
    public $timestamps = false;
    
    protected $primaryKey = 'Money_ID';
    
    public static function getBalance($user){
	    $result = DB::table('money')
	    			->where('Money_MoneyStatus', 1)
	    			->where('Money_User', $user)
	    			->selectRaw('
	    						COALESCE(SUM(IF(`Money_Currency` <> 8, `Money_USDT`-`Money_USDTFee`, 0)), 0) AS USD,
	    						COALESCE(SUM(IF(`Money_Currency` = 8, `Money_USDT`-`Money_USDTFee`, 0)), 0) AS RBD
	    			')->get();
		return $result[0];
    }
    
    public static function getBalanceCoin($user, $coin = 1){
	    $result = DB::table('money')
	    			->where('Money_MoneyStatus', 1)
	    			->where('Money_User', $user)
	    			->where('Money_Currency', $coin)
	    			->selectRaw('COALESCE(SUM(`Money_USDT`-`Money_USDTFee`), 0) AS total')->get();
		
		return $result[0]->total;
    }
    
    public static function getAddress($user){
	    $result = DB::table('address')->select('Address_Address', 'Address_Currency', 'Currency_Name', 'Currency_Symbol')
	    			->join('currency', 'Currency_ID', 'Address_Currency')
	    			->where('Address_IsUse', 0)
	    			->where('Address_User', $user)->get();
		return $result;
	}
	
	
    public static function getProfit($u){
	    $result = Money::where('Money_MoneyStatus', 1)
	    			->where('Money_User', $u)
	    			->where('Money_MoneyAction', 5)
	    			->sum('Money_USDT');
		return $result;
    }
	
	public static function insertRow($user, $mount, $comment, $currency, $action, $profits = 0, $rate = 0){
		$row = new Money();
		
		$row->Money_User = $user;
		$row->Money_USDT = $mount;
		$row->Money_Time = time();
		$row->Money_Comment = $comment;
		$row->Money_MoneyAction = $action;
		$row->Money_MoneyStatus = 1;
		$row->Money_Currency = $currency;
		$row->Money_Investment = $profits;
		$row->Money_Rate = $rate;
		if($row->save()){
			return true;
		}
		return false; 
	}
	
	public static function getHistory($user){
		$result = DB::table('money')
					->join('moneyaction', 'Money_MoneyAction', 'MoneyAction_ID')
					->join('currency', 'Money_Currency', 'Currency_ID')
					->select('Money_USDT', 'Money_USDTFee', 'Money_Time', 'Money_MoneyAction', 'Money_Currency', 'Currency_Symbol', 'MoneyAction_Name', 'Money_MoneyStatus', 'Money_Comment')
	    			->where('Money_MoneyStatus', 1)
	    			->where('Money_User', $user)->orderBy('Money_ID', 'DESC')->get();
		return $result; 
	}
	
    public static function getStatistic($where){

	    $result = Money::join('users', 'Money_User', 'User_ID')
	    				->selectRaw('Money_User, User_Email, 
						SUM(IF(`Money_Currency` = 8 '.$where.', (ROUND((`Money_USDT` - `Money_USDTFee`),8)), 0)) as BalanceRBD,
						SUM(IF(`Money_Currency` <> 8 '.$where.', (ROUND((`Money_USDT` - `Money_USDTFee`),8)), 0)) as BalanceUSD,
						
						SUM(IF(`Money_Currency` = 1 AND `Money_MoneyAction` = 1 '.$where.', ROUND(`Money_USDT`,8), 0)) as DepositBTC, 
						SUM(IF(`Money_Currency` = 2 AND `Money_MoneyAction` = 1 '.$where.', ROUND(`Money_USDT`,8), 0)) as DepositETH,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 1 '.$where.', ROUND(`Money_USDT`,8), 0)) as DepositRBD,
						SUM(IF(`Money_Currency` <> 8  AND `Money_MoneyAction` = 1 '.$where.', ROUND(`Money_USDT`,8), 0)) as DepositUSD,
						
						SUM(IF(`Money_Currency` = 1 AND `Money_MoneyAction` = 2 '.$where.', ROUND((`Money_CurrentAmount`),8), 0)) as WithDrawBTC,
						SUM(IF(`Money_Currency` = 2 AND `Money_MoneyAction` = 2 '.$where.', ROUND((`Money_CurrentAmount`),8), 0)) as WithDrawETH,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 2 '.$where.', ROUND((`Money_USDT` - `Money_USDTFee`),8), 0)) as WithDrawRBD,
						SUM(IF(`Money_Currency` != 8 AND `Money_MoneyAction` = 2 '.$where.', ROUND((`Money_USDT` - `Money_USDTFee`),8), 0)) as WithDrawUSD,
						
						SUM(IF(`Money_Currency` != 8 AND `Money_MoneyAction` = 9 AND `Money_Comment` LIKE "Give%" '.$where.', ROUND(`Money_USDT` - `Money_USDTFee`,8), 0)) as GiveUSD,
						SUM(IF(`Money_Currency` != 8 AND `Money_MoneyAction` = 9 AND `Money_Comment` LIKE "Transfer%" '.$where.', ROUND(`Money_USDT` - `Money_USDTFee`,8), 0)) as TransferUSD,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 9 AND `Money_Comment` LIKE "Give%" '.$where.', ROUND(`Money_USDT` - `Money_USDTFee`,8), 0)) as GiveRBD,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 9 AND `Money_Comment` LIKE "Transfer%" '.$where.', ROUND(`Money_USDT` - `Money_USDTFee`,8), 0)) as TransferRBD,
						
						SUM(IF(`Money_Currency` = 8 AND `Money_Comment` Like "Buy%" AND `Money_MoneyAction` = 15 '.$where.', ROUND(`Money_USDT` - `Money_USDTFee`,8), 0)) as BuyRBD,
						SUM(IF(`Money_Currency` != 8 AND `Money_Comment` Like "Buy%" AND `Money_MoneyAction` = 15 '.$where.', ROUND(`Money_USDT` - `Money_USDTFee`,8), 0)) as BuyUSD,
						
						SUM(IF(`Money_Currency` = 8 AND `Money_Comment` Like "Sell%" AND `Money_MoneyAction` = 17 '.$where.', ROUND(`Money_USDT` - `Money_USDTFee`,8), 0)) as SellRBD,
						SUM(IF(`Money_Currency` != 8 AND `Money_Comment` Like "Sell%" AND `Money_MoneyAction` = 17 '.$where.', ROUND(`Money_USDT` - `Money_USDTFee`,8), 0)) as SellToUSD,
						
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 16 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as ITOComRBD,
						SUM(IF(`Money_Currency` != 8 AND `Money_MoneyAction` = 16 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as ITOComUSD,
						
						SUM(IF(`Money_Currency` = 1 AND `Money_MoneyAction` = 3 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as InvestmentBTC,
						SUM(IF(`Money_Currency` = 2 AND `Money_MoneyAction` = 3 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as InvestmentETH,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 3 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as InvestmentRBD,
						
						SUM(IF(`Money_Currency` = 1 AND `Money_MoneyAction` = 8 '.$where.', (ROUND(`Money_USDT` - `Money_USDTFee`,8)), 0)) as CancelBTC,
						SUM(IF(`Money_Currency` = 2 AND `Money_MoneyAction` = 8 '.$where.', (ROUND(`Money_USDT` - `Money_USDTFee`,8)), 0)) as CancelETH,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 8 '.$where.', (ROUND(`Money_USDT` - `Money_USDTFee`,8)), 0)) as CancelRBD,
						
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 5 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as Profit,
						SUM(IF(`Money_Currency` = 2 AND `Money_MoneyAction` = 5 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as ProfitETH,
						SUM(IF(`Money_Currency` = 1 AND `Money_MoneyAction` = 5 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as ProfitBTC,
						
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 4 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as Direct,
						SUM(IF(`Money_Currency` = 2 AND `Money_MoneyAction` = 4 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as DirectETH,
						SUM(IF(`Money_Currency` = 1 AND `Money_MoneyAction` = 4 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as DirectBTC,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 6 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as Indirect,
						SUM(IF(`Money_Currency` = 2 AND `Money_MoneyAction` = 6 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as IndirectETH,
						SUM(IF(`Money_Currency` = 1 AND `Money_MoneyAction` = 6 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as IndirectBTC,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 7 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as Affiliate,
						SUM(IF(`Money_Currency` = 2 AND `Money_MoneyAction` = 7 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as AffiliateETH,
						SUM(IF(`Money_Currency` = 1 AND `Money_MoneyAction` = 7 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as AffiliateBTC,
						
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 16 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as Sbobet,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 11 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as Sicbo
						')
	    			->where('Money_MoneyStatus',1)
	    			->groupBy('Money_User');
		return $result;
    }
	
	static function StatisticTotal($where){
		$where .= '';
		$result = Money::join('users', 'Money_User', 'User_ID')
	    				->selectRaw('
						
						SUM(IF(`Money_Currency` = 8 '.$where.', (ROUND((`Money_USDT` - `Money_USDTFee`),8)), 0)) as BalanceRBD,
						SUM(IF(`Money_Currency` <> 8 '.$where.', (ROUND((`Money_USDT` - `Money_USDTFee`),8)), 0)) as BalanceUSD,
						
						SUM(IF(`Money_Currency` = 1 AND `Money_MoneyAction` = 1 '.$where.', ROUND(`Money_USDT`,8), 0)) as DepositBTC, 
						SUM(IF(`Money_Currency` = 2 AND `Money_MoneyAction` = 1 '.$where.', ROUND(`Money_USDT`,8), 0)) as DepositETH,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 1 '.$where.', ROUND(`Money_USDT`,8), 0)) as DepositRBD,
						SUM(IF(`Money_Currency` <> 8  AND `Money_MoneyAction` = 1 '.$where.', ROUND(`Money_USDT`,8), 0)) as DepositUSD,
						
						SUM(IF(`Money_Currency` = 1 AND `Money_MoneyAction` = 2 '.$where.', ROUND((`Money_CurrentAmount`),8), 0)) as WithDrawBTC,
						SUM(IF(`Money_Currency` = 2 AND `Money_MoneyAction` = 2 '.$where.', ROUND((`Money_CurrentAmount`),8), 0)) as WithDrawETH,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 2 '.$where.', ROUND((`Money_USDT` - `Money_USDTFee`),8), 0)) as WithDrawRBD,
						SUM(IF(`Money_Currency` != 8 AND `Money_MoneyAction` = 2 '.$where.', ROUND((`Money_USDT` - `Money_USDTFee`),8), 0)) as WithDrawUSD,
						
						SUM(IF(`Money_Currency` != 8 AND `Money_MoneyAction` = 9 AND `Money_Comment` LIKE "Give%" '.$where.', ROUND(`Money_USDT` - `Money_USDTFee`,8), 0)) as GiveUSD,
						SUM(IF(`Money_Currency` != 8 AND `Money_MoneyAction` = 9 AND `Money_Comment` LIKE "Transfer%" '.$where.', ROUND(`Money_USDT` - `Money_USDTFee`,8), 0)) as TransferUSD,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 9 AND `Money_Comment` LIKE "Give%" '.$where.', ROUND(`Money_USDT` - `Money_USDTFee`,8), 0)) as GiveRBD,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 9 AND `Money_Comment` LIKE "Transfer%" '.$where.', ROUND(`Money_USDT` - `Money_USDTFee`,8), 0)) as TransferRBD,
						
						SUM(IF(`Money_Currency` = 8 AND `Money_Comment` Like "Buy%" AND `Money_MoneyAction` = 15 '.$where.', ROUND(`Money_USDT` - `Money_USDTFee`,8), 0)) as BuyRBD,
						SUM(IF(`Money_Currency` != 8 AND `Money_Comment` Like "Buy%" AND `Money_MoneyAction` = 15 '.$where.', ROUND(`Money_USDT` - `Money_USDTFee`,8), 0)) as BuyUSD,
						
						SUM(IF(`Money_Currency` = 8 AND `Money_Comment` Like "Sell%" AND `Money_MoneyAction` = 17 '.$where.', ROUND(`Money_USDT` - `Money_USDTFee`,8), 0)) as SellRBD,
						SUM(IF(`Money_Currency` != 8 AND `Money_Comment` Like "Sell%" AND `Money_MoneyAction` = 17 '.$where.', ROUND(`Money_USDT` - `Money_USDTFee`,8), 0)) as SellToUSD,
						
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 16 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as ITOComRBD,
						SUM(IF(`Money_Currency` != 8 AND `Money_MoneyAction` = 16 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as ITOComUSD,
						
						SUM(IF(`Money_Currency` = 1 AND `Money_MoneyAction` = 3 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as InvestmentBTC,
						SUM(IF(`Money_Currency` = 2 AND `Money_MoneyAction` = 3 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as InvestmentETH,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 3 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as InvestmentRBD,
						
						SUM(IF(`Money_Currency` = 1 AND `Money_MoneyAction` = 8 '.$where.', (ROUND(`Money_USDT` - `Money_USDTFee`,8)), 0)) as CancelBTC,
						SUM(IF(`Money_Currency` = 2 AND `Money_MoneyAction` = 8 '.$where.', (ROUND(`Money_USDT` - `Money_USDTFee`,8)), 0)) as CancelETH,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 8 '.$where.', (ROUND(`Money_USDT` - `Money_USDTFee`,8)), 0)) as CancelRBD,
						
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 5 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as Profit,
						SUM(IF(`Money_Currency` = 2 AND `Money_MoneyAction` = 5 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as ProfitETH,
						SUM(IF(`Money_Currency` = 1 AND `Money_MoneyAction` = 5 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as ProfitBTC,
						
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 4 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as Direct,
						SUM(IF(`Money_Currency` = 2 AND `Money_MoneyAction` = 4 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as DirectETH,
						SUM(IF(`Money_Currency` = 1 AND `Money_MoneyAction` = 4 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as DirectBTC,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 6 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as Indirect,
						SUM(IF(`Money_Currency` = 2 AND `Money_MoneyAction` = 6 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as IndirectETH,
						SUM(IF(`Money_Currency` = 1 AND `Money_MoneyAction` = 6 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as IndirectBTC,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 7 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as Affiliate,
						SUM(IF(`Money_Currency` = 2 AND `Money_MoneyAction` = 7 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as AffiliateETH,
						SUM(IF(`Money_Currency` = 1 AND `Money_MoneyAction` = 7 '.$where.', (ROUND(`Money_USDT`,8)), 0)) as AffiliateBTC,
						
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 16 '.$where.', (ROUND(`Money_USDT` - `Money_USDTFee`,8)), 0)) as Sbobet,
						SUM(IF(`Money_Currency` = 8 AND `Money_MoneyAction` = 11 '.$where.', (ROUND(`Money_USDT` - `Money_USDTFee`,8)), 0)) as Sicbo
						')
						->where('Money_MoneyStatus',1)
						->whereNotIn('User_Level', [1,2,3,4,5,10]);
// 						->where('User_Block', 0);
		return $result;
	}
	
	static function getCheckConfirm($id){
		$result = DB::table('money')
						->where('Money_MoneyAction',2)
						->where('Money_Confirm',0)
						->where('Money_ID',$id)->first();
		return $result;
	}


	static function SpamInvest($amount, $coin){
		$invest = DB::table('investment')
		->where('investment_User', Session('user')->User_ID)
		->where('investment_Amount', $amount)
		->where('investment_Currency', $coin)
		->where('investment_Status', 1)
		->take(1)
		->orderBy('investment_ID', 'DESC')
		->first();
		if($invest == null) {
			return 0;
		}
		if($invest != null && $invest->investment_Amount == $amount && $invest->investment_Currency == $coin){
			$temCur = time();
			if($temCur - $invest->investment_Time < 5){
				return 1;
			}
			else {
				return 0;
			}
		}
		


	}

	static function deniedSpam($table432, $amount, $coin, $status, $action = 0){
        $user = Session('user');
        // process table money
        $table = DB::table('money')->where('Money_User', $user->User_ID)
                                    ->where('Money_USDT', $amount)
                                    ->where('Money_Currency', $coin)
                                    ->where('Money_MoneyAction', $action)
                                    ->where('Money_MoneyStatus', $status)
                                    ->take(1)
                                    ->orderBy('Money_ID', 'DESC')
									->first();						  
        if($table == null) {
            return 0;
        }
        if($table != null && $table->Money_USDT == $amount && $table->Money_Currency == $coin && $table->Money_MoneyAction == $action && $table->Money_MoneyStatus == $status){
            $temCur = time();
            if($temCur - $table->Money_Time < 5){
                return 1;
            }
            else {
                return 0;
            }
        }
        
    }
}
