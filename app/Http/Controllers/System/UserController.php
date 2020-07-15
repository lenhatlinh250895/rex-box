<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\GoogleAuth;
use App\Models\Profile;
use App\Models\Investment;
use PragmaRX\Google2FA\Google2FA;
use App\Http\Requests\KYC;
use App\Models\User;
use App\Models\Money;
use DB;
class UserController extends Controller{

	public $secretKey = 'KEEHXR8VE0N63aX9LQaYP2RMQM4A5W4I4a4G6gaNX1KC9MV42FWBPP9FYCAABSNP7FO5M5QEURK8AU1T9IRJhN3vK8UTR2VBR4MN';



    public function getList()
    {
        
        $user = User::where('User_ID', Session::get('user')->User_ID)->first();
        
        $membersList = User::select('Profile_Status','User_ID', 'User_Email', 'User_RegisteredDatetime', 'User_Parent', DB::raw("(CHAR_LENGTH(User_SunTree)-CHAR_LENGTH(REPLACE(User_SunTree, ',', '')))-" . substr_count($user->User_SunTree, ',') . " AS f, User_Agency_Level, User_SunTree"))
                        ->leftJoin('profile', 'Profile_User', 'User_ID')
                        ->whereRaw('User_SunTree LIKE "'.$user->User_SunTree.'%"')
						->where('User_ID','<>',$user->User_ID)
						->orderBy('User_RegisteredDatetime','DESC')
                        ->get();
         
        foreach($membersList as $v){
            $v->aaa = DB::table('investment')
                    ->where('investment_User', $v->User_ID)
                    ->where('investment_Status', 1)
                    ->sum(DB::raw('investment_Amount * investment_Rate'));
                    
            $v->total_invest_branch = User::join('investment', 'investment_User', 'User_ID')->where('User_SunTree', 'LIKE', $v->User_SunTree.'%')->sum(DB::raw('investment_Amount * investment_Rate'));
	            
            $v->buy = Money::where('Money_User', $v->User_ID)
                            ->where('Money_MoneyStatus', 1)
                            ->where('Money_MoneyAction', 15)
                            ->where('Money_Comment', 'LIKE', '%From%')
                            ->sum(DB::raw('Money_USDT'));
                    
            $v->total_buy_branch = User::join('money', 'Money_User', 'User_ID')
                                    ->where('User_SunTree', 'LIKE', $v->User_SunTree.'%')
                                    ->where('Money_MoneyStatus', 1)
                                    ->where('Money_MoneyAction', 15)
                                    ->where('Money_Comment', 'LIKE', '%From%')
                                    ->sum(DB::raw('Money_USDT'));
        }
        $total_invest_root = User::join('investment', 'investment_User', 'User_ID')->where('User_SunTree', 'LIKE', $user->User_SunTree.'%')->sum(DB::raw('investment_Amount * investment_Rate'));

        $total_buy_root = User::join('money', 'Money_User', 'User_ID')
                        ->where('User_SunTree', 'LIKE', $user->User_SunTree.'%')
                        ->where('Money_MoneyStatus', 1)
                        ->where('Money_MoneyAction', 15)
                        ->where('Money_Currency', 8)
                        ->where('Money_Comment', 'LIKE', '%From%')
                        ->sum(DB::raw('Money_USDT'));
                        
	    return view('System.User.List', compact('total_buy_root','buy', 'total_buy_branch','membersList', 'total_invest_root'));
    }

    public function getMembers($userID, $level = 0)
    {
        ++$level;
        $membersList = User::where('User_Parent', $userID)
            ->select('User_ID', 'User_Email', 'User_RegisteredDatetime', 'User_Parent')
            ->get();
        if ($membersList) {
            foreach ($membersList as $user) {
                $user->User_F = $level;
                $user->children = $this->getMembers($user->User_ID, $level);
            }
        }

        return $membersList->toArray();
    }

