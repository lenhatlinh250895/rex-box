<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
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
use Coinbase\Wallet\Enum\Param;

use IEXBase\TronAPI\Provider\HttpProvider;
use IEXBase\TronAPI\Tron;

use Sop\CryptoTypes\Asymmetric\EC\ECPublicKey;
use Sop\CryptoTypes\Asymmetric\EC\ECPrivateKey;
use Sop\CryptoEncoding\PEM;
use kornrunner\Keccak;

use DB;
use Excel;

use Mail;

class CoinbaseController extends Controller{
	
	public static function coinbase(){
        $apiKey = 'Ygutdhfy3S3tDG4R';
        $apiSecret = 'T9Nc28q7hSmXvgNOCu5pEDZSEJDTlTVs';
        $configuration = Configuration::apiKey($apiKey, $apiSecret);
        $client = Client::create($configuration);
        return $client;
    }
    
    
    /* giá mua được giảm đi 1% */
    public static function coinRateBuy($system = null){
	    if($system == 'ETH' || $system == 'BTC'){
// 		    $coin[$system] = self::coinbase()->getBuyPrice($system.'-USD')->getAmount();
		    $coin[$system] = json_decode(file_get_contents('https://api.binance.com/api/v1/ticker/price?symbol='.$system.'USDT'))->price;
	    }elseif($system == 'RBD'){
			$tokenPrice = DB::table('changes')->where('Changes_Time', '>=', date('Y-m-d H:i:00'))->whereRaw('MINUTE(Changes_Time) = '.date('i'))->orderBy('Changes_Time', 'DESC')->first();
			if(!$tokenPrice){
				$ticker = json_decode(file_get_contents('https://coinsbit.io/api/v1/public/ticker?market=RBD_USDT'));
			    if(isset($ticker)){
				    $priceRBD = ($ticker->result->bid+$ticker->result->ask)/2;
			    	$coin['RBD'] = $priceRBD;
					$data = ['Changes_Price'=>$coin['RBD'], 'Changes_Time'=>date('Y-m-d H:i:s'), 'Changes_Status'=>1, 'Log' => 'coinRateBuy!' ];
			    }else{
					$getPrice = DB::table('changes')->orderByDesc('Changes_Time')->first();
					$data = ['Changes_Price'=>$getPrice->Changes_Price, 'Changes_Time'=>date('Y-m-d H:i:s'), 'Changes_Status'=>1, 'Log' => 'coinRateBuy!' ];
			    }
				DB::table('changes')->insert($data);
				$tokenPrice = DB::table('changes')->orderByDesc('Changes_Time')->first();
			}else{
				$coin['RBD'] = $tokenPrice->Changes_Price;
			}

	    }
	    else{
// 		    $coin['BTC'] = self::coinbase()->getBuyPrice('BTC-USD')->getAmount();
// 			$coin['ETH'] = self::coinbase()->getBuyPrice('ETH-USD')->getAmount();
		    $coin['BTC'] = json_decode(file_get_contents('https://api.binance.com/api/v1/ticker/price?symbol=BTCUSDT'))->price;
		    $coin['ETH'] = json_decode(file_get_contents('https://api.binance.com/api/v1/ticker/price?symbol=ETHUSDT'))->price;
			
			$tokenPrice = DB::table('changes')->where('Changes_Time', '>=', date('Y-m-d 00:00:00'))->whereRaw('MINUTE(Changes_Time) = '.date('i'))->orderBy('Changes_Time', 'DESC')->first();
			if(!$tokenPrice){
				$ticker = json_decode(file_get_contents('https://coinsbit.io/api/v1/public/ticker?market=RBD_USDT'));
			    if(isset($ticker)){
				    $priceRBD = ($ticker->result->bid+$ticker->result->ask)/2;
// 				    $priceRBD = ($ticker->low+$ticker->high)/2;
			    	$coin['RBD'] = $priceRBD;
					$data = ['Changes_Price'=>$coin['RBD'], 'Changes_Time'=>date('Y-m-d H:i:s'), 'Changes_Status'=>1, 'Log' => 'coinRateBuy!' ];
			    }else{
					$getPrice = DB::table('changes')->orderByDesc('Changes_Time')->first();
					$data = ['Changes_Price'=>$getPrice->Changes_Price, 'Changes_Time'=>date('Y-m-d H:i:s'), 'Changes_Status'=>1, 'Log' => 'coinRateBuy!' ];
			    }
				DB::table('changes')->insert($data);
				$tokenPrice = DB::table('changes')->orderByDesc('Changes_Time')->first();
			}else{
				$coin['RBD'] = $tokenPrice->Changes_Price;
			}
	    }
	   
	    $coin['USD'] = 1;
		
	    if($system){
		    return $coin[$system];
	    }
	    return $coin;
    }
    
