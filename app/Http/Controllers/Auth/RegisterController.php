<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Register;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

class RegisterController extends Controller
{
    public $secretKey = 'KEEHXR8VE0N63aX9LQaYP2RMQM4A5W4I4a4G6gaNX1KC9MV42FWBPP9FYCAABSNP7FO5M5QEURK8AU1T9IRJhN3vK8UTR2VBR4MN';
    public $keyHash = 'Redbox';
    public function getRegister(){
        return view('Auth.Register');
    }
    public function postRegister(Request $request)
    {
        $request->validate([

            // 'UserName' => 'max:15|unique:users,User_Name|regex:/^[A-Za-z][A-Za-z0-9]*$/',
            'Email' => 'required|email|max:100|unique:users,User_Email',
            'Password' => 'required|max:40',
            'Re-Password' => 'required|same:Password'
        ]);
        if (!filter_var($request->Email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with(['flash_level'=>'error', 'flash_message'=>'Email format is wrong!']);
		}
        include(app_path() . '/functions/xxtea.php');
        
        $userID_Parent = '473438';
        if($request->parent){
		    $userID_Parent = $request->parent;
        }
        //Kiểm tra ID Parent đó có tồn tại không????
        $check_parent_ex = User::findorfail($userID_Parent);
        $show_ID_Parent = User::where('User_ID', $userID_Parent)->value('User_ID');
        $get_Side_Active = User::where('User_ID', $userID_Parent)->value('User_Side_Active');
        //BiẾN tạm LƯU  ID Presenter 
        $userID_Presenter = $request->presenter;
        if($userID_Presenter){
            //IF Có nhập người chỉ định
            // $node = User::where('User_ID', $userID_Presenter)->value('user_Node_Active');
            // $user_ID_Presenter = $userID_Presenter;
            // $user_Presenter_Tree = User::where('User_ID', $userID_Presenter)->value('User_Tree');

            $info_Presenter = User::findorfail($userID_Presenter);

            $node = $info_Presenter->User_Side_Active;

            $prevNodeID = $this->leftNode($info_Presenter->User_ID, $info_Presenter->User_Side_Active);

            $user_ID_Presenter = $prevNodeID;
            $user_Presenter_Tree = User::where('User_ID', $prevNodeID)->value('User_Tree');
        }
        else{
            //Còn ko nhập thì lấy Paren mặc định và thêm vào vị trí trái bên cùng
            // $node = User::where('User_ID', $userID_Parent)->value('user_Node_Active');
            
            $node = $get_Side_Active;

            $prevNodeID = $this->leftNode($show_ID_Parent, $get_Side_Active);
            $user_ID_Presenter = $prevNodeID;
            $user_Presenter_Tree = User::where('User_ID', $prevNodeID)->value('User_Tree');
        }

        $childrenNode = User::select('User_ID', 'User_Tree', 'User_IsRight')->whereRaw("( User_Tree LIKE CONCAT($user_ID_Presenter,',',User_ID) OR User_Tree LIKE CONCAT('%,' , $user_ID_Presenter, ',' ,User_ID) )")->get();
        // dd($user_ID_Presenter,$childrenNode);

        if(count($childrenNode) > 2){
            //Nhánh đã đủ 2 chân rồi
            return redirect()->route('getRegister')->with(['flash_level' => 'error', 'flash_message' => 'This person has enough 2 children, please choose other one!']);
        }else{
            if(count($childrenNode) == 0){
                //tức không nhập người chỉ địh hoặc có nhập mà người chỉ định chưa có chân nào,
                //cho nên sẽ vào nhánh trái và cuối cùng
                $user_side = $node;
            }
            else{
                //khi nào đucợ chạy vào đây
                // dk khi có nhập người chỉ định
                if($childrenNode[0]->User_IsRight == 1){
                    $user_side = 0;
                }
                else{
                    $user_side = 1;
                }
            }

        }
        

        $user_id = $this->RandomIDUser();
        $user_tree = !$user_Presenter_Tree ? $userID_Presenter . "," . $user_id : $user_Presenter_Tree . ',' . $user_id;

        //lấy sun tree parent
        $sunTree = (User::where('User_ID', $show_ID_Parent)->value('User_SunTree')).','.$user_id;

        //Tạo token cho mail
        $token = Crypt::encryptString($request->Email.':'.time());
        //Xử lý
        $Register = [
            'User_ID' => $user_id,
            // 'User_Name' => $request->UserName,
            'User_Email' => $request->Email,
            'User_Parent' => $show_ID_Parent,
            'User_IsRight' => $user_side,
            'User_Tree' => $user_tree,
            'User_SunTree' => $sunTree,
            'User_EmailActive' => 0,
            'User_Password' => bcrypt($request->Password),
            'User_RegisteredDatetime' => date('Y-m-d H:i:s'),
            'User_Level' => 0,
            'User_Status' => 1,
            'User_Token' => $token,

        ];

        User::insert($Register);
        
        //dữ liệu gửi sang mailtemplate
        $data = array('User_ID' => $user_id, 'User_Name' => $request->Email,'User_Email'=> $request->Email, 'password' => $request->Password, 'token'=>$token);
        //Job
        // dispatch(new SendMailJobs('Active', $data, 'Active Account!', $user_id));
        // gửi mail thông báo
        sendMailActive($data, $request->Email);

        return redirect()->route('getLogin')->with(['flash_level'=>'success', 'flash_message'=>'Register Account Success, Please check your email to Activate Account!']);

    }
    public function leftNode($id, $node = 0)
    {
        $childnode = User::whereRaw("User_IsRight = $node AND ( User_Tree LIKE CONCAT($id,',',User_ID) OR User_Tree LIKE CONCAT('%,',$id,',',User_ID) ) ")->first();
        
        if (!$childnode) {
	        
            return $id;
        } else {
            return $this->leftNode($childnode->User_ID, $node);
        }
    }
    // public function postRegister(Register $request) {
    //     $sponsor = 666666;
    //     if($request->sponser){
    //         $sponsor = $request->sponser;
    //     }
    //     $sponserInfo = User::where('User_ID', $sponsor)->first();

    //     $userID = $this->RandomIDUser();

    //     $userTree = $sponserInfo->User_Tree . "," . $userID;

    //     $userData = [
    //         'User_ID' => $userID,
    //         'User_Email' => $request->email,
    //         'User_Parent' => $request->sponser,
    //         'User_Tree' => $userTree,
    //         'User_Password' => Hash::make($request->password),
    //         'User_RegisteredDatetime' => date('Y-m-d H:i:s'),
    //         'User_EmailActive' => 0,
    //         'User_Agency_Level' => 0,
    //         'User_Level' => 0,
    //         'User_Status' => 1,
    //     ];
    //     $insertUser = User::create($userData);

    //     if (!$insertUser) {
    //         return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => 'There is an error, please contact admin']);
    //     }
    //     //Tạo token cho mail
    //     $dataToken = array('user_id' => $insertUser->User_ID, 'time' => time());
    //     //$token = base64_encode(xxtea_encrypt(json_encode($dataToken),$keyHash));
    //     $token = encrypt(json_encode($dataToken));
    //     //dữ liệu gửi sang mailtemplate
    //     $data = array('User_Email' => $request->email, 'token' => urlencode($token), 'password' =>$request->password);
    //     // gửi mail thông báo
    //     sendMailActive($data, $request->email);
    //     return redirect()->back()->with(['flash_level' => 'success', 'flash_message' => 'Registration successful, please check your email to confirm!']);
    // }

    public function RandomIDUser()
    {
        $id = rand(100000, 999999);
        //TẠO RA ID RANĐOM
        $user = User::where('User_ID', $id)->first();
        //KIỂM TRA ID RANDOM ĐÃ CÓ TRONG USER CHƯA
        if (!$user) {
            return $id;
        }
        else {
            return $this->RandonIDUser();
        }
    }

    public function getActive(Request $request)
    {

        $user = User::where('User_Token', $request->token)->first();
        if($user){
            if($user->User_EmailActive == 1){
                return redirect()->route('getLogin');
            }else {
                $user->User_EmailActive = 1;
                $user->save();
                return redirect()->route('getLogin')->with(['flash_level'=>'success', 'flash_message'=>'Activate Account Success!']);
            }

        }
        return redirect()->route('getLogin')->with(['flash_level'=>'error', 'flash_message'=>'Error!']);



        // // cập nhật lại mail đã active
        // include(app_path() . '/functions/xxtea.php');

        // if ($request->token) {

        //     $token = ($request->token);
        //     $data = json_decode(decrypt(urldecode($token)));
            
        //     if (strtotime('+30 minutes', $data->time) < time()) {
        //         return redirect()->route('getLoginRegister')->with(['flash_level' => 'error', 'flash_message' => 'This mail expired! Please Login again']);
        //     }
        //     $user = User::where('User_ID', $data->user_id)->where('User_Status', 1)->first();

        //     if ($user) {
        //         if ($user->User_EmailActive == 0) {
        //             $user->User_EmailActive = 1;
        //             $user->save();
        //         }
        //         Session::put('user', $user);
        //         if ($request->redirect) {
        //             return redirect()->to($request->redirect);
        //         }
        //         return redirect()->route('system.dashboard')->with(['flash_level' => 'success', 'flash_message' => 'Login Success!']);
        //     }
        // }

        // return redirect()->route('getLoginRegister')->with(['flash_level' => 'error', 'flash_message' => 'Please Login Again!']);
    }

    // public function PostMemberAdd(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|unique:users,User_Email|max:255'
    //     ]);
    //     $sponsor = session('user')->User_ID;
    //     $sponserInfo = User::where('User_ID', $sponsor)->first();
    //     $userID = $this->RandomIDUser();
    //     $userTree = $sponserInfo->User_Tree . "," . $userID;
    //     $password = $this->generateRandomString(10);
    //     $userData = [
    //         'User_ID' => $userID,
    //         'User_Email' => $request->email,
    //         'User_Parent' => $sponsor,
    //         'User_Tree' => $userTree,
    //         'User_Password' => Hash::make($password),
    //         'User_RegisteredDatetime' => date('Y-m-d H:i:s'),
    //         'User_EmailActive' => 0,
    //         'User_Agency_Level' => 0,
    //         'User_Level' => 0,
    //         'User_Status' => 1,
    //     ];
    //     $insertUser = User::create($userData);

    //     if (!$insertUser) {
    //         return redirect()->back()->with(['flash_level' => 'error', 'flash_message' => 'There is an error, please contact admin']);
    //     }
    //     //Tạo token cho mail
    //     $dataToken = array('user_id' => $insertUser->User_ID, 'time' => time());
    //     //$token = base64_encode(xxtea_encrypt(json_encode($dataToken),$keyHash));
    //     $token = encrypt(json_encode($dataToken));
    //     //dữ liệu gửi sang mailtemplate
    //     $data = array('User_Email' => $request->email, 'password' => $password,'token' => urlencode($token));
    //     // gửi mail thông báo
    //     sendMailActive($data, $request->email);
    //     return redirect()->back()->with(['flash_level' => 'success', 'flash_message' => 'Registration successful, please check your email to active user!']);
    // }
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
