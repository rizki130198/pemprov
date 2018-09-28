<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserDirectMessage;
use Auth;
use DB;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Response;
use Session;
use View;


class NewsController extends Controller
{    
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

		$news = News::join('users','post_news.user_id','=','users.id')->orderBy('post_news.id','desc');
		return view('news.index', compact('user','user_list','comment_count','news'));
	}
	public function create(Request $request)
	{
		$data = $request->all();
		if ($request->hasFile('image')){
			$validator_data['image'] = 'mimes:jpg,png,jpeg';
		}else{
			$validator_data['content'] = 'required';
		}

		$validator = Validator::make($data, $validator_data);
		if ($validator->fails()) {
			$response['code'] = 400;
			$response['message'] = implode(' ', $validator->errors()->all());
		}else{
			$news = new News();
			if ($request->hasFile('image') != NULL) {
				$file_name = '';
				$file = $request->file('image');
				$file_name = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
				if ($file->storeAs('public/uploads/posts', $file_name)) {
					$news->cover = $file_name;
				} else {
					$news->cover = '';
				}
			}
			$news->user_id = Auth::user()->id;
			$news->judul = $data['judul'];
			$news->isi = $data['content'];
			$news->seen = 0;

			if ($news->save()) {
				return redirect('news');
			}else{				
				$response['code'] = 400;
				$response['message'] = "Something went wrong!";
			}
			
			
		}

	}
	public function singlenews($string)
	{
		$user_list = $user->messagePeopleList();
		$user_list = [];
		$user = Auth::user();
		$potong =  str_replace('-', ' ', $string);
		$getdata = News::where('judul',$potong)->get();
		if ($getdata != null) {
			return view('news.single', compact('user','user_list','getdata'));
		}else{
			return redirect('news')->with('false','Data Yang anda Cari tidak di temukan');
		}
	}
}	