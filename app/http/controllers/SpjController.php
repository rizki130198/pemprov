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
        $total = Saldo::Where('nama','=','total')->get()->first();
        $saldo = Saldo::all();
        if (Auth::user()->role != 'member') {
            $pending = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','!=','Selesai')->where('status','!=','Tolak')->where('status','!=','Tolak1')->orderBy('pengajuan_spj.created_at','DESC')->get();
            $selesai = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','=','Selesai')->orderBy('pengajuan_spj.created_at','DESC')->get();
            $tolak = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','=','Tolak')->Orwhere('status','=','Tolak1')->orderBy('pengajuan_spj.created_at','DESC')->get();
        }else{
            $pending = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','!=','Selesai')->where('status','!=','Tolak')->where('id_user','=',Auth::user()->id)->orderBy('pengajuan_spj.created_at','DESC')->get();
            $selesai = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','=','Selesai')->where('id_user','=',Auth::user()->id)->orderBy('pengajuan_spj.created_at','DESC')->get();
            $tolak = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','=','Tolak')->where('id_user','=',Auth::user()->id)->Orwhere('status','=','Tolak1')->orderBy('pengajuan_spj.created_at','DESC')->get();
        }
        return view('spj.spj', compact('user','data','user_list','pending','saldo','selesai','tolak','total'));
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
        if ($verif->status != 'Verifikasi') {
           return redirect('/spj')->with('error','Data Anda Sedang Di Proses Mohon di Tunggu');
        }else{
            return view('spj.formVerifikasi', compact('user','data','user_list','verif'));
        }
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
            $makan = $data['makan'] * 47000;
            $total = array_sum(array($snack,$makan)); 
            $saldo = Saldo::all();
            $pendingnya = Formpengajuan::Where('status','!=','Tolak')->Where('status','!=','Tolak1')->Where('status','!=','Selesai')->sum('total');
            if ($pendingnya > $saldo[2]->saldo) {
                $response['code'] = 400;
                $response['message'] = 'Saldo Pagu Tidak Cukup Karena Banyak Booking';
            }else{
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
                        $pengajuan->baca_pptk = '1';
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
                        $pengajuan->baca_pptk = '1';
                        $pengajuan->total = $total;
                    }
                }else{  
                    if ($saldo[2]->saldo < $total) {
                        $response['code'] = 400;
                        $response['message'] = 'Pagu Tidak Mencukupi';
                    }else{
                        $pengajuan = new FormPengajuan();
                        $pengajuan->id_user = Auth::user()->id;
                        $pengajuan->snack = $data['snack'];
                        $pengajuan->makan = $data['makan'];
                        $pengajuan->nama_rapat = $data['nama_rapat'];
                        $pengajuan->tanggal_rapat = $data['tgl_rapat'];
                        $pengajuan->baca_pptk = '1';
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
            $makan = $data['makan'] * 47000;
            $total = array_sum(array($snack,$makan)); 
            $saldo = Saldo::all();
            $pengajuan = FormPengajuan::find($data['id_form']);
            if ($total >= $pengajuan->total) {
                $response['code'] = 400;
                $response['message'] = 'Total Tidak Boleh lebih Besar Dari Sebelumnya';
            }else{
              $pengajuan->snack = $data['snack'];
              $pengajuan->makan = $data['makan'];
              $pengajuan->nama_rapat = $data['nama_rapat'];
              $pengajuan->tanggal_rapat = date('Y-m-d',strtotime($data['tgl_rapat']));
              $pengajuan->status = 'Pending';
              $pengajuan->total = $total;
                if($pengajuan->save()){
                    $response['code'] = 200;
                    $response['message'] = 'Data sudah di simpan';
                }else{
                    $response['code'] = 400;
                    $response['message'] = 'Data error silakan hubungi petugas terkait';
                }  
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
            $response['code'] = 200;
            $response['message'] = 'Saldo sama'; 
        }else{
            $pengajuan = Saldo::find($request->input('id_saldo'));
            $pengajuan->saldo = $request->input('value');
            if($pengajuan->save()){
                $saldo = Saldo::all();
                $total = Saldo::find(3);
                $total->saldo = array_sum(array($saldo[0]->saldo,$saldo[1]->saldo));
                $total->save();
                $response['code'] = 200;
                $response['message'] = 'Saldo Sudah Di ubah';
            }else{
                $response['code'] = 400;
                $response['message'] = 'Data error silakan hubungi tim terkait';
            } 
        }
        return Response::json($response);
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
           $cek = FormPengajuan::find($data['id_form']);
            if ($cek < $data['total']) {
                $response['code'] = 400;
                $response['message'] = 'Tidak Boleh Melebihi Batas Booking yang Sebelumnya';
            }else{
                $imageupload = '';
                $originaupload = '';
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
                    $pengajuan->harga_snack = $data['snack'];
                    $pengajuan->harga_makan = $data['makan'];
                    $pengajuan->penyedia_snack = $data['penyedia_snack'];
                    $pengajuan->penyedia_makan = $data['penyedia_makan'];
                    $pengajuan->tgl_snack = date('Y-m-d',strtotime($data['tgl_kw_snack']));
                    $pengajuan->tgl_makan = date('Y-m-d',strtotime($data['tgl_kw_makan']));
                    $pengajuan->status = 'Terima';
                    $pengajuan->file_kwutansi = $image_path;
                    $pengajuan->baca_subbag = '1';
                    $pengajuan->total_fix = $data['total'];
                  if($pengajuan->save()){
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
    public function Accselesai(Request $request)
    {
        $pengajuan = FormPengajuan::find($request->input('idpengajuan'));
        $pengajuan->status = 'Selesai';
        $pengajuan->baca_subbag = '0';
        if($pengajuan->save()){
            if($pengajuan->)
            $saldo = Saldo::find(3);
            $saldo->saldo =  $saldo->saldo - $pengajuan->total_fix;
            if($saldo->save()){
                $updatesaldo = Saldo::find(1);
                $updatesaldo->saldo = $saldo->saldo/2;
                if($updatesaldo->save()){
                    $updatesaldo2 = Saldo::find(2);
                    $updatesaldo2->saldo = $saldo->saldo/2;
                    $updatesaldo2->save();
                    $response['code'] = 200;
                    $response['message'] = 'Data Sudah Selesai'; 
                }else{
                    $response['code'] = 400;
                    $response['message'] = 'Data error silakan hubungi tim terkait';
                }
                $response['code'] = 200;
                $response['message'] = 'Data error silakan hubungi tim terkait';
            }else{
                $response['code'] = 400;
                $response['message'] = 'Data error silakan hubungi tim terkait';
            }
        }else{
            $response['code'] = 400;
            $response['message'] = 'Data error silakan hubungi tim terkait';
        } 
        return Response::json($response);
    }
    public function Tolakverif(Request $request)
    {
        $pengajuan = FormPengajuan::find($request->input('idpengajuan'));
        $pengajuan->status = 'Tolak1';
        if($pengajuan->save()){
            $response['code'] = 200;
            $response['message'] = 'Data Sudah di Tolak';
        }else{
            $response['code'] = 400;
            $response['message'] = 'Data error silakan hubungi tim terkait';
        } 
        return Response::json($response);
    }
    public function printSpj(Request $request,$id)
    {
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
        $selesai = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','=','Selesai')->where('id_pengajuan','=',$id)->get();

        return view('spj.printSpj', compact('user','data','user_list','selesai'));
    }
}
