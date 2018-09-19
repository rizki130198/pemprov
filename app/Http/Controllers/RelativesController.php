<?php
/**
 * Created by lvntayn
 * Date: 09/06/2017
 * Time: 03:09
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Library\sHelper;
use App\Models\User;
use App\Models\UserFollowing;
use App\Models\UserRelationship;
use App\Models\UserDirectMessage;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Response;
use Session;
use View;

class RelativesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }



    public function relativeRequest(Request $request){


        $response = array();
        $response['code'] = 400;

        $type = $request->input('type');
        $id = $request->input('id');



        $relation = UserRelationship::find($id);



        if ($relation){

            if ($type == 2){
                if ($relation->delete()){
                    $response['code'] = 200;
                }
            }else{
                $relation->allow = 1;
                if ($relation->save()){
                    $response['code'] = 200;
                }
            }


        }


        return Response::json($response);

    }

    public function delete(Request $request){


        $response = array();
        $response['code'] = 400;

        $id = $request->input('id');
        $type = $request->input('type');


        $relation = UserRelationship::find($id);

        if ($relation){


            if ($relation->delete()){
                $response['code'] = 200;
            }


        }


        return Response::json($response);

    }

    public function pending(Request $request){


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

        $list = $user->relatives()->where('allow', 0)->with('relative')->get();


        return view('relatives_pending', compact('user', 'list','user_list'));
    }


}