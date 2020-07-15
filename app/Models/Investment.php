<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Investment extends Model
{
    protected $table = "investment";

    protected $fillable = ['investment_ID','investment_User', 'investment_Amount','investment_Rate', 'investment_Hash', 'investment_Currency', 'investment_Time', 'investment_Status'];

    public $timestamps = false;

    protected $primaryKey = 'investment_ID';

	public static function getPackage($u){
		$Invest = Investment::where('investment_Status', 1)->where('investment_User', $u)->selectRaw('SUM(`investment_Amount` * `investment_Rate`) as SumInvest ')->first();
		if($Invest){
			return $Invest->SumInvest;	
		}
		return 0;
	}
}
