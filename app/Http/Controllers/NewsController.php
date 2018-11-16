<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserDirectMessage;
use Auth;
use DB;
use App\Models\News;
use App\Models\News_Comment;
use App\Models\CekComment;
use App\Models\NotifNews;
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

		$news = DB::table('post_news')->orderBy('post_news.id','desc');
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
	public function singlenews($day,$month,$years,$string)
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
		$potong = str_replace('-', ' ', $string);
		$getdata = News::where('judul',$potong);
		if ($getdata != null) {
			foreach ($getdata->get() as $key) {
				$getcomment = News_Comment::join('users','news_comment.id_user','=','users.id')->where('news_comment.id_news',$key->id)->orderBy('id_comment','DESC');
				$NotifNews = NotifNews::where('seen',1)->where('id_users',$user->id)->where('id_news',$key->id)->get()->first();
				if ($NotifNews == null) {
					$insert = new NotifNews;
					$insert->id_users = $user->id;
					$insert->id_news = $key->id;
					$insert->seen = 1;
					$insert->save();
				}
				foreach ($getcomment->get() as $value) {
					$CekComment = CekComment::where('id_coment',$value->id_comment)->where('id_users',$user->id)->get()->first();
					if ($CekComment == null) {
						$cek = new CekComment;
						$cek->id_coment = $value->id_comment;
						$cek->id_users = $user->id;
						$cek->id_berita = $key->id;
						$cek->seen = 1;
						$cek->save();
					}
				}
				return view('news.widgets.single_news', compact('user','user_list','getdata','getcomment'));
			}
		}else{
			return redirect('news')->with('false','Data Yang anda Cari tidak di temukan');
		}
	}
	public function newscomment(Request $request,$idnews){

		$user = Auth::user();

		$response = array();
		$response['code'] = 400;

		$getdata = News::where('id',$idnews)->get()->first();
		$text = $request->input('content');

		if (!empty($text)){

			$getcomment = new News_Comment();
			$getcomment->id_news = $idnews;
			$getcomment->id_user = $user->id;
			$getcomment->comment = $text;
			$getcomment->seen = 0;
			if ($getcomment->save()){
				$response['code'] = 200;
				return Redirect::back();
			}

		}

		return Response::json($response);
	}
	public function deletenews(Request $request)
	{
		$user = Auth::user();

		$response = array();
		$response['code'] = 400;
		$id = $request->input('id');

		if (Auth::user()->role == 'admin'){
			$commentdelete = News_Comment::where('id_news',$id)->delete();
			$cekdata = News::where('id',$id)->delete();
			if ($cekdata) {
				$response['code'] = 200;
			}else{
				$response['code'] = 400;
			}
		}

		return Response::json($response);
	}

	public function newscommentdelete(Request $request)
	{
		$user = Auth::user();

		$response = array();
		$response['code'] = 400;
		$id = $request->input('id');
		$id_news = $request->input('idnews');
		$cekdata = News_Comment::where('id_comment',$id)->delete();
		if ($cekdata == TRUE) {
			$count = News_Comment::where('id_news',$id_news)->count();
			$response['code'] = 200;
			$response['count'] = $count;
		}else{
			$response['code'] = 400;
		}

		return Response::json($response);
	}
	public function modal(Request $request)
	{
		$user = Auth::user();
		$user_list = [];
		$editdata = News::where('id',$request->input('idnews'))->get();
		$return = view::make('news.modalnews',compact('editdata','user_list','user'));
		$response['html'] = $return->render();
		return Response::json($response);
	}
	public function update(Request $request)
	{
		$data = $request->all();
		if ($request->hasFile('image')){
			$validator_data['image'] = 'mimes:jpg,png,jpeg';
		}else{
			$validator_data['content'] = 'required';
			$validator_data['judul'] = 'required';
		}

		$validator = Validator::make($data, $validator_data);
		if ($validator->fails()) {
			$response['code'] = 400;
			$response['message'] = implode(' ', $validator->errors()->all());
		}else{
			$news = News::find($data['idnews']);
			if ($request->hasFile('image') != NULL) {
				$file_name = '';
				$file = $request->file('image');
				$file_name = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
				if ($file->storeAs('public/uploads/posts', $file_name)) {
					$news->cover = $file_name;
				} else {
					$news->cover = '';
				}
			}else{
				$news->cover = '';
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
}	