<?php

namespace App\Http\Controllers;

use App\Library\IPAPI;
use App\Library\sHelper;
use App\Models\Group;
use App\Models\Grup;
use App\Models\User_grup;
use App\Models\Hobby;
use App\Models\Post;
use App\Models\User;
use App\Models\UserDirectMessage;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = array();
        $response['code'] = 200;

        $user = Auth::user();

        $user_list = [];

        $grup = User_grup::join('grup','grup.id_grup','=','user_groups.id_groups')->where('user_groups.id_user','!=',$user->id)->limit(5)->get();

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
        // $html = View::make('home', compact('user', 'user_list', 'wall'));
        // $response['html'] = $html->render();
        // return Response::json($response);
        return view('home', compact('user', 'user_list', 'wall','grup'));
    }


    public function search(Request $request){


        $s = $request->input('s');
        if (empty($s)) return redirect('/');


        $user = Auth::user();
        $user_list = $user->messagePeopleList();

        $posts = Post::leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->where(function($query) use ($user) {

                $query->where('users.private', 0)->orWhere(function($query) use ($user){
                    $query->whereExists(function ($query) use($user){
                        $query->select(DB::raw(1))
                            ->from('user_following')
                            ->whereRaw('user_following.following_user_id = users.id and user_following.follower_user_id = '.$user->id);
                    });
                })->orWhere(function($query) use ($user){
                    $query->where('users.private', 1)->where('users.id', $user->id);
                });

            })->where('posts.content', 'like', '%'.$s.'%')->where('posts.group_id', 0)
            ->groupBy('posts.id')->select('posts.*')->orderBy('posts.id', 'DESC')->get();

        $comment_count = 2;

        $users = User::where('name', 'like', '%'.$s.'%')->orWhere('username', 'like', '%'.$s.'%')->orderBy('name', 'ASC')->get();

        return view('search', compact('users', 'posts', 'user', 'comment_count','user_list'));

    }




}