	public function checkWallet($coin){
		$user = Session::get('user');
		// thông tin coin
		$coinInfo = DB::table('currency')->where('Currency_ID', $coin)->first();

		if($coinInfo){
			$address = DB::table('address')->where('Address_User', $user->User_ID)->where('Address_Currency', $coin)->where('Address_IsUse', 0)->first();
			if($address){
				$addressArray = array(
					'name'=>$coinInfo->Currency_Symbol,
					'address'=>$address->Address_Address,
					'Qr'=>'https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl='.$coinInfo->Currency_uriScheme.':'.$address->Address_Address.'&choe=UTF-8'
				);
				return $addressArray; 
			}
			return null;
		}
		return null;
	}
    
    public function getAddress(Request $req){
        $user = Session('user');
        switch ($req->coin) {
		    case 1:
		    	// btc
				$addressArray = $this->checkWallet(1);
				if($addressArray){
					return response()->json($addressArray, 200); 
				}else{
					$account = $this->coinbase()->getAccount('BTC');
		            $address = new Address([
		            	'name' => 'New Address BTC of ID:'.$user->User_ID
		            ]);
		            $info = $this->coinbase()->createAccountAddress($account, $address);
		
		            $btcAddress = $info->getaddress();
		
		            $addressArray = array(
						'name'=>'BTC',
						'address'=>$btcAddress,
						'Qr'=>'https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl=bitcoin:'.$btcAddress.'&choe=UTF-8'
					);
		            
		            // Thêm địa chỉ ví vào DB
		            $wallet = new Wallet();
		            $wallet->Address_Currency = 1;
		            $wallet->Address_Address = $btcAddress;
		            $wallet->Address_User = $user->User_ID;
		            $wallet->Address_IsUse = 0;
		            $wallet->Address_Comment = 'Create new address';
		            $wallet->save();
		            return response()->json($addressArray, 200);
				}
		        break;
		    case 2:
		        // eth
		        $addressArray = $this->checkWallet(2);
				if($addressArray){
					return response()->json($addressArray, 200); 
				}else{
					$account = $this->coinbase()->getAccount('ETH');
		            $address = new Address([
		            	'name' => 'New Address ETH of ID:'.$user->User_ID
		            ]);
		            $info = $this->coinbase()->createAccountAddress($account, $address);
		
		            $ethAddress = $info->getaddress();
		            $addressArray = array(
						'name'=>'ETH',
						'address'=>$ethAddress,
						'Qr'=>'https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl='.$ethAddress.'&choe=UTF-8'
					);
		            // Thêm địa chỉ ví vào DB
		            $wallet = new Wallet();
		            $wallet->Address_Currency = 2;
		            $wallet->Address_Address = $ethAddress;
		            $wallet->Address_User = $user->User_ID;
		            $wallet->Address_IsUse = 0;
		            $wallet->Address_Comment = 'Create new address';
		            $wallet->save();
		            return response()->json($addressArray, 200);
				}
		        
		        break;
		    case 8:
		        // RBD
		        $addressArray = $this->checkWallet(8);
				if($addressArray){
					return response()->json($addressArray, 200); 
				}else{
					
				    $config = [
					    'private_key_type' => OPENSSL_KEYTYPE_EC,
					    'curve_name' => 'secp256k1'
					];
					$res = openssl_pkey_new($config);
					if (!$res) {
						return response(base64_encode(xxtea_encrypt(json_encode(array('status'=>false, 'message'=>'ERROR: Fail to generate private key.')),$this->keyHash)), 200);
					}
					// Generate Private Key
					openssl_pkey_export($res, $priv_key);
					// Get The Public Key
					$key_detail = openssl_pkey_get_details($res);
					$pub_key = $key_detail["key"];
					$priv_pem = PEM::fromString($priv_key);
					// Convert to Elliptic Curve Private Key Format
					$ec_priv_key = ECPrivateKey::fromPEM($priv_pem);
					// Then convert it to ASN1 Structure
					$ec_priv_seq = $ec_priv_key->toASN1();
					// Private Key & Public Key in HEX
					$priv_key_hex = bin2hex($ec_priv_seq->at(1)->asOctetString()->string());
					$priv_key_len = strlen($priv_key_hex) / 2;
					$pub_key_hex = bin2hex($ec_priv_seq->at(3)->asTagged()->asExplicit()->asBitString()->string());
					$pub_key_len = strlen($pub_key_hex) / 2;
					// Derive the Ethereum Address from public key
					// Every EC public key will always start with 0x04,
					// we need to remove the leading 0x04 in order to hash it correctly
					$pub_key_hex_2 = substr($pub_key_hex, 2);
					$pub_key_len_2 = strlen($pub_key_hex_2) / 2;
					// Hash time
			
					$hash = Keccak::hash(hex2bin($pub_key_hex_2), 256);
					// Ethereum address has 20 bytes length. (40 hex characters long)
					// We only need the last 20 bytes as Ethereum address
					$wallet_address = '0x' . substr($hash, -40);
					$wallet_private_key = '0x' . $priv_key_hex;
					
		            $addressArray = array(
						'name'=>'RBD',
						'address'=>$wallet_address,
						'Qr'=>'https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl='.$wallet_address.'&choe=UTF-8'
					);
					
					$wallet = new Wallet();
		            $wallet->Address_Currency = 8;
		            $wallet->Address_Address = $wallet_address;
		            $wallet->Address_User = $user->User_ID;
		            $wallet->Address_IsUse = 0;
		            $wallet->Address_PrivateKey = $wallet_private_key;
		            $wallet->Address_HexAddress = '';
		            $wallet->Address_Comment = 'Create new address';
		            $wallet->save();
		            return response()->json($addressArray, 200);
				}
		        break;
		}

		
		
    }
    
    
    public static function coinRateSell($system = null){
	    if($system == 'ETH' || $system == 'BTC'){
// 		    $coin[$system] = self::coinbase()->getBuyPrice($system.'-USD')->getAmount();
		    $coin[$system] = json_decode(file_get_contents('https://api.binance.com/api/v1/ticker/price?symbol='.$system.'USDT'))->price;
	    }else{
/*
		    $coin['BTC'] = self::coinbase()->getBuyPrice('BTC-USD')->getAmount();
			$coin['ETH'] = self::coinbase()->getBuyPrice('ETH-USD')->getAmount();
*/
		    $coin['BTC'] = json_decode(file_get_contents('https://api.binance.com/api/v1/ticker/price?symbol=BTCUSDT'))->price;
		    $coin['ETH'] = json_decode(file_get_contents('https://api.binance.com/api/v1/ticker/price?symbol=ETHUSDT'))->price;
	    }
	    $coin['USD'] = 1;
	    
	    $tokenPrice = DB::table('changes')->where('Changes_Time', date('Y-m-d'))->where('Changes_Hour', '<=', date('H'))->orderBy('Changes_Hour', 'DESC')->first();
		if(!$tokenPrice){
			$getPrice = DB::table('changes')->orderByDesc('Changes_Time')->first();
			$data = ['Changes_Price'=>$getPrice->Changes_Price, 'Changes_Time'=>date('Y-m-d'), 'Changes_Status'=>1 ];
			DB::table('changes')->insert($data);
			$tokenPrice = DB::table('changes')->where('Changes_Time', date('Y-m-d'))->first();
		}
		
		$coin['RBD'] = $tokenPrice->Changes_Price;
		if($system){
		    return $coin[$system];
	    }
	    return $coin;	
    }
    
    
    public static function getAccountTransactions($symbol){
	    $account = self::coinbase()->getAccount($symbol);
	    $transactions = self::coinbase()->getAccountTransactions($account);
	    return $transactions;
    }
    
    
    public static function getAccountDeposit($symbol){
	    $account = self::coinbase()->getAccount($symbol);
	    $transactions = self::coinbase()->getAccountDeposit($account);
	    return $transactions;
    }
    
