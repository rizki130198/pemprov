<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventComment;
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
		$user = Auth::user();

		$user_list = $user->messagePeopleList();


		$data =  Event::join('users', 'users.id', '=', 'events.id_users')->where('akhir','>', date('Y-m-d H:i:s'))->orderby('id_events','DESC')->get();

		return view('events.index', compact('user', 'data','user_list'));
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

		$event = Event::find($request->input('id'));
		$text = $request->input('komentar');



			$comment = new EventComment();
			$comment->id_events = $event->id_events;
			$comment->id_users = $user->id;
			$comment->komentar = $text;
			if ($comment->save()){
				$response['code'] = 200;
				$html = View::make('widgets.single_comment', compact('event', 'comment'));
				$response['comment'] = $html->render();
				$html = View::make('widgets.comments_title', compact('event', 'comment'));
				$response['comments_title'] = $html->render();
			}else{

				$response['code'] = 400;
			}

		return Response::json($response);
	}

	public function deleteComment(Request $request){

		$response = array();
		$response['code'] = 400;

		$events_comment = EventComment::find($request->input('id'));


		if ($events_comment){
			$post = $events_comment->post;
			if ($events_comment->id_users == Auth::id() || $events_comment->post->id_users == Auth::id()) {
				if ($events_comment->delete()) {
					$response['code'] = 200;
					$html = View::make('widgets.post_detail.comments_title', compact('post'));
					$response['comments_title'] = $html->render();
				}
			}
		}

		return Response::json($response);
	}


}