    public function getTree(Request $request)
    {
        



        if (!$request->userID) {
            $userID = session('user')->User_ID;
        }
        // $usersTreeList = [];
        // $user = User::Where('User_Tree', 'like', "$userID")
        //     ->orWhere('User_Tree', 'like', "%$userID")
        //     ->select('User_ID as id', 'User_Parent as pid','User_Email as email' )
        //     ->first()->toArray();

        // $user['level'] = 'Parent';
        // $user['img'] = "system/images/user.png";
        // array_push($usersTreeList, $user);
        // $this->getUsersTreeList($userID, $usersTreeList);

        $user = Session('user');
        $list = array(
			'id' => $user->User_ID,
            'name' => $user->User_ID,
            'title' => $user->User_Email,
            'children' => $this->buildTree($user->User_ID),
            'className' => 'node-tree '.strtoupper($user->user_Name),
        );
        $list = json_encode($list);
        $side_current = User::where('User_ID', session('user')->User_ID)->value('User_Side_Active');

        return view('System.User.User-Tree', compact('list', 'side_current'));
    }
    function buildTree($idparent, $idRootTemp = null, $barnch = null) {

        $build = User::select('User_Email','User_ID', 'User_Tree', 'User_IsRight')->whereRaw("( User_Tree LIKE CONCAT($idparent,',',User_ID) OR User_Tree LIKE CONCAT('%,' , $idparent, ',' ,User_ID) )")->orderBy('User_IsRight')->GET();
        $child = array();
        if(count($build) > 0){
            for($i=0;$i<2;$i++){
                if(isset($build[$i])){
                    if($build[$i]->User_IsRight == 0){
                        
                        $child[] = array(
                            'id' => $build[$i]->User_ID,
                            'name' => $build[$i]->User_ID,
                            'title' => $build[$i]->User_Email,
                            'className' => 'node-tree '.strtoupper($build[$i]->User_Email),
                            'children' => $this->buildTree($build[$i]->User_ID, $build[$i]->User_ID, 0),
                        );
                        if(count($build) <2){
                            $child[] = array(
                                'id' => 'a'.(int)$build[$i]->User_ID.''.rand(1,99),
                                'name' => 'a'.(int)$build[$i]->User_ID.''.rand(1,99),
                                'title' => 'a'.(int)$build[$i]->User_ID.''.rand(1,99),
                                'className' => 'node-empty right'
                            );
                        }
                        
                    }
                    if($build[$i]->User_IsRight == 1){
                        if(count($build) <2){
                            $child[] = array(
                                'id' => 'a'.(int)$build[$i]->User_ID.''.rand(1,99),
                                'name' => 'a'.(int)$build[$i]->User_ID.''.rand(1,99),
                                'title' => 'a'.(int)$build[$i]->User_ID.''.rand(1,99),
                                'className' => 'node-empty left'
                            );
                        }
    
                        $child[] = array(
                            'id' => $build[$i]->User_ID,
                            'name' => $build[$i]->User_ID,
                            'title' => $build[$i]->User_Email,
                            'className' => 'node-tree '.strtoupper($build[$i]->User_Email),
                            'children' => $this->buildTree($build[$i]->User_ID, $build[$i]->User_ID),
                        );
                        
                        
    
                    }
                    
                }
                
    
            }
        }
        else{
            $child[] = array(
                'id' => 'a'.(int)$idRootTemp.''.rand(1,99),
                'name' => 'a'.(int)$idRootTemp.''.rand(1,99),
                'title' => 'a'.(int)$idRootTemp.''.rand(1,99),
                'className' => 'node-empty left'
            );
            $child[] = array(
                'id' => 'a'.(int)$idRootTemp.''.rand(1,99),
                'name' => 'a'.(int)$idRootTemp.''.rand(1,99),
                'title' => 'a'.(int)$idRootTemp.''.rand(1,99),
                'className' => 'node-empty right'
            );
        }
        return $child;
    }
    
