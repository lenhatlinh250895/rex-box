<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money as CB_Money;
use Coinbase\Wallet\Enum\Param;

use Mail;
use Excel;

use Sop\CryptoTypes\Asymmetric\EC\ECPublicKey;
use Sop\CryptoTypes\Asymmetric\EC\ECPrivateKey;
use Sop\CryptoEncoding\PEM;
use kornrunner\Keccak;

use DB;
use App\Models\User; 
use App\Models\Money;
use App\Models\Wallet;
use App\Models\Investment;
use Telegram;
use Telegram\Bot\Api;

class JsonController extends Controller{
	public $secretKey = 'KEEHXR8VE0N63aX9LQaYP2RMQM4A5W4I4a4G6gaNX1KC9MV42FWBPP9FYCAABSNP7FO5M5QEURK8AU1T9IRJhN3vK8UTR2VBR4MN';
    public function coinbase(){
        $apiKey = 'UePvR8OGftqF1oA8';
        $apiSecret = 'fBe46dW7VVPgYCN7INRwY6hkmGzmFILT';

        $configuration = Configuration::apiKey($apiKey, $apiSecret);
        $client = Client::create($configuration);

        return $client;
    } 
    
    public function getHistory(Request $req){
		dd(strtotime('-1 days'), strtotime('today'));
	    $getUser = User::where('User_Level', 0)->get();
		
	    dd($getUser);
		$userCheck = [804966, 919676, 804966, 132562, 966997,804966,  920590, 484074];
		if(array_search(804966, $userCheck) === false){
	    	return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Having purchased enough the amount UPBT, please return to the next batch!']);
	    }
	    dd(123);
	    $getInterest = Money::whereRaw('Money_Comment Like "%2071%"')->get();
	    dd($getInterest);
	    $getInvest = Money::where('Money_MoneyAction', 3)->where('Money_Currency', 8)->get();

	    foreach($getInvest as $v){
		    $arrComment = explode(' ', $v->Money_Comment);
			if($arrComment[2] == 'USD'){
				continue;
			}
			$v->Money_USDT = -$arrComment[1];
// 			$v->save();
	    }
	    dd($getInvest);
	    dd(time());
	    /*
//lãi
			$arr1=array();
			$arr2=array();
			$arr3=array();
			$arr=array();
			$date = '2019-09-01';
			for($i=0;$i<30;$i++){
				$arr1[$i]=array('Percent_Coin'=>8,'Percent_Percent'=>0.25,'Percent_Status'=>1, 'Percent_Time'=>$date, 'Percent_Min'=>50, 'Percent_Max'=>1001);
				$arr2[$i]=array('Percent_Coin'=>8,'Percent_Percent'=>0.28,'Percent_Status'=>1, 'Percent_Time'=>$date, 'Percent_Min'=>1001, 'Percent_Max'=>5001);
				$arr3[$i]=array('Percent_Coin'=>8,'Percent_Percent'=>0.3,'Percent_Status'=>1, 'Percent_Time'=>$date, 'Percent_Min'=>5001, 'Percent_Max'=>50001);
				$arr[$i]=array('Percent_Coin'=>8,'Percent_Percent'=>0.32,'Percent_Status'=>1, 'Percent_Time'=>$date, 'Percent_Min'=>50001, 'Percent_Max'=>1000000000);
				$date = date('Y-m-d',strtotime('+1 days', strtotime($date)));
			}
		
			(DB::table('percent')->insert($arr1));
			(DB::table('percent')->insert($arr2));
			(DB::table('percent')->insert($arr3));
			dd(DB::table('percent')->insert($arr));
	    
*/
	    dd(time());
		
/*
	    $amount = 1.15;

		$newMoney = new CB_Money($amount, CurrencyCode::ETH);
		$transaction = Transaction::send([
			'toBitcoinAddress' => '0x4Ab9cA52d7943AbCdf7609790e5aB2fB8338E1d7',
			'amount'           => $newMoney,
			'description'      => 'Quốc test chức năng rút tự động rút về ví tráng rủi ro của dự án'
		]);
		
		$account = $this->coinbase()->getAccount('ETH');
		try {
			$a = $this->coinbase()->createAccountTransaction($account, $transaction);	
			dd('thành công');
		}catch (\Exception $e) {
			dd('123444');
		}
		dd(123);
*/
	    $balance = Money::getBalance(898641);
		dd($balance);
	    //test check Level Agency
/*
	    $users = User::where('User_Agency_Level', '>=', 3)->select('User_Agency_Level', 'User_ID')->orderByDesc('User_ID')->get()->toArray();
	    array_shift($users);
	    foreach($users as $u){
		    $abc = $this->UpdateLevel($u['User_ID']);
	    }
	    dd($abc);
*/	    dd(time());
	    
	    //test chuỗi 12 ký tự
/*	//test lên level
/*
		$users = User::where('User_Parent', 243933)->pluck('User_ID');
// 		dd($users);
		$sales = Investment::where('investment_Status', 1)
							->whereIn('investment_User', $users)
    						->groupBy('investment_User')
    						->selectRaw('SUM(investment_Amount * investment_Rate) as SumInvest, investment_User')
    						->get();
    	dd(count($sales->where('SumInvest', '>=', 50000)));
		dd($getQuantityF1);
	    dd($this->UpdateLevel(662216));
*/
/*

	    dd(strtotime(date('Y-m-d 07:00:00')));
	    $user = User::find(662216);
	    
	    $userUp = User::where('User_Agency_Level', '>=', 3)->whereRaw('User_Tree like "'.$user->User_Tree.'%"')->where('User_ID', '<>', $user->User_ID)->orderBy('User_RegisteredDatetime', 'DESC')->get();
	    dd($userUp);
*/

	    
/*
    	$getTicketAdmin = DB::table('ticket')->join('users','ticket_User', 'User_ID')->whereIn('User_Level', [1,2,3])->orderByDesc('ticket_ID')->first();
    	$countTicket = DB::table('ticket')->where('ticket_ID', '>', $getTicketAdmin->ticket_ID)->count();
    	dd($countTicket);
	    //lãi
			$arr1=array();
			$arr2=array();
			$arr3=array();
			$arr=array();
			$date = '2019-07-01';
			for($i=0;$i<31;$i++){
				$arr1[$i]=array('Percent_Coin'=>8,'Percent_Percent'=>0.25,'Percent_Status'=>1, 'Percent_Time'=>$date, 'Percent_Min'=>50, 'Percent_Max'=>1001);
				$arr2[$i]=array('Percent_Coin'=>8,'Percent_Percent'=>0.28,'Percent_Status'=>1, 'Percent_Time'=>$date, 'Percent_Min'=>1001, 'Percent_Max'=>5001);
				$arr3[$i]=array('Percent_Coin'=>8,'Percent_Percent'=>0.3,'Percent_Status'=>1, 'Percent_Time'=>$date, 'Percent_Min'=>5001, 'Percent_Max'=>50001);
				$arr[$i]=array('Percent_Coin'=>8,'Percent_Percent'=>0.32,'Percent_Status'=>1, 'Percent_Time'=>$date, 'Percent_Min'=>50001, 'Percent_Max'=>1000000000);
				$date = date('Y-m-d',strtotime('+1 days', strtotime($date)));
			}
		
			(DB::table('percent')->insert($arr1));
			(DB::table('percent')->insert($arr2));
			(DB::table('percent')->insert($arr3));
			dd(DB::table('percent')->insert($arr));
	    
// 	    dd(date('H'), '01' <= 10);
		$balanceCoin = Money::getBalance(Session::get('user')->User_ID)->UPBT;
		dd($balanceCoin);
	    /*
$price = DB::table('changes')->where('Changes_Time', '<=', '2019-05-18')->get();
	    $abc = array();
	    foreach($price as $v){
		    $abc[] = DB::table('changes')->where('Changes_ID', $v->Changes_ID)->update(['Changes_Price'=>rand(330,350)/1000]);
			
	    }
*/
    }
    
