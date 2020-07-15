<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Wallet extends Model{
    protected $table = "address";
    
    protected $fillable = ['Address_ID','Address_Currency', 'Address_Address', 'Address_User', 'Address_CreateAt', 'Address_UpdateAt', 'Address_IsUse', 'Address_Comment'];

    public $timestamps = true;

    const CREATED_AT = 'Address_CreateAt';
	const UPDATED_AT = 'Address_UpdateAt';

    public static function getAddressByUser($user, $btc = 0){
    	$result = DB::table('address')
    					->join('currency', 'Address_Currency', 'Currency_ID')
                        ->select('Address_Address', 'Currency_Symbol', 'Address_Currency')
                        ->where('Address_IsUse',0)
                        ->where('Address_User',$user);
        if($btc != 0){
	        $result->where('Address_Currency',$btc);
        }
        return $result->get();
    }
    
    public static function getAddress($address, $coin = 1){

	    $result = DB::table('address')
                        ->select('Address_User')
                        ->where('Address_Address', $address)
                        ->where('Address_Currency',$coin)
                        ->where('Address_IsUse',0)
                        ->first();
        return $result;
    }
}