    public function postMemberAdd(Request $request){
        
        $request->validate([
            'Email' => 'required|email|max:100|unique:users,User_Email',
            'parent' => 'required',
            'brother' => 'required',
            'node_side' => 'required',
            // 'Password' => 'required|max:40',
            // 'Re-Password' => 'required|same:Password'
        ]);
        if (!filter_var($request->Email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Email format is wrong!']);
		}
        include(app_path() . '/functions/xxtea.php');

        $userID_Parent = $request->parent;

        //Kiểm tra ID Parent đó có tồn tại không????
        $show_ID_Parent = User::where('User_ID', $userID_Parent)->value('User_ID');
        if(!$show_ID_Parent){
            return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => 'Please enter Parent!']);
        }
        //BiẾN tạm LƯU  ID Presenter 
        $userID_Presenter = $request->brother;
        
        if(!$userID_Presenter){
            //nếu cố tình sửa presenter

            return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => 'Please enter presenter!']);
            //IF Có nhập người chỉ định
            
        }
        //Add vào left or right do người chỉ định
        $check_location_branch = User::select('User_ID', 'User_Tree', 'User_IsRight')->whereRaw("(User_Tree LIKE CONCAT($userID_Presenter,',',User_ID) OR User_Tree LIKE CONCAT('%,' , $userID_Presenter, ',' ,User_ID))")->where('User_IsRight', $request->node_side)->first();
        if($check_location_branch){
            //nêu vị trí nhánh đso đã có người vào thì lỗi
            return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => 'This branch already has subscribers!']);
        }
        //Add branch

        if($request->node_side == 0){
            $user_side = 0;
        }
        if($request->node_side == 1){
            $user_side = 1;

        }
        //Tạo random ID user
        $user_id = $this->RandomIDUser();
        // get tree người chỉ định

        $user_Presenter_Tree = User::where('User_ID', $userID_Presenter)->value('User_Tree');


        //xử lý tree
        $user_tree = !$user_Presenter_Tree ? $userID_Presenter . "," . $user_id : $user_Presenter_Tree . ',' . $user_id;


        //Tạo token cho mail
        $token = Crypt::encryptString($request->Email.':'.time());
        //Xử lý
        $create_Password = rand(100000, 999999);
        
        //lấy sun tree parent
        $sunTree = (User::where('User_ID', $show_ID_Parent)->value('User_SunTree')).','.$user_id;


        $Register = [
            'User_ID' => $user_id,
            'User_Email' => $request->Email,
            'User_Parent' => $show_ID_Parent,
            'User_SunTree' => $sunTree,
            'User_IsRight' => $user_side,
            'User_Tree' => $user_tree,
            'User_EmailActive' => 0,
            // 'User_Password' => bcrypt($request->Password),
            'User_Password' => bcrypt($create_Password),
            'User_RegisteredDatetime' => date('Y-m-d H:i:s'),
            'User_Level' => 0,
            'User_Status' => 1,
            'User_Token' => $token,

        ];

        User::insert($Register);
        
        
        //dữ liệu gửi sang mailtemplate
        $data = array('password' => $create_Password,'User_ID' => $user_id, 'User_Email'=> $request->Email, 'token'=>$token);
        //Job
        // gửi mail thông báo
        sendMailActive($data, $request->Email);

        //return redirect()->back()->with(['flash_level'=>'success', 'flash_message'=>'Add Binary Member Success! Login with user name and password!']);
        return redirect()->back()->with(['flash_level'=>'success', 'flash_message'=>'Register Account Success, Please check your email to Activate Account!']);
    }

    public function getAjaxSaleUser(Request $req){
        
		$userID = $req->User_ID;
        $result = User::where('User_ID', $userID)->select('User_ID', 'User_Email', 'User_Tree')->firstorfail();
        
		$branch  = User::select('User_Email','User_ID', 'User_Tree', 'User_IsRight')->whereRaw("( User_Tree LIKE CONCAT($userID,',',User_ID) OR User_Tree LIKE CONCAT('%,' , $userID, ',' ,User_ID) )")->orderBy('User_IsRight')->GET();
        $branch_sales = [];
        $branch_sales['leftTrade'] = 0;
		$branch_sales['rightTrade'] = 0;
        $count_children['children_left'] = 0;
        $count_children['children_right'] = 0;
		if(count($branch) > 0){
            for($i=0;$i<2;$i++){
                if(isset($branch[$i])){
                    if($branch[$i]->User_IsRight == 0){
                        
//                         $total_sales_children = Investment::join('users', 'User_ID', 'investment_User')->where('User_Tree', 'LIKE', $branch[$i]->User_Tree.'%')->sum('investment_Amount');
							$total_sales_children = Money::join('users', 'User_ID', 'Money_User')->where('User_Tree', 'LIKE', $branch[$i]->User_Tree.'%')->where('Money_MoneyAction', 15)->where('Money_MoneyStatus', 1)->sum('Money_USDT');
                        $branch_sales['leftTrade'] = number_format($total_sales_children, 2);
                        $count_children['children_left'] = User::where('User_Tree', 'LIKE', $branch[$i]->User_Tree.'%')->count();

                    }
                    if($branch[$i]->User_IsRight == 1){
// 						$total_sales_children = Investment::join('users', 'User_ID', 'investment_User')->where('User_Tree', 'LIKE', $branch[$i]->User_Tree.'%')->sum('investment_Amount');
						$total_sales_children = Money::join('users', 'User_ID', 'Money_User')->where('User_Tree', 'LIKE', $branch[$i]->User_Tree.'%')->where('Money_MoneyAction', 15)->where('Money_MoneyStatus', 1)->sum('Money_USDT');
						$branch_sales['rightTrade'] = number_format($total_sales_children, 2);
                        $count_children['children_right'] = User::where('User_Tree', 'LIKE', $branch[$i]->User_Tree.'%')->count();
                    }
                    
                }
                
    
            }
        }
        

		if($result){
			return response()->json([
				'status' => 200,
				'infor' => $result,
                'sales' => $branch_sales,
                'count_children' => $count_children,
			], 200);
        }
    }



    public function getUsersTreeList($userID, &$usersTreeList, $level = 0)
    {
        ++$level;
        if ($level == 4){
            return 0;
        }
        $children = User::Where('User_Parent', $userID)
            ->select('User_ID as id', 'User_Parent as pid', 'User_Email as email')
            ->get();
        if ($children) {
            foreach ($children as $child) {
                $child->level = "F$level";
                $child->img = "system/images/user.png";
                array_push($usersTreeList, $child->toArray());
                $this->getUsersTreeList($child->id, $usersTreeList, $level );
            }
        }
    }

    public function getProfile()
    {
        $google2fa = app('pragmarx.google2fa');
        //kiểm tra member có secret chưa?
        $auth = GoogleAuth::where('google2fa_User',session('user')->User_ID)->first();

        $Enable = false;
        if($auth == null){
            $secret = $google2fa->generateSecretKey();
            Session::put('Auth', $secret);
        }else{
            $Enable = true;
            $secret = $auth->User_Auth;
        }
//        $google2fa->setAllowInsecureCallToGoogleApis(true);

        $inlineUrl = $google2fa->getQRCodeUrl(
            "Redbox",
            session('user')->User_Email,
            $secret
        );
        $kycProfile = Profile::where('Profile_User', session('user')->User_ID)->first();
        return view('System.User.Profile', compact('kycProfile', 'inlineUrl', 'secret', 'Enable'));
    }
    
    public function postProfile(Request $req){
        
        $google2fa = app('pragmarx.google2fa');
	    $this->validate($req, [
		    'address' => 'required',
		    'otp' => 'required'
	    ], [
		    
	    ]);
	    
	    $user = User::find(Session('user')->User_ID);
        $AuthUser = GoogleAuth::select('google2fa_Secret')->where('google2fa_User', $user->User_ID)->first();
        if(!$AuthUser){
		    return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'User Unable Authenticator']);
        }
        $valid = $google2fa->verifyKey($AuthUser->google2fa_Secret, $req->otp);
        if(!$valid){
            return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Wrong code']);
        }
	    $user->User_WalletAddress = $req->address;
	    $user->save();
		Session::put('user', $user);
        return redirect()->back()->with(['flash_level'=>'success', 'flash_message'=>'Change Infomation Success!']);
    }

    public function postAuth(Request $req){
        $this->validate($req, [
		    'verifyCode' => 'required',
	    ]);
        $user = User::find(Session('user')->User_ID);
        if($user->User_Auth == 1){
	        return redirect()->back();
        }
        $google2fa = app('pragmarx.google2fa');
        $AuthUser = GoogleAuth::select('google2fa_Secret')->where('google2fa_User', $user->User_ID)->first();
        $authCode = null;
        if(Session('Auth')){
            $authCode =  Session('Auth');
        }else{
            $authCode = $AuthUser->google2fa_Secret;
        }
        $valid = $google2fa->verifyKey($authCode, $req->verifyCode);

        if($valid){
            //kiểm tra member có secret chưa?
            $auth = GoogleAuth::where('google2fa_User',$user->User_ID)->first();

            if($auth){
                // xoá
                GoogleAuth::where('google2fa_User',$user->User_ID)->delete();
                return redirect()->back()->with(['flash_level'=>'success', 'flash_message'=>'Disable Authenticator']);
            }else{
                // Insert bảng google2fa
                $r = new GoogleAuth();
                $r->google2fa_User = $user->User_ID;
                $r->google2fa_Secret = Session('Auth');
                $r->save();
                return redirect()->back()->with(['flash_level'=>'success', 'flash_message'=>'Enable Authenticator']);
            }

        }else{
            return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Wrong code']);
        }
    }

    public function PostKYC(KYC $request)
    {

        $user = session('user');
        $checkExist = Profile::where('Profile_User', $user->User_ID)->whereIn('Profile_Status', [0,1] )->first();
        if ($checkExist) {
            return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => "Profile early validate!"]);

        }
        $passportID = $request->passport;
        //get file extension
        $passportImageExtension = $request->file('passport_image')->getClientOriginalExtension();
        $passportImageSelfieExtension = $request->file('passport_image_selfie')->getClientOriginalExtension();
        //set folder and file name
        $randomNumber = uniqid();
        $passportImageStore = "users/".$user->User_ID."/profile/passport_image_".$user->User_ID."_".$randomNumber.".".$passportImageExtension;
        $passportImageSelfieStore = "users/".$user->User_ID."/profile/passport_image_selfie_".$user->User_ID."_".$randomNumber.".".$passportImageSelfieExtension;
        //send to Image server
        $passportImageStatus =Storage::disk('ftp')->put($passportImageStore, fopen($request->file('passport_image'), 'r+'));
        $passportImageSelfieStatus =Storage::disk('ftp')->put($passportImageSelfieStore, fopen($request->file('passport_image_selfie'), 'r+'));

        if ($passportImageStatus and $passportImageSelfieStatus) {
            $insertProfileData = [
                'Profile_User' => $user->User_ID,
                'Profile_Passport_ID' => $passportID,
                'Profile_Passport_Image' => $passportImageStore,
                'Profile_Passport_Image_Selfie' => $passportImageSelfieStore,
                'Profile_Time' => date('Y-m-d H:i:s')
            ];
            $inserStatus = Profile::create($insertProfileData);
            if ($inserStatus) {
                return redirect()->back()->with(['flash_level' => 'success', 'flash_message' => "Update proflie Noted"]);
            }
            return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => "Please contact admin!"]);

        }

        return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => "Update profile error"]);

    }

    public function changeUserSideActivce(Request $req){
		$user = User::find(Session('user')->User_ID);
		$side_active = $req->side_active;
		if($user->User_Side_Active == $side_active){
			return '';
        }
        
		$user->User_Side_Active = $side_active;
		$user->save();

		return response()->json(['status'=>'success', 'message'=>'Change Node Success!']);
    }
    public function RandomIDUser(){
	    
	    $id = rand(100000, 999999);
        $user = User::where('User_ID',$id)->first();
        if(!$user){
            return $id;
        }else{
            return $this->RandomIDUser();
        }
    }

}