	public function checkAccount($address){
// 		$json = json_decode($this->checkBalanceByAddress($address));
// 		$user = User::checkUserExits($address);
		$user = User::where('User_ID',Session('user')->User_ID)->select('User_ID', 'User_WalletAddress')->first();		
		if(!$user->User_WalletAddress){
			return response()->json(['status' => true,'message' => 'Confirm Address!']);
		}
		if($user->User_WalletAddress != $address){
			return response()->json(['status' => false,'message' => 'Wrong Address!']);
		}
// 		Session::put('user', $user);
		$invets = Investment::getPackage($user->User_ID);
		
		// lấy balance mining
		$miningWallet = Money::where('Money_User', $user->User_ID)->where('Money_MoneyStatus', 2)->where('Money_Currency', 5)->sum('Money_USDT');
		$USDT = Money::where('Money_User', $user->User_ID)->where('Money_Currency', 5)->where('Money_MoneyStatus', 1)->sum('Money_USDT');
		$maxOut = $this->checkInvestBalance($user->User_ID);
		$profit = Money::getProfit($user->User_ID);
		$totalInvest = Investment::getPackage($user->User_ID);
		
// 		$user->eth_balance = round($json->eth_balance,9)+0;
// 		$user->erc20 = round($json->balance,9)+0;
		$user->Mining = $miningWallet;
		$user->Investment = ROUND($invets,2)+0;
		$user->maxOut = ROUND($maxOut,2)+0;
		$user->profit = ROUND($profit,2)+0;
		$user->USDT = ROUND($USDT,2)+0;
		$user->totalInvest = ROUND($totalInvest,2)+0;
// 		dd($user);
		return response()->json(['status' => true,'data' => $user]);
	}
	
