<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Storage;
use Image;

use App\Model\Money;
use App\Model\User;
use App\Model\Investment;
use App\Model\Ticket;
use App\Model\TicketSubject;
use Illuminate\Support\Facades\Crypt;
use Sop\CryptoTypes\Asymmetric\EC\ECPublicKey;
use Sop\CryptoTypes\Asymmetric\EC\ECPrivateKey;
use Sop\CryptoEncoding\PEM;
use kornrunner\Keccak;
use hash;
use DB;
use App\Jobs\SendMail;
class NotificationImageController extends Controller{
	
	public function getNotificationImage(){
		$notiImage = DB::table('NotificationImage')->orderBy('id','desc')->get();
		return view('System.Admin.NotificationImage', compact('notiImage'));
	}	
	public function postImage(Request $req){
		$this->validate($req, 
            [
            	'notiImage' => 'required|image|mimes:jpeg,jpg,png|max:6144',
            ]
        );
        //$notiImage = DB::table('NotificationImage');
		//$noti_Status = $request->notiStatus;
        //get file extension
        //$noti_Image = $request->file('notiImage')->getClientOriginalExtension();
        //set folder and file name
        //$randomNumber = uniqid();
        $locationLogin = $req->checkLanding;
        $locationSystem = $req->checkSystem;
        $locationExchange = $req->checkExchange;
        if($locationLogin != 1 and $locationSystem != 1 and $locationExchange != 1){
	        return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => "Please selected loaction"]);
        }
        $notiImageExtension = $req->file('notiImage')->getClientOriginalExtension();
        
		$randomNumber = uniqid();
        $notiImageStore = "file/notification/noti_image_".$randomNumber.".".$notiImageExtension;
        $notiImageStatus = Storage::disk('public')->put($notiImageStore, fopen($req->file('notiImage'), 'r+'));
        
        if ($notiImageStatus) {
            $insertNotiData = [
                'Url' => $notiImageStore,
                'Location_Login' => $locationLogin,
                'Location_System' => $locationSystem,
                'Location_Exchange' => $locationExchange
            ];
            $inserStatus = DB::table('NotificationImage')->updateOrInsert($insertNotiData);
            if ($inserStatus) {
                return redirect()->back()->with(['flash_level' => 'success', 'flash_message' => "Update profile Noted"]);
            }
            return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => "Please contact dev"]);

        }
        return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => "Please contact dev!"]);

	}
	
	public function getHideNoti(Request $req, $id){
		$noti_image = DB::table('NotificationImage');
        $check_noti_image = DB::table('NotificationImage')->where('ID', $id)->first();
		if($check_noti_image->Status == 0){
			$updateNoti_image = DB::table('NotificationImage')->where('ID', $id)->update([
				'Status'=> 1
			]);
			return redirect()->back()->with(['flash_level' => 'success', 'flash_message' => 'Turn off notification Success!']);
		}else{
			
			$updateNoti_image = DB::table('NotificationImage')->where('ID', $id)->update([
				'Status'=> 0
			]);
			return redirect()->back()->with(['flash_level' => 'success', 'flash_message' => 'Hanging notification Success!']);
		}
       
	}
	public function getDeleteNoti(Request $req, $id){
		$noti_image = DB::table('NotificationImage');
        $check_noti_image = DB::table('NotificationImage')->where('ID', $id)->first();
		if($check_noti_image){
			$updateDeleNoti_image = DB::table('NotificationImage')->where('ID', $id)->delete();			
			return redirect()->back()->with(['flash_level' => 'success', 'flash_message' => 'Delete notification Success!']);
		}
		return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => 'Delete notification Error!']);
       
	}
}
