<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Group;
use App\Models\Grup;
use App\Models\GrupPost;
use App\Models\User_grup;
use App\Models\Hobby;
use App\Models\User;
use App\Models\UserDirectMessage;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Response;
use Storage;

class GroupController extends Controller
{

    public $group;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function secure($id){
        $group = Grup::find($id);

        if ($group){
            $this->group = $group;
            return true;
        }
        return false;
    }

    public function index()
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

        // $user_list = $user->messagePeopleList();

        $groups = Grup::join('user_groups', 'user_groups.id_groups', '=', 'grup.id_grup')
        ->join('users','users.id','=','grup.id_user')
        ->where('user_groups.id_user', $user->id);

        return view('groups.index', compact('user', 'groups','user_list','anggota'));
    }



    public function group($id){

        if (!$this->secure($id)) return redirect('/404');
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

        $group = $this->group;
        $id_link = $id;
        // $user_list = $user->messagePeopleList();
        $wall = [
            'new_postgrup_group_id' => $group->id_group
        ];
        $images_grup = DB::table('posts_grup')->join('post_grup_images', 'post_grup_images.post_grup_id', '=', 'posts_grup.id_post_grup')->where('group_post_id', $id_link)->get();
        
        $groups = Grup::join('user_groups', 'user_groups.id_groups', '=', 'grup.id_grup')
        ->join('users','users.id','=','grup.id_user')
        ->where('user_groups.id_user', $user->id);
        $validasi = User_grup::find($user->id);
        $cekanggota = User_grup::where('id_user',$user->id)->get()->first();
        $anggota = User_grup::join('users','users.id','=','user_groups.id_user')->where('user_groups.id_groups',$id)->get();

        if ($validasi) {
            if (request()->segment(2) == "diskusi") {
                return view('groups.group', compact('id_link','user' ,'group', 'wall','user_list','groups','anggota','images_grup'));
            }elseif (request()->segment(2) == "anggota") {
                return view('groups.group', compact('id_link','user' ,'group', 'wall','user_list','groups','anggota','images_grup','cekanggota'));
            }elseif (request()->segment(2) == "foto") {
                return view('groups.group', compact('id_link','user' ,'group', 'wall','user_list','groups','anggota','images_grup'));
            }elseif (request()->segment(2) == "pengaturan_group") {
                return view('groups.group', compact('id_link','user' ,'group', 'wall','user_list','groups','anggota','images_grup'));
            }     
        }else{
            return redirect('/404');
        }

    }
    public function edit(Request $request, $id){

        $response = array();
        $response['code'] = 400;
        if (!$this->secure($id, true)) return Response::json($response);
        $data = $request->all();
        $messages = [
            'nama_grup' => 'required',
            'privasi' => 'required',
        ];
        $validator = Validator::make($data, $messages);

        if ($validator->fails()) {
            $response['code'] = 400;
            $response['message'] = implode(' ', $validator->errors()->all());
        }else{
            $cover = Grup::find($id);
            $cover->nama_grup = $data['nama_grup'];
            $cover->status_grup = $data['privasi'];
            if($cover->save()){
                return redirect('group/pengaturan_group/'.$id);
            }else{
                return redirect('group/pengaturan_group/'.$id);
            }
        }

    }
    public function uploadCover(Request $request, $id){

        $response = array();
        $response['code'] = 400;
        if (!$this->secure($id, true)) return Response::json($response);

        $messages = [
            'image.required' => trans('validation.required'),
            'image.mimes' => trans('validation.mimes'),
            'image.max.file' => trans('validation.max.file'),
        ];
        $validator = Validator::make(array('image' => $request->file('image')), [
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:2048'
        ], $messages);

        if ($validator->fails()) {
            $response['code'] = 400;
            $response['message'] = implode(' ', $validator->errors()->all());
        }else{

            $file_name ="";

            $file = $request->file('image');

            $file_name = md5(uniqid() .$file->getClientOriginalName(). time()) . '.' . $file->getClientOriginalExtension();
            if ($file->storeAs('public/uploads/covers', $file_name)){
                $response['code'] = 200;
                $cover = Grup::find($id);
                $cover->cover_grup = $file_name;
                $cover->save();
            }else{
                $response['code'] = 400;
                $response['message'] = "Something went wrong!";
            }
        }
        return Response::json($response);

    }
    public function stats($id){


        if (!$this->secure($id)) return redirect('/404');

        $user = Auth::user();

        $group = $this->group;

        $country = $user->location->city->country;
        $city = $user->location->city;

        $all_countries = $group->countAllCountries();

        return view('groups.stats', compact('user', 'group', 'country', 'city', 'all_countries'));
    }

    public function deleteMemberGrup($id)
    {
        $response = array();
        $response['code'] = 400;
        if (Auth::user()->id != $id) {
           $update = User_grup::where('id_user',$id)->delete();
           $response['code'] = 200;
       }else{
        $response['code'] = 400;
        $response['message'] = "Anda Tidak bisa delete anda sendiri";
    }
    return Response::json($response);
}
public function deleteGrup($id)
{

    $response = array();
    $response['code'] = 400;

    if (!$this->secure($id)) return redirect('/home');

    $grup = Grup::where('id_grup',$id)->get()->first();

    if (count($grup->id_grup) != 0 ) {
        $delete = User_grup::where('id_groups',$id)->delete();
        if ($delete) {
            $deleteGrup = Grup::where('id_grup',$id)->delete();
            $response['code'] = 200;
        }else{
            $response['code'] = 400;
        }
    }else{
        $deleteGrup = Grup::where('id_grup',$id)->delete();
        $response['code'] = 200;
    }
    return Response::json($response);
}
public function addAdmin($id)
{

    $response = array();
    $response['code'] = 400;

    if (Auth::user()->id != $id) {

       $update = User_grup::where('id_user',$id)->get()->first();

       $update->jabatan_grup = 'admin';

       $update->save();

       $response['code'] = 200;
   }else{
    $response['code'] = 400;
    $response['message'] = "Anda bukan Pemilik grup";
}
return Response::json($response);
}

}
