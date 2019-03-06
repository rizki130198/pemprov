<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDirectMessage;
use App\Models\FormPengajuan;
use App\Models\Saldo;
use DB;
use View;
use Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SpjController extends Controller
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
        $saldo = Saldo::all();
        if (Auth::user()->role == 'pptk') {
            $riwayat = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','!=','Terima')->get();
        }else if (Auth::user()->role == 'subbag') {
            $riwayat = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','!=','Pending')->where('status','!=','Verifikasi')->get();
        }else{
            $riwayat = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('id_user','=',Auth::user()->id)->get();
        }
        return view('spj.spj', compact('user','data','user_list','riwayat','saldo'));
    }
    public function formSpj(Request $request)
    {
        $response = array();
        $response['code'] = 200;

        $user = Auth::user();

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

        $wall = [
            'new_post_group_id' => 0
        ];
        if ($user->role == 'member') {
            return view('spj.formSpj', compact('user','data','user_list'));
        }else{
            return redirect('/spj');
        }
    }
    public function formVerifikasi(Request $request,$id)
    {
        $response = array();
        $response['code'] = 200;

        $user = Auth::user();

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

        $wall = [
            'new_post_group_id' => 0
        ];
        $verif = Formpengajuan::find($id);
        return view('spj.formVerifikasi', compact('user','data','user_list','verif'));
    }
    public function InputForm(Request $request)
    {
        $response = array();
        $response['code'] = 400;
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
            $saldo = Saldo::all();
            if ($data['snack'] == NULL) {
                if ($saldo[1]->saldo < $snack) {
                    $response['code'] = 400;
                    $response['message'] = 'Pagu Tidak Mencukupi';
                }else{
                    $pengajuan = new FormPengajuan();
                    $pengajuan->id_user = Auth::user()->id;
                    $pengajuan->makan = $data['makan'];
                    $pengajuan->nama_rapat = $data['nama_rapat'];
                    $pengajuan->tanggal_rapat = $data['tgl_rapat'];
                    if ($data['status']=='Booking') {
                        $pengajuan->status = 'Booking';
                    }else{
                        $pengajuan->status = 'Pending';
                    }
                    $pengajuan->total = $total;
                }
            }elseif($data['makan'] == NULL){
                if ($saldo[0]->saldo < $makan) {
                    $response['code'] = 400;
                    $response['message'] = 'Pagu Tidak Mencukupi';
                }else{
                    $pengajuan = new FormPengajuan();
                    $pengajuan->id_user = Auth::user()->id;
                    $pengajuan->snack = $data['snack'];
                    $pengajuan->nama_rapat = $data['nama_rapat'];
                    $pengajuan->tanggal_rapat = $data['tgl_rapat'];
                    if ($data['status']=='Booking') {
                        $pengajuan->status = 'Booking';
                    }else{
                        $pengajuan->status = 'Pending';
                    }
                    $pengajuan->total = $total;
                }
            }else{
                //$pengajuan = Pengajuan::find($id);
                $pengajuan = new FormPengajuan();
                $pengajuan->id_user = Auth::user()->id;
                $pengajuan->snack = $data['snack'];
                $pengajuan->makan = $data['makan'];
                $pengajuan->nama_rapat = $data['nama_rapat'];
                $pengajuan->tanggal_rapat = $data['tgl_rapat'];
                $pengajuan->baca_pptk = '1';
                if ($data['status']==NULL) {
                    $pengajuan->status = 'Pending';
                }else{
                    $pengajuan->status = 'Booking';
                }
                $pengajuan->total = $total;
            }
            if($pengajuan->save()){
                $response['code'] = 200;
                $response['message'] = 'Data sudah di simpan';
            }else{
                $response['code'] = 400;
                $response['message'] = 'Data error silakan hubungi tim terkait';
            }  
            return Response::json($response);
        }
    }
    public function UbahFormPengajuan(Request $request)
    {
        $response = array();
        $response['code'] = 400;
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
            $saldo = Saldo::all();
            $pengajuan = FormPengajuan::find($data['id_form']);
            if ($data['snack'] == NULL) {
                if ($saldo[1]->saldo < $snack) {
                    $response['code'] = 400;
                    $response['message'] = 'Pagu Tidak Mencukupi';
                }else if($pengajuan->status == 'Verifikasi'){
                    $response['code'] = 400;
                    $response['message'] = 'Sedang di verifikasi';
                }else{
                    $pengajuan->makan = $data['makan'];
                    $pengajuan->nama_rapat = $data['nama_rapat'];
                    $pengajuan->tanggal_rapat = date('Y-m-d',strtotime($data['tgl_rapat']));
                    $pengajuan->status = $data['status'];
                    $pengajuan->total = $total;
                }
            }elseif($data['makan'] == NULL){
                if ($saldo[0]->saldo < $makan) {
                    $response['code'] = 400;
                    $response['message'] = 'Pagu Tidak Mencukupi';
                }else if($pengajuan->status == 'verifikasi'){
                    $response['code'] = 400;
                    $response['message'] = 'Sedang di verifikasi';
                }else{
                    $pengajuan->snack = $data['snack'];
                    $pengajuan->nama_rapat = $data['nama_rapat'];
                    $pengajuan->tanggal_rapat = date('Y-m-d',strtotime($data['tgl_rapat']));
                    $pengajuan->status = $data['status'];
                    $pengajuan->total = $total;
                }
            }else{
                if($pengajuan->status == 'Verifikasi'){
                    $response['code'] = 400;
                    $response['message'] = 'Sedang di Verifikasi';
                }else{
                    $pengajuan->snack = $data['snack'];
                    $pengajuan->makan = $data['makan'];
                    $pengajuan->nama_rapat = $data['nama_rapat'];
                    $pengajuan->tanggal_rapat = date('Y-m-d',strtotime($data['tgl_rapat']));
                    $pengajuan->status = $data['status'];
                    $pengajuan->total = $total;
                }
            }
            if($pengajuan->save()){
                $response['code'] = 200;
                $response['message'] = 'Data sudah di simpan';
            }else{
                $response['code'] = 400;
                $response['message'] = 'Data error silakan hubungi tim terkait';
            }  
            return Response::json($response);
        }
    }
    public function AccData(Request $request)
    {
        $pengajuan = FormPengajuan::find($request->input('idpengajuan'));
        $pengajuan->status = 'Verifikasi';
        $pengajuan->baca_pptk = '0';
        if($pengajuan->save()){
            $response['code'] = 200;
            $response['message'] = 'Data Sedang di Verifikasi';
        }else{
            $response['code'] = 400;
            $response['message'] = 'Data error silakan hubungi tim terkait';
        } 
        return Response::json($response);
    }
    public function TolakData(Request $request)
    {
        $pengajuan = FormPengajuan::find($request->input('idpengajuan'));
        $pengajuan->status = 'Tolak';
        if($pengajuan->save()){
            $response['code'] = 200;
            $response['message'] = 'Data Sedang di Verifikasi';
        }else{
            $response['code'] = 400;
            $response['message'] = 'Data error silakan hubungi tim terkait';
        } 
        return Response::json($response);
    }
    public function UbahSaldo(Request $request)
    {
        $cek = Saldo::find($request->input('id_saldo'));
        if ($cek->saldo == $request->input('value')) {

            // Mau di isi apa ? 
        }else{
            $pengajuan = Saldo::find($request->input('id_saldo'));
            $pengajuan->saldo = $request->input('value');
            if($pengajuan->save()){
                $response['code'] = 200;
                $response['message'] = 'Saldo Sudah Di ubah';
            }else{
                $response['code'] = 400;
                $response['message'] = 'Data error silakan hubungi tim terkait';
            } 
            return Response::json($response);
        }

    }
    public function ActionVerif(Request $request)
    {
        $response = array();
        $response['code'] = 400;
        $data = $request->all();
        $messages = [
            'snack' => 'required',
            'makan' => 'required',
            'penyedia_snack' => 'required',
            'penyedia_makan' => 'required',
            'penyedia_makan' => 'required',
            'tgl_kw_snack' => 'required',
            'tgl_kw_makan' => 'required',
        ];
        $validator = Validator::make($data, $messages);

        if ($validator->fails()) {
            $response['code'] = 400;
            $response['message'] = implode(' ', $validator->errors()->all());
        }else{
            $saldo = Saldo::all();
            $jumsaldo = array_sum(array($saldo[0]->saldo,$saldo[1]->saldo));
            if ($jumsaldo < $data['total']) {
                $response['code'] = 400;
                $response['message'] = 'Saldo Pagu Tidak Mencukupi';
            }else{
              $pengajuan = FormPengajuan::find($data['id_form']);
              $pengajuan->harga_snack = $data['snack'];
              $pengajuan->harga_makan = $data['makan'];
              $pengajuan->penyedia_snack = $data['penyedia_snack'];
              $pengajuan->penyedia_makan = $data['penyedia_makan'];
              $pengajuan->tgl_snack = date('Y-m-d',strtotime($data['tgl_kw_snack']));
              $pengajuan->tgl_makan = date('Y-m-d',strtotime($data['tgl_kw_makan']));
              $pengajuan->status = 'Terima';
              $pengajuan->total_fix = $data['total'];
              if($pengajuan->save()){
                $updatesaldo = Saldo::find(1);
                $updatesaldo->saldo = $updatesaldo->saldo - $data['total']/2;
                if($updatesaldo->save()){
                    $response['code'] = 200;
                    $response['message'] = 'saldo sudah di simpan'; 
                }else{
                    $response['code'] = 400;
                    $response['message'] = 'Gagal Update saldo';
                }
                $response['code'] = 200;
                $response['message'] = 'Data sudah di simpan'; 
            }else{
                $response['code'] = 400;
                $response['message'] = 'Data error silakan hubungi tim terkait';
            } 
            
        } 
        return Response::json($response);
    }
}
public function uploadimage(Request $request)
{
    $imageupload = '';
    $image_original = '';
    if ($request->hasFile('myfile')) {
        $image = $request->file('myfile');
        if (count($image) != 14) {
          for ($i=0; $i < count($image); $i++) {
            $dataimage = md5(uniqid() . time()) . '.' . $image[$i]->getClientOriginalExtension().',';
            $originalimage = $image[$i]->getClientOriginalName().',';
            $imagestore = str_replace(',', '', $dataimage);
            $image[$i]->storeAs('public/uploads/spj', $imagestore);
            $imageupload .= $dataimage;
            $originaupload .= $originalimage;

        }
        $image_path = substr($imageupload, 0, -1);
        $image_original = substr($originaupload, 0, -1);
    }else{
      $image_path = '';
  }
}
$pengajuan = FormPengajuan::find($data['id_form']);
$pengajuan->file_kwutansi = $image_path;
if($pengajuan->save()){
    $response['code'] = 200;
    $response['message'] = 'Bisa';
}else{
    $response['code'] = 400;
    $response['message'] = 'Data error silakan hubungi tim terkait';
}  
return Response::json($response);
}
}