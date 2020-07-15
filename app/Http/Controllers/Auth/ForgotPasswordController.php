<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPassword;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
class ForgotPasswordController extends Controller
{
    public function getForgotPassword()
    {
        return view('Auth.Forgot-Password');
    }

    public function postForgotPassword(ForgotPassword $request)
    {
        $password = $this->generateRandomString(10);
        $userEmail = $request->email;
        User::where('User_Email', $userEmail)->update(['User_Password'=>bcrypt($password)]);
        $data = array('password' => $password);
        sendForgotPassword($data, $userEmail);
        return redirect()->route('getLogin')->with(["flash_level" => 'success', 'flash_message' => 'Please check mail to get new password!']);
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
