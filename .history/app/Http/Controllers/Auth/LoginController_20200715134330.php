<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Login;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\GoogleAuth;

class LoginController extends Controller
{
    public function getLogin(Request $req){
/*
        if(!count($req->all())){
            return redirect()->route('getIndex');    
        }
*/      
        $noti_image = DB::table('NotificationImage')->where('Status', 0)->where('Location_System', 1)->get(); 
        return view('Auth.Login', compact('noti_image'));
    }

    public function postLogin(Login $request)
    {
// 	    return redirect()->route('getLogin')->with(['flash_level'=>'error', 'flash_message'=>'The server is under maintenance, please visit again few hours later!']);
        $loginUser = User::where('User_Email', $request->email)->first();
        if($loginUser->User_EmailActive != 1){
            return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => 'Please check your email and active this account!']);
        }
        if($loginUser->User_Block == 1){
            return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => 'Your account is locked!']);
        }
        if (!Hash::check($request->password, $loginUser->User_Password)) {
            return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => 'Password incorrect']);
        }
        $auth = GoogleAuth::where('google2fa_User',$loginUser->User_ID)->first();
        if($auth){
            Session::put('auth',$auth);
            $otp = true;
            return redirect()->back()->with(['otp'=>$otp]);
        }
        $loginUser->User_LastedLogin = date('Y-m-d H:i:s');
        $loginUser->save();
        Session::put('user', $loginUser);
        return redirect()->route('system.dashboard')->with(['flash_level' => 'success', 'flash_message' => 'Login successfully']);

    }

    public function getLogout(){
        Session::forget('user');
        $userTemp = session('userTemp');
        if ($userTemp) {
            Session::put('user', session('user', $userTemp));
            Session::forget('userTemp   ');
            return redirect()->route('system.dashboard')->with(['flash_level' => 'success', 'flash_message' => 'Login successfully']);
        }
        return redirect()->route('system.dashboard')->with(['flash_level' => 'success', 'flash_message' => 'Logout successfully']);
    }

    public function postLoginCheckOTP(Request $req){
        $auth = Session('auth');
        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($auth->google2fa_Secret, $req->otp);
        if($valid){
            $user = User::find($auth->google2fa_User);

	        $user->User_LastedLogin = date('Y-m-d H:i:s');
	        $user->save();
            Session::put('user', $user);

            return 1;
        }
        return 0;
    }
}
