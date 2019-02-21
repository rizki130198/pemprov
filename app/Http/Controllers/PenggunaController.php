<?php

namespace App\Http\Controllers;

use App\Library\IPAPI;
use App\Library\sHelper;
use App\Models\User;
use App\Models\UserDirectMessage;
use DB;
use View;
use Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenggunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $response = array();
        $response['code'] = 200;

        $user = Auth::user();

        $user_list = [];

        $message_list = DB::select( DB::raw("select * from (select * from `user_direct_messages` where `receiver_user_id` = '".$user->id."' and `receiver_delete` = '0'  and `seen` = '0' order by `id` desc limit 200000) as group_table group by sender_user_id order by id desc") );

        $data = DB::table('events')->where('akhir','>', date('Y-m-d H:i:s'))->orderby('id_events','DESC')->get();

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

        $wall = [
            'new_post_group_id' => 0
        ];
        return view('pengguna.pengguna', compact('user','data','user_list'));
    }
}