    public function getCoinbase(Request $req){
	    if(!$req->Coin){
		    $coin = 'BTC';
	    }else{
		    $coin = $req->Coin;
	    }
	    $account = $this->coinbase()->getAccount($coin);
	    $balance = $account->getbalance()->getamount();

		
        $transactions = $this->coinbase()->getAccountTransactions($account, [
		]);
		
		$excel = array();
		$i = 0;
		foreach($transactions as $v){
			if($i==0){
				$plus = 0;
			}else{
				$plus = $transactions[$i-1]->getamount()->getamount();
			}
			if($v->getdescription() != null){
				$getdescription = $v->getdescription();
				
			}else{
				$getdescription = 'User Deposit (user nào thì e chịu)';
			}
			array_push($excel, array(
				$i+1,
				$v->getcreatedAt()->format('Y-m-d H:i:s'),
				number_format($balance + $plus, 8),
				$v->getamount()->getamount(),
				$v->getnetwork()->gethash(),
				$getdescription
			));
			$i++;
		}
		if(Input::get('export')){
			if(Session('user')->User_Level != 1 && Session('user')->User_Level != 2){
				dd('stop');
			}
			$history = $excel;

			$listHistory = array();
			
			//xuất excel
			$listHistoryExcel[] = array('ID','Time', 'Balance', 'Amount','Description','Transaction ID');
			$i = 1;
			
			foreach ($history as $d)
			{
				$listHistoryExcel[$i][0] = $d[0];
				$listHistoryExcel[$i][1] = $d[1];
				$listHistoryExcel[$i][2] = $d[2];
				$listHistoryExcel[$i][3] = $d[3];
				$listHistoryExcel[$i][4] = $d[5];
				$listHistoryExcel[$i][5] = $d[4];
				$i++;
			}
			Excel::create('Transaction-'.$coin.''.date('YmdHis'), function($excel) use ($listHistoryExcel, $coin) {
				$excel->setTitle('Transaction-'.$coin.''.date('YmdHis'));
				$excel->setCreator('Transaction-'.$coin.''.date('YmdHis'))->setCompany('SBANK');
				$excel->setDescription('Transaction-'.$coin.''.date('YmdHis'));
				$excel->sheet('sheet1', function ($sheet) use ($listHistoryExcel) {
					$sheet->fromArray($listHistoryExcel, null, 'A1', false, false);
				});
			})->download('xls');
		}
		return view('System.Coinbase.Transaction');
    }
	public function getRateToken(){
		return self::coinRateBuy('RBD');
	}
}