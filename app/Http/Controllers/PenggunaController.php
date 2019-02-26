<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use View;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

        $data = User::all();
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
        return view('pengguna.pengguna', compact('user','data','user_list'));

    }
    public function Ubahjabatan(Request $request)
    {
        $response = [];
        $user = User::find($request->input('id'));
        $user->role = $request->input('role');
        if($user->save()){
            $response['code'] = 200;
            $response['message'] = 'Jabatan Sudah di ganti';
        }else{
            $response['code'] = 400;
            $response['message'] = 'Data error silakan hubungi tim terkait';
        } 
        return Response::json($response);
    }
    public function Deleteaccount(Request $request)
    {
        $response = [];
        $user = User::find($request->input('id_usernya'));
        if($user->delete()){
            $response['code'] = 200;
            $response['message'] = 'Jabatan Sudah di ganti';
        }else{
            $response['code'] = 400;
            $response['message'] = 'Data error silakan hubungi tim terkait';
        } 
        return Response::json($response);
    }
}