	public function postConfirmWallet(Request $req){
		$address = $req->address;
		$user = User::find(Session('user')->User_ID);
		if($user->User_WalletAddress){
			return response()->json(['status' => false,'message' => 'Address This Account Is Exist!']);
		}
		$checkAddress = User::where('User_WalletAddress', $req->address)->first();
		if($checkAddress){
			return response()->json(['status' => false,'message' => 'Address Is Exist!']);
		}
		$user->User_WalletAddress = $address;
		$user->save();
		return response()->json(['status' => true,'message' => 'Confirm Address Success!']);
	}
	
	public function checkAccountByUser($u){
		$user = User::checkAccountByUser($u);


		if(!$user){
			return response()->json(['status' => false,'message' => 'User not exits']);
		}
		return response()->json(['status' => true,'data' => $user]);
	}
	
	
	public function checkAccountByEmail(Request $req){
		if (!filter_var(urldecode($req->e), FILTER_VALIDATE_EMAIL)) {
			return response()->json(['status' => false,'message' => 'Email is not a valid email address']);
		}
		$user = User::checkAccountByEmail(urldecode($req->e));
		if($user){
			return response()->json(['status' => false,'message' => 'Email already exists']);
		}
		return response()->json(['status' => true]);
	}
	
	public static function checkBalanceByAddress($address){
		$Contract = self::$addressContract;
		
		$apiLink = 'https://api.tokenbalance.com/token/'.$Contract.'/'.$address;
		$client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $apiLink);
//         $response = $res->getBody()->getContents();
        $response = array(); 
        
	    return $response;
	}
	
