<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDirectMessage;
use App\Models\FormPengajuan;
use App\Models\History_spj;
use App\Models\Saldo;
use DB;
use View;
use Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $anggaran = Formpengajuan::where('status','=','Selesai')->sum('total_fix');
        $total_booking = Formpengajuan::where('status','=','Pending')->orwhere('status','=','Verifikasi')->orwhere('status','=','Terima')->sum('total');
        $saldo = Saldo::all();
        if (Auth::user()->role != 'member') {
            $pending = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','!=','Selesai')->where('status','!=','Tolak')->where('status','!=','Tolak1')->orderBy('pengajuan_spj.updated_at','DESC')->get();
            $selesai = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','=','Selesai')->orderBy('pengajuan_spj.updated_at','DESC')->get();
            $tolak = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','=','Tolak')->Orwhere('status','=','Tolak1')->orderBy('pengajuan_spj.updated_at','DESC')->get();
        }else{
            $pending = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','!=','Selesai')->where('status','!=','Tolak')->where('status','!=','Tolak1')->where('id_user','=',Auth::user()->id)->orderBy('pengajuan_spj.updated_at','DESC')->get();
            $selesai = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','=','Selesai')->where('id_user','=',Auth::user()->id)->orderBy('pengajuan_spj.updated_at','DESC')->get();
            $tolak = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','=','Tolak')->where('id_user','=',Auth::user()->id)->Orwhere('status','=','Tolak1')->orderBy('pengajuan_spj.updated_at','DESC')->get();
        }

        if (Auth::user()->role == 'pptk') {
            $count1 = Formpengajuan::where('status','=','Pending')->count();
        }elseif (Auth::user()->role == 'subbag'){ 
            $count1 = Formpengajuan::where('status','=','Terima')->count();
        }else{
            $count1 = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','!=','Selesai')->where('status','!=','Tolak')->where('status','!=','Tolak1')->orderBy('pengajuan_spj.created_at','DESC')->count();
        }
        return view('spj.spj', compact('user','data','user_list','pending','saldo','selesai','tolak','total','total_booking','count1','anggaran'));
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
        if ($verif->status != 'Verifikasi' AND $verif->status != 'Tolak1') {
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
                $response['message'] = 'Saldo Pagu Tidak Cukup, Karena Banyak Booking';
            }else{
                if ($data['snack'] == NULL) {
                    if ($saldo[1]->saldo < $snack) {
                        $response['code'] = 400;
                        $response['message'] = 'Pagu Snack Tidak Mencukupi';
                    }else{
                        $pengajuan = new FormPengajuan();
                        $pengajuan->id_user = Auth::user()->id;
                        $pengajuan->makan = $data['makan'];
                        $pengajuan->nama_rapat = $data['nama_rapat'];
                        $pengajuan->tanggal_rapat = date('Y-m-d', strtotime($data['tgl_rapat']));
                        $pengajuan->baca_pptk = '1';
                        $pengajuan->total = $total;
                    }
                }elseif($data['makan'] == NULL){
                    if ($saldo[0]->saldo < $makan) {
                        $response['code'] = 400;
                        $response['message'] = 'Pagu Makan Tidak Mencukupi';
                    }else{
                        $pengajuan = new FormPengajuan();
                        $pengajuan->id_user = Auth::user()->id;
                        $pengajuan->snack = $data['snack'];
                        $pengajuan->nama_rapat = $data['nama_rapat'];
                        $pengajuan->tanggal_rapat = date('Y-m-d', strtotime($data['tgl_rapat']));
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
                        $pengajuan->tanggal_rapat = date('Y-m-d', strtotime($data['tgl_rapat']));
                        $pengajuan->baca_pptk = '1';
                        $pengajuan->total = $total;
                    }
                }
                if($pengajuan->save()){
                    $histori = new History_spj;
                    $histori->id_user = $pengajuan->id_user;
                    $histori->id_spj = $pengajuan->id_pengajuan;
                    $histori->comment = "Membuat Form Booking";
                    if ($histori->save()) {   
                        $response['code'] = 200;
                        $response['message'] = 'Data History sudah di simpan';
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
            if ($pengajuan->status != 'Pending' AND $pengajuan->status != 'Tolak' AND $pengajuan->status != 'Tolak1') {
                if($total >= $pengajuan->total){
                    $response['code'] = 400;
                    $response['message'] = 'Total Tidak Boleh lebih Besar Dari Sebelumnya';
                }else{
                    $pengajuan->snack = $data['snack'];
                    $pengajuan->makan = $data['makan'];
                    $pengajuan->nama_rapat = $data['nama_rapat'];
                    $pengajuan->tanggal_rapat = date('Y-m-d',strtotime($data['tgl_rapat']));
                    if (Auth::user()->role == 'pptk') {
                        $pengajuan->harga_snack = $data['total_snack'];
                        $pengajuan->harga_makan = $data['total_makan'];
                        $pengajuan->total_fix = $data['total'];
                        $pengajuan->status = 'Terima';
                    }else{
                        $pengajuan->total = $total;
                        $pengajuan->status = 'Pending';
                    }
                    if($pengajuan->save()){
                        $histori = new History_spj;
                        $histori->id_user = $pengajuan->id_user;
                        $histori->id_spj = $pengajuan->id_pengajuan;
                        $histori->comment = "Mengubah Form Booking";
                        if ($histori->save()) {   
                            $response['code'] = 200;
                            $response['message'] = 'Data History sudah di simpan';
                        }
                        $response['code'] = 200;
                        $response['message'] = 'Data sudah di simpan';
                    }else{
                        $response['code'] = 400;
                        $response['message'] = 'Data error silakan hubungi petugas terkait';
                    }  
                }
            }else{
              $pengajuan->snack = $data['snack'];
              $pengajuan->makan = $data['makan'];
              $pengajuan->nama_rapat = $data['nama_rapat'];
              $pengajuan->tanggal_rapat = date('Y-m-d',strtotime($data['tgl_rapat']));
                if (Auth::user()->role == 'pptk') {
                    $pengajuan->harga_snack = $data['total_snack'];
                    $pengajuan->harga_makan = $data['total_makan'];
                    $pengajuan->total_fix = $data['total'];
                    $pengajuan->status = 'Terima';
                }else{
                    $pengajuan->total = $total;
                    $pengajuan->status = 'Pending';
                }
                    if($pengajuan->save()){
                        $histori = new History_spj;
                        $histori->id_user = $pengajuan->id_user;
                        $histori->id_spj = $pengajuan->id_pengajuan;
                        $histori->comment = "Mengubah Form Booking";
                    if ($histori->save()) {   
                        $response['code'] = 200;
                        $response['message'] = 'Data History sudah di simpan';
                    }
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
    // public function UbahFormPengajuanpptk(Request $request)
    // {
    //     $response = array();
    //     $response['code'] = 400;
    //     $data = $request->all();
    //     $messages = [
    //         'snack' => 'required',
    //         'makan' => 'required',
    //         'nama_rapat' => 'required',
    //         'tgl_rapat' => 'required',
    //     ];
    //     $validator = Validator::make($data, $messages);

    //     if ($validator->fails()) {
    //         $response['code'] = 400;
    //         $response['message'] = implode(' ', $validator->errors()->all());
    //     }else{
    //         $pengajuan = FormPengajuan::find($data['id_form']);
    //         $pengajuan->snack = $data['snack'];
    //         $pengajuan->makan = $data['makan'];
    //         $pengajuan->nama_rapat = $data['nama_rapat'];
    //         $pengajuan->tanggal_rapat = date('Y-m-d',strtotime($data['tgl_rapat']));
    //         $pengajuan->status = 'Pending';
    //         $pengajuan->total = $total;
    //         if($pengajuan->save()){
    //             $response['code'] = 200;
    //             $response['message'] = 'Data sudah di simpan';
    //         }else{
    //             $response['code'] = 400;
    //             $response['message'] = 'Data error silakan hubungi petugas terkait';
    //         }  
    //         return Response::json($response);
    //     }
    // }
    public function AccData(Request $request)
    {
        $pengajuan = FormPengajuan::find($request->input('idpengajuan'));
        $pengajuan->status = 'Verifikasi';
        $pengajuan->baca_pptk = '0';
        $pengajuan->tgl_verif = Carbon::now();
        if($pengajuan->save()){
            $histori = new History_spj;
            $histori->id_user = $pengajuan->id_user;
            $histori->id_spj = $pengajuan->id_pengajuan;
            $histori->comment = "Form Booking Sudah di Verifikasi PPTK";
            if ($histori->save()) {   
                $response['code'] = 200;
                $response['message'] = 'Data History sudah di simpan';
            }
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
        $pengajuan->alasan = $request->input('alasan');
        $pengajuan->tgl_tolak_pptk = Carbon::now();
        if($pengajuan->save()){
            $histori = new History_spj;
            $histori->id_user = $pengajuan->id_user;
            $histori->id_spj = $pengajuan->id_pengajuan;
            $histori->comment = "Form Booking Verifikasi di Tolak PPTK";
            if ($histori->save()) {   
                $response['code'] = 200;
                $response['message'] = 'Data History sudah di simpan';
            }
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

        if ($request->hasFile('myfile')){
            $validator_data['myfile.*'] = 'required|mimes:jpeg,jpg,png,gif';
        }else if($request->hasFile('ft_absen')){
            $validator_data['ft_absen.*'] = 'required|mimes:jpeg,jpg,png,gif';
        }else if($request->hasFile('myfile_kwd')){
            $validator_data['myfile_kwd.*'] = 'required|mimes:jpeg,jpg,png,gif';
        }else if($request->hasFile('ft_absen')){
            $validator_data['ft_absen.*'] = 'required|mimes:jpeg,jpg,png,gif';
        }else if($request->hasFile('ft_notulen')){
            $validator_data['ft_notulen.*'] = 'required|mimes:jpeg,jpg,png,gif';
        }else if($request->hasFile('ft_undangan')){
            $validator_data['ft_undangan.*'] = 'required|mimes:jpeg,jpg,png,gif';
        }else if($request->hasFile('ft_nota')){
            $validator_data['ft_nota.*'] = 'required|mimes:jpeg,jpg,png,gif';
        }else{
             $validator_data = [
            'snack' => 'required',
            'makan' => 'required',
            'penyedia_snack' => 'required',
            'penyedia_makan' => 'required',
            'penyedia_makan' => 'required',
            'tgl_kw_snack' => 'required',
            'tgl_kw_makan' => 'required',
        ];
        }

        $validator = Validator::make($data, $validator_data);

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
                $imagekwd = '';
                $uploadkwd = '';
                if ($request->hasFile('myfile_kwd')) {
                    $kwd = $request->file('myfile_kwd');
                    if (count($kwd) != 14) {
                      for ($i=0; $i < count($kwd); $i++) {
                        $datakwd = md5(uniqid() . time()) . '.' . $kwd[$i]->getClientOriginalExtension().',';
                        $originalkwd = $kwd[$i]->getClientOriginalName().',';
                        $storekwd = str_replace(',', '', $datakwd);
                        $kwd[$i]->storeAs('public/uploads/kwd_dinas', $storekwd);
                        $imagekwd .= $datakwd;
                        $uploadkwd .= $originalkwd;
                      }
                        $image_kwd = substr($imagekwd, 0, -1);
                        $kwd_asli = substr($uploadkwd, 0, -1);
                    }else{
                        $image_kwd = '';
                    }
                }
                $imageabsen = '';
                $original_absen = '';
                if ($request->hasFile('ft_absen')) {
                    $absen = $request->file('ft_absen');
                    if (count($absen) != 14) {
                      for ($i=0; $i < count($absen); $i++) {
                        $dataabsen = md5(uniqid() . time()) . '.' . $absen[$i]->getClientOriginalExtension().',';
                        $originalabsen = $absen[$i]->getClientOriginalName().',';
                        $storeabsen = str_replace(',', '', $dataabsen);
                        $absen[$i]->storeAs('public/uploads/absen', $storeabsen);
                        $imageabsen .= $dataabsen;
                        $original_absen .= $originalabsen;
                      }
                        $path_absen = substr($imageabsen, 0, -1);
                        $absenasli = substr($original_absen, 0, -1);
                    }else{
                        $path_absen = '';
                    }
                }
                $imagenotulen = '';
                $originalnotulen = '';
                if ($request->hasFile('ft_notulen')) {
                    $notulen = $request->file('ft_notulen');
                    if (count($notulen) != 14) {
                      for ($i=0; $i < count($notulen); $i++) {
                        $datanotulen = md5(uniqid() . time()) . '.' . $notulen[$i]->getClientOriginalExtension().',';
                        $original_notulen = $notulen[$i]->getClientOriginalName().',';
                        $store_notulen = str_replace(',', '', $datanotulen);
                        $notulen[$i]->storeAs('public/uploads/notulen', $store_notulen);
                        $imagenotulen .= $datanotulen;
                        $originalnotulen .= $original_notulen;
                      }
                        $path_notulen = substr($imagenotulen, 0, -1);
                        $notulen_asli = substr($originalnotulen, 0, -1);
                    }else{
                        $path_notulen = '';
                    }
                }
                $imageundang = '';
                $originalundang = '';
                if ($request->hasFile('ft_undangan')) {
                    $undang = $request->file('ft_undangan');
                    if (count($undang) != 14) {
                      for ($i=0; $i < count($undang); $i++) {
                        $dataundang = md5(uniqid() . time()) . '.' . $undang[$i]->getClientOriginalExtension().',';
                        $original_undang = $undang[$i]->getClientOriginalName().',';
                        $storeundang = str_replace(',', '', $dataundang);
                        $undang[$i]->storeAs('public/uploads/undang', $storeundang);
                        $imageundang .= $dataundang;
                        $originalundang .= $original_undang;
                    }
                        $path_undang = substr($imageundang, 0, -1);
                        $undangasli = substr($originalundang, 0, -1);
                    }else{
                        $path_undang = '';
                    }
                }
                $imagenota = '';
                $originalnota = '';
                if ($request->hasFile('ft_nota')) {
                    $nota = $request->file('ft_nota');
                    if (count($nota) != 14) {
                      for ($i=0; $i < count($nota); $i++) {
                        $datanota = md5(uniqid() . time()) . '.' . $nota[$i]->getClientOriginalExtension().',';
                        $original_nota = $nota[$i]->getClientOriginalName().',';
                        $storenota = str_replace(',', '', $datanota);
                        $nota[$i]->storeAs('public/uploads/nota', $storenota);
                        $imagenota .= $datanota;
                        $originalnota .= $original_nota;
                    }
                        $path_nota = substr($imagenota, 0, -1);
                        $notaasli = substr($originalnota, 0, -1);
                    }else{
                        $path_nota = '';
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
                    $pengajuan->file_kwd = $image_kwd;    
                    $pengajuan->file_notulen = $path_notulen;    
                    $pengajuan->file_absen = $path_absen;    
                    $pengajuan->file_undangan = $path_undang;    
                    $pengajuan->file_nota = $path_nota;    
                    $pengajuan->baca_subbag = '1';
                    $pengajuan->total_fix = $data['total'];
                    $pengajuan->tgl_form = Carbon::now();
                  if($pengajuan->save()){
                        $datahistory = new History_spj;
                        $datahistory->id_user = $pengajuan->id_user;
                        $datahistory->id_spj = $pengajuan->id_pengajuan;
                        $datahistory->comment = "Mengirim Form Verifikasi Kebagian Subbag";
                            if ($datahistory->save()) {   
                                $response['code'] = 200;
                                $response['message'] = 'Data History sudah di simpan';
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
    public function Accselesai(Request $request)
    {
        $pengajuan = FormPengajuan::find($request->input('idpengajuan'));
        $pengajuan->status = 'Selesai';
        $pengajuan->baca_subbag = '0';
        $pengajuan->tgl_selesai = Carbon::now();
        if($pengajuan->save()){
            $saldo = Saldo::find(3);
            $saldo->saldo =  $saldo->saldo - $pengajuan->total_fix;
            if($saldo->save()){
                if ($pengajuan->harga_snack == NULL) {
                    $updatesaldo = Saldo::find(1);
                    $updatesaldo->saldo = $saldo->saldo - $pengajuan->total_fix;
                    if ($updatesaldo->save()) {
                        $response['code'] = 200;
                        $response['message'] = 'Data Sudah Selesai'; 
                    }else{ 
                        $response['code'] = 400;
                        $response['message'] = 'Data Error'; 
                    }
                }elseif($pengajuan->harga_makan == NULL){
                    $updatesaldo2 = Saldo::find(2);
                    $updatesaldo2->saldo = $saldo->saldo - $pengajuan->total_fix;
                    if ($updatesaldo2->save()) {
                        $response['code'] = 200;
                        $response['message'] = 'Data Sudah Selesai'; 
                    }else{ 
                        $response['code'] = 400;
                        $response['message'] = 'Data Error'; 
                    }
                }else{
                    $updatesaldo = Saldo::find(1);
                    $updatesaldo->saldo = $saldo->saldo/2;
                    if ($updatesaldo->save()) { 
                        $updatesaldo2 = Saldo::find(2);
                        $updatesaldo2->saldo = $saldo->saldo/2;
                        if ($updatesaldo2->save()) {
                            $response['code'] = 200;
                            $response['message'] = 'Data Selesai';
                        }
                    }
                }
                $response['code'] = 200;
                $response['message'] = 'Data Total Sudah di Ubah';
            }else{
                $response['code'] = 400;
                $response['message'] = 'Data error silakan hubungi tim terkait';
            }
                $histori = new History_spj;
                $histori->id_user = $pengajuan->id_user;
                $histori->id_spj = $pengajuan->id_pengajuan;
                $histori->comment = "Form Permohonan Sudah selesai";
                if ($histori->save()) {   
                    $response['code'] = 200;
                    $response['message'] = 'Data History sudah di simpan';
                }

                $response['code'] = 200;
                $response['message'] = 'Saldo tidak di update';
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
        $pengajuan->alasan = $request->input('alasan');
        $pengajuan->tgl_tolak_subbag = Carbon::now();
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
        $selesai = FormPengajuan::join('users','users.id','=','pengajuan_spj.id_user')->where('status','=','Selesai')->Orwhere('status','=','Terima')->where('id_pengajuan','=',$id)->get();

        return view('spj.printSpj', compact('user','data','user_list','selesai'));
    }
}
