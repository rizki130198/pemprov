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
use Illuminate\Support\Facades\Auth;

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

        $anggota = User_grup::join('users','users.id','=','user_groups.id_user')->where('user_groups.id_groups',$id)->get();
        if ($validasi) {
            if (request()->segment(2) == "diskusi") {
                return view('groups.group', compact('id_link','user' ,'group', 'wall','user_list','groups','anggota','images_grup'));
            }elseif (request()->segment(2) == "anggota") {
                return view('groups.group', compact('id_link','user' ,'group', 'wall','user_list','groups','anggota','images_grup'));
            }elseif (request()->segment(2) == "foto") {
                return view('groups.group', compact('id_link','user' ,'group', 'wall','user_list','groups','anggota','images_grup'));
            }elseif (request()->segment(2) == "pengaturan_group") {
                return view('groups.group', compact('id_link','user' ,'group', 'wall','user_list','groups','anggota','images_grup'));
            }     
        }else{
            return redirect('/404');
        }

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



}