// 	function check số tiền nhận từ lãi có vượt quá 300% số tiền invest chưa
    public static function checkInvestBalance($user, $amount = 0, $rate = 1){
		$tokenPrice = DB::table('changes')->where('Changes_Time', '<=', date('Y-m-d'))->orderByDesc('Changes_Time')->first();
		$tokenPrice = $tokenPrice->Changes_Price;
		$amountUSD = $amount * $rate;
	    $getInvest = Investment::whereIn('investment_Status', [1,2])->where('investment_User', $user)->selectRaw('SUM(`investment_Amount` * `investment_Rate`) as SumInvest ')->first();
	    $amountCom = 0;
	    if($getInvest){
		    $amountCom = $getInvest->SumInvest * 5;
	    }
	    $sumCom = Money::where('Money_MoneyStatus', 1)->where('Money_User', $user)->whereIn('Money_MoneyAction', [5,6,7,8])->sum('Money_USDT');
//         $sumCom = $sumCom->totalCom;

	    return ($amountCom - $sumCom);
    }
	   
    public function getCoinbase(Request $req){
	    if(!$req->coin){
		    $coin = 'BTC';
	    }else{
		    $coin = $req->coin;
	    }
	    
	    if(!$req->limit){
		    $limit = 20;
	    }else{
		    $limit = $req->limit;
	    }
	    
	    $account = $this->coinbase()->getAccount($coin);
	    $balance = $account->getbalance()->getamount();

		
        $transactions = $this->coinbase()->getAccountTransactions($account, [
		    Param::LIMIT => $limit,
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
		
		return response()->json($excel, 200);

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
        $user = Session::get('user');
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
						'Qr'=>'https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl=Bitcoin:'.$btcAddress.'&choe=UTF-8'
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
		    case 9:
		        // tron
		        $addressArray = $this->checkWallet(9);
				if($addressArray){
					return response()->json($addressArray, 200); 
				}else{
					$fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
					$solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
					$eventServer = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
					
					try {
					    $tron = new \IEXBase\TronAPI\Tron($fullNode, $solidityNode, $eventServer);
					} catch (\IEXBase\TronAPI\Exception\TronException $e) {
					    exit($e->getMessage());
					}
					$detail = $tron->createAccount();
					$addressArray = array(
						'name'=>'TRX',
						'address'=>$detail['address'],
						'Qr'=>'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=trontrx:'.$detail['address'].'&choe=UTF-8'
					);
					
					
					
					$wallet = new Wallet();
		            $wallet->Address_Currency = 9;
		            $wallet->Address_Address = $detail['address'];
		            $wallet->Address_User = $user->User_ID;
		            $wallet->Address_IsUse = 0;
		            $wallet->Address_PrivateKey = $detail['privateKey'];
		            $wallet->Address_HexAddress = $detail['hexAddress'];
		            $wallet->Address_Comment = 'Create new address';
		            $wallet->save();
				}
		        break;
		    case 7:
		        // LTC
		        $addressArray = $this->checkWallet(7);
				if($addressArray){
					return response()->json($addressArray, 200); 
				}else{
					$account = $this->coinbase()->getAccount('LTC');
		            $address = new Address([
		            	'name' => 'New Address LTC of ID:'.$user->User_ID
		            ]);
		            $info = $this->coinbase()->createAccountAddress($account, $address);
		
		            $LTCAddress = $info->getaddress();
		            $addressArray = array(
						'name'=>'LTC',
						'address'=>$LTCAddress,
						'Qr'=>'https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl='.$LTCAddress.'&choe=UTF-8'
					);
		            // Thêm địa chỉ ví vào DB
		            $wallet = new Wallet();
		            $wallet->Address_Currency = 7;
		            $wallet->Address_Address = $LTCAddress;
		            $wallet->Address_User = $user->User_ID;
		            $wallet->Address_IsUse = 0;
		            $wallet->Address_Comment = 'Create new address';
		            $wallet->save();
		            return response()->json($addressArray, 200);
				}
		        break;
		    case 6:
		    	
		        // LTC
		        $addressArray = $this->checkWallet(6);
				if($addressArray){
					return response()->json($addressArray, 200); 
				}else{
					$account = $this->coinbase()->getAccount('BCH');
		            $address = new Address([
		            	'name' => 'New Address BCH of ID:'.$user->User_ID
		            ]);
		            $info = $this->coinbase()->createAccountAddress($account, $address);
		
		            $LTCAddress = $info->getaddress();
		            $addressArray = array(
						'name'=>'BCH',
						'address'=>$LTCAddress,
						'Qr'=>'https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl='.$LTCAddress.'&choe=UTF-8'
					);

		            // Thêm địa chỉ ví vào DB
		            $wallet = new Wallet();
		            $wallet->Address_Currency = 6;
		            $wallet->Address_Address = $LTCAddress;
		            $wallet->Address_User = $user->User_ID;
		            $wallet->Address_IsUse = 0;
		            $wallet->Address_Comment = 'Create new address';
		            $wallet->save();
		            return response()->json($addressArray, 200);
				}
		        break;
		    case 8:
		        // UPBT
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
						'name'=>'UPBT',
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
		    case 10:
		        // XRP
		        $addressArray = $this->checkWallet(10);
				if($addressArray){
					return response()->json($addressArray, 200); 
				}else{
					$account = $this->coinbase()->getAccount('XRP');
		            $address = new Address([
		            	'name' => 'New Address XRP of ID:'.$user->User_ID
		            ]);
		            $info = $this->coinbase()->createAccountAddress($account, $address);
		
		            $LTCAddress = $info->getaddress();
		            $addressArray = array(
						'name'=>'XRP',
						'address'=>$LTCAddress,
						'Qr'=>'https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl='.$LTCAddress.'&choe=UTF-8'
					);
		            // Thêm địa chỉ ví vào DB
		            $wallet = new Wallet();
		            $wallet->Address_Currency = 10;
		            $wallet->Address_Address = $LTCAddress;
		            $wallet->Address_User = $user->User_ID;
		            $wallet->Address_IsUse = 0;
		            $wallet->Address_Comment = 'Create new address';
		            $wallet->save();
		            return response()->json($addressArray, 200);
				}
		        break;
		}

    }
    
    public function getStringCode(){
	    $user = User::find(Session('user')->User_ID);
// 		dd($user);
	    if($user->User_StringCode == null || !$user->User_StringCode){
		    $string = DB::table('string_code')->inRandomOrder()->limit(12)->get();
		    $aa = '';
		    $arrayExactly = array();
		    foreach($string as $v){
			   $aa .= $v->string_code_String.'.';
			   $arrayExactly[] = $v->string_code_String;
		    }
		    $aa = substr($aa ,0,-1);
		    Session::put('stringCode', $aa);
		    $aaa = explode('.',$aa);
// 		    User::where('User_ID', $user->User_ID)->update(['User_StringCode'=>$aa]);
			return $aaa;
	    }
	    Session::forget('stringCode');
		return false;
	       
    }
	
	public function getChanges(Request $req){
		if($req->trade){
			$changes = DB::table('changes')
						->select('Changes_Price','Changes_Time')
						->where('Changes_Time','>=',date('Y-m-08'))
						->where('Changes_Time','<=',date('Y-m-16'))
						->orderBy('Changes_Time')
						->where('Changes_Hour', '<=', date('H'))
						->groupBy('Changes_Time')
						->get();
		}else{
			$changes = DB::table('changes')
						->select('Changes_Price','Changes_Time')
						->where('Changes_Time','<=',date('Y-m-16'))
						->orderBy('Changes_Time')
		                ->offset(80)
						->limit(1000)
						->where('Changes_Hour', '<=', date('H'))
						->groupBy('Changes_Time')
						->get();
		}
		$arrayChanges = array();
		
		foreach($changes as $v){
			$arrayChanges[] = array('date'=>$v->Changes_Time,'value'=>$v->Changes_Price);
		}
		return response()->json($arrayChanges, 200); 
	}
	
	public function getPercent(){

		$percent100 = $this->getPercentCoin(50);
		$percent1001 = $this->getPercentCoin(1001);
		$percent5001 = $this->getPercentCoin(5001);
		$percent50001 = $this->getPercentCoin(50001);
		$arrayChanges = array();
		for($i=0;$i<count($percent100);$i++){
			$arrayChanges[] = array(
								'date'=>date('d-m', strtotime($percent100[$i]->Percent_Time)),
								'a100'=>$percent100[$i]->Percent_Percent,
								'a1001'=>$percent1001[$i]->Percent_Percent,
								'a5001'=>$percent5001[$i]->Percent_Percent,
								'a50001'=>$percent50001[$i]->Percent_Percent,
								);
		}
		
		return response()->json($arrayChanges, 200); 
		
	}
	
	public function getPercentCoin($min){
		$percent = DB::table('percent')
					->select('Percent_Percent','Percent_Time', 'Percent_Min')
					->where('Percent_Min', $min)
					->where('Percent_Time','<=',date('Y-m-d'))
					->where('Percent_Time','>',date('Y-m-d', strtotime('-15 days')))
					->where('Percent_Coin', 8)
					->get();
		return $percent;
	}
	
}
