<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use View;
use Response;
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
    public function InputForm(Request $request, $id)
    {
     $response = array();
     $response['code'] = 400;
     if (!$this->secure($id, true)) return Response::json($response);
     $data = $request->all();
     $messages = [
        'snack' => 'required',
        'makan' => 'required',
        'nama_rapat' => 'required',
        'tgl_rapat' => 'required',
    ];
    $validator = Validator::make($data, $messages);

    if ($validator->fails()) {
        $response['code'] = 400;
        $response['message'] = implode(' ', $validator->errors()->all());
    }else{
        $snack = $data['snack'] * 19800; 
        $makan = $data['makan'] * 51700;
        $total = array_sum(array($snack,$makan)); 
        if ($saldo < $total) {
            $response['code'] = 400;
            $response['message'] = 'Pagu Tidak Mencukupi';
        }else{
          $pengajuan = Pengajuan::find($id);
          $pengajuan->snack = $data['snack'];
          $pengajuan->makan = $data['makan'];
          $pengajuan->nama_rapat = $data['nama_rapat'];
          $pengajuan->tanggal_rapat = $data['tgl_rapat'];
          if ($data['status']=='booking') {
              $pengajuan->status = 'booking';
          }else{
              $pengajuan->status = 'pending';
          }
          $pengajuan->total = $total;
          if($pengajuan->save()){
            $response['code'] = 200;
            $response['message'] = 'Data sudah di simpan';
        }else{
            $response['code'] = 400;
            $response['message'] = 'Data error silakan hubungi tim terkait';
        }  
    }

}
}
}