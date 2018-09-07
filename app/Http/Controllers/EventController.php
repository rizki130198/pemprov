<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventComment;
use App\Models\UserDirectMessage;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Response;
use Session;
use View;


class EventController extends Controller
{    
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$response = array();
        $response['code'] = 200;

        $user = Auth::user();
        $comment_count = 2000000;

		$user_list = $user->messagePeopleList();

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

		$data =  Event::join('users', 'users.id', '=', 'events.id_users')->where('akhir','>', date('Y-m-d H:i:s'))->orderby('id_events','DESC')->get();

		return view('events.index', compact('user', 'data','user_list','comment_count'));
	}
	public function save(Request $request)
	{
		if (Auth::user()->role == 'admin') {
			$data = $request->all();

			$response = array();
			$response['code'] = 400;
			$rules = [
				'nama_events'=>'required',
				'ket'=>'required',
				'awal'=>'required',
				'akhir'=>'required',
			];
			$validator = Validator::make($data,$rules);

			if ($validator->fails()) {
				$response['code'] = 400;
				$response['message'] = implode(' ', $validator->errors()->all());
			}else{

				$event = new Event();

				$event->id_users = Auth::user()->id;
				$event->nama_event = $request->input('nama_events');
				$event->keterangan = $request->input('ket');
				$event->mulai = date('Y-m-d H:i:s', strtotime($request->input('awal')));
				$event->akhir = date('Y-m-d H:i:s', strtotime($request->input('akhir')));
				$event->tanggal = date('Y-m-d H:i:s');
				$event->status = 'Aktif';

				if ($event->save()) {
					$response['code'] = 200;
				}else{
					$response['code'] = 400;
					$response['message'] = "Ada Kesalaham!";
					$post->delete();
				}
			}

		}else{
			$response['code'] = 400;
			$response['message'] = "Anda Bukan Admin";
		}

		return Response::json($response);
	}
	public function hapusEvent($id)
	{
		$event = Events::find($id);
		$events->delete();
		return redirect()->route('events')->with('success', 'Data Deleted');
	}
	public function delete(Request $request){

		$response = array();
		$response['code'] = 400;

		$event = Event::find($request->input('id'));

		if ($event){
			if ($event->id_users == Auth::id()) {
				if ($event->delete()) {
					$response['code'] = 200;
				}
			}
		}

		return Response::json($response);
	}

	public function comment(Request $request){

		$user = Auth::user();

		$response = array();
		$response['code'] = 400;

		$dataevent = Event::find($request->input('id'));
		$text = $request->input('komentar');



			$comment = new EventComment();
			$comment->id_events = $dataevent->id_events;
			$comment->id_users = $user->id;
			$comment->komentar = $text;
			if ($comment->save()){
				$response['code'] = 200;
				$html = View::make('events.widgets.single_comment', compact('dataevent', 'comment'));
				$response['comment'] = $html->render();
				$html = View::make('events.widgets.comments_title', compact('dataevent', 'comment'));
				$response['comments_title'] = $html->render();
			}else{

				$response['code'] = 400;
			}

		return Response::json($response);
	}

	public function deleteComment(Request $request){

		$response = array();
		$response['code'] = 400;

		$dataevent = EventComment::find($request->input('id'));


		if ($dataevent){
			$post = $dataevent->post;
			if ($dataevent->id_users == Auth::id() || $dataevent->post->id_users == Auth::id()) {
				if ($dataevent->delete()) {
					$response['code'] = 200;
					$html = View::make('events.widgets.comments_title', compact('dataevent'));
					$response['comments_title'] = $html->render();
				}
			}
		}

		return Response::json($response);
	}

}

