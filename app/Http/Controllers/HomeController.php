<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
class HomeController extends Controller
{
	public function getIndex(){
		
		$setting = DB::table('setting_ito')->where('setting_ito_DateOpen', '<=', date('Y-m-d H:i:s'))->where('setting_ito_DateClose', '>=', date('Y-m-d H:i:s'))->where('setting_ito_Status', 0)->orderByDesc('setting_ito_DateOpen')->first();
		if(!$setting){
			$setting = DB::table('setting_ito')->where('setting_ito_DateOpen', '>=', date('Y-m-d H:i:s'))->orderBy('setting_ito_DateOpen')->first();
		}
		$setting = null;
		
		
        $noti_image = DB::table('NotificationImage')->where('Status', 0)->where('Location_Login', 1)->get(); 
		return view('PageITO', compact('setting', 'noti_image'));
	}
	
}