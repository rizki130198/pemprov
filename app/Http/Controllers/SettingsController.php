<?php
namespace App\Http\Controllers;

use Auth;
use Hash;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\EventComment;
use App\Models\Gruppost;
use App\Models\Post;
use App\Models\GrupImage;
use App\Models\GrupLike;
use App\Models\UserDirectMessage;
use Session;

class SettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){
        $response = array();
        $response['code'] = 200;

        if (Session::has('user')){
            $user = Session::get('user');
        }else{
            $user = Auth::user();
        }
        $user_list = [];

        $message_list = DB::select( DB::raw("select * from (select * from `user_direct_messages` where `receiver_user_id` = '".$user->id."' and `receiver_delete` = '0'  and `seen` = '0' order by `id` desc limit 200000) as group_table group by sender_user_id order by id desc") );

        $new_list = [];
        foreach(array_reverse($message_list) as $list){
            $msg = new UserDirectMessage();
            $msg->dataImport($list);
            $new_list[] = $msg;
        }

        foreach (array_reverse($new_list) as $message){
            $user_list[$message->sender_user_id] = [
                'new' => ($message->seen == 0)?true:false,
                'message' => $message,
                'user' => $message->sender
            ];
        }

        return view('settings', compact('user','user_list'));
    }

    public function update(Request $request){


        $additional_msg = false;
        if ($request->input("type") == "password") {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required|passcheck',
                'password' => 'required|min:6|confirmed'
            ]);


            if ($validator->fails()) {
                $save = false;
            } else {
                Auth::user()->password = \Hash::make($request->input("password"));
                $save = Auth::user()->save();
            }
        }elseif ($request->input("type") == "username"){
            $validator = Validator::make($request->all(), [
                'username' => 'required|max:191|unique:users,username,' . Auth::user()->id
            ]);

            $user = [
                'username' => $request->input("username"),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email
            ];

            if ($validator->fails()) {
                $save = false;
            }else {
                Auth::user()->username = $user['username'];
                if (Auth::user()->validateUsername()) {
                    $save = Auth::user()->save();
                }else{
                    $save = false;
                    $additional_msg = "Username can't contain special character and space";
                }
            }
        }else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:191',
                'email' => 'required|email|max:191|unique:users,email,' . Auth::user()->id
            ]);

            $user = [
                'name' => $request->input("name"),
                'email' => $request->input("email"),
                'private' => $request->input("private"),
            ];

            if ($validator->fails()) {
                $save = false;
            }else {
                Auth::user()->name = $user['name'];
                Auth::user()->email = $user['email'];
                Auth::user()->private = $user['private'];
                $save = Auth::user()->save();
            }
        }
        if ($save){
            $request->session()->flash('alert-success', 'Your settings have been successfully updated!');
        }else{
            $request->session()->flash('alert-danger', ($additional_msg)?$additional_msg:'There was a problem saving your settings!');
        }

        if ($request->input("type") == "password") {
            if ($save){
                return redirect('settings');
            }else{
                return redirect('settings')
                    ->withErrors($validator);
            }
        }else{
            if ($save){
                return redirect('settings');
            }else{
                return redirect('settings')
                    ->withErrors($validator)
                    ->with('user', $user);
            }
        }

    }
    public function delete($id)
    {
        if ($id == Auth::user()->id) {
            $delete_event = EventComment::where('id_users',$id)->delete();
            $delete_post = Post::where('user_id',$id)->delete();
            $delete_gruppost = Gruppost::where('user_id',$id)->delete();
            $delete_grupimage = GrupImage::where('id_user',$id)->delete();
            $delete_grupimage = UserDirectMessage::where('sender_user_id',$id)->where('receiver_user_id',$id)->delete();
            $delete_grupimage = GrupLike::where('like_user',$id)->delete();
            $delete = User::where('id',$id)->delete();
            return redirect(route('logout'));
        }else{
            return redirect('settings')
                    ->withErrors('Anda Bukan Siapa-siapa');
        }
    }
}