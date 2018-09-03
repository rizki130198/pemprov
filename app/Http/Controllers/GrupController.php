<?php
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Grup;
use App\Models\GrupPost;
use App\Models\GrupLike;
use App\Models\GrupComment;
use App\Models\GrupImage;
use App\Models\User_grup;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Response;
use Session;
use View;


class GrupController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            $data = $request->all();

            $response = array();
            $response['code'] = 400;
            $rules = [
                'nama_grup'=>'required',
            ];
            $validator = Validator::make($data,$rules);

            if ($validator->fails()) {
                $response['code'] = 400;
                $response['message'] = implode(' ', $validator->errors()->all());
            }else{

                $grup = new Grup();

                $grup->id_user = Auth::user()->id;
                $grup->nama_grup = $request->input('nama_grup');
                $grup->status_grup = 'public';

                if ($grup->save()) {
                    $response['code'] = 200;

                    $user_grup = new User_grup();
                    $user_grup->id_user = Auth::user()->id;
                    $user_grup->id_groups = $grup->id_grup;
                    $user_grup->allow = '1';

                    $user_grup->save();
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

    public function fetch(Request $request){

        $wall_type = $request->input('wall_type'); // 0 => all posts, 1 => profile posts, 2 => group posts
        $list_type = $request->input('list_type'); // 0 => all, 1 => only text, 2 => only image
        $optional_id = $request->input('optional_id'); // Group ID, User ID, or empty
        $limit = intval($request->input('limit'));
        if (empty($limit)) $limit = 20;
        $post_min_id = intval($request->input('post_min_id')); // If not empty, post_id < post_min_id
        $post_max_id = intval($request->input('post_max_id')); // If not empty, post_id > post_max_id
        $div_location = $request->input('div_location');

        $user = Auth::user();

        $posts = GrupPost::with('user');

        if ($wall_type == 1){
            $posts = $posts->where('user_id', $optional_id)->where('group_id', 0);
        }else if ($wall_type == 2){

            $posts = $posts->where('group_post_id', $optional_id)->whereExists(function ($query) {
                $query->select(DB::raw(1))
                ->from('user_groups')
                ->whereRaw('posts_grup.user_id = user_groups.id_user');
            });
        }else{
            $posts = $posts->where(function($query) use ($user) {
                $query->whereIn('user_id', function ($q) use ($user) {
                    $q->select('id_groups')->from('user_groups')->where('id_user', $user->id)->where('allow', 1);
                });
                $query->orWhere('user_id', $user->id);
            })->where('group_post_id', $optional_id);
        }
        $posts = $posts->limit(20)->orderBy('id_post_grup', 'DESC')->get();

        if ($list_type == 1){
            $posts = $posts->where('has_image', 1);
        }else if ($list_type == 2) {
            $posts = $posts->where('has_image', 2);
        }
        if ($div_location == 'initialize'){
            $div_location = ['top', 'bottom'];
        }else{
            $div_location = [$div_location];
            if (count($posts) == 0) return "";
        }
        $comment_count = 2;

        return view('groups.widgets.wall_posts', compact('posts', 'user','comment_count','div_location', 'wall_type', 'list_type', 'optional_id', 'limit'));
    }

    public function single(Request $request, $id){

        $post = GrupPost::find($id);


        if (!$post) return redirect('/404');

        $user = Auth::user();
        $comment_count = 2000000;

        if ($post->group_id == 0) {
            $can_see = $post->user->canSeeProfile(Auth::id());
            if (!$can_see) return redirect('/404');
        }


        $update_all = $post->comments()->where('seen', 0)->update(['seen' => 1]);
        $update_all = $post->likes()->where('seen', 0)->update(['seen' => 1]);



        return view('post', compact('post', 'user', 'comment_count', 'can_see'));
    }

    public function delete(Request $request){

        $response = array();
        $response['code'] = 400;

        $post = GrupPost::find($request->input('id'));

        if ($post){
            if ($post->user_id == Auth::id()) {
                $delete = DB::table('post_grup_images')->where('post_grup_id','=',$request->input('id'))->delete();
                if ($post->delete()) {
                    $response['code'] = 200;
                }
            }
        }

        return Response::json($response);
    }


    public function like(Request $request){

        $user = Auth::user();

        $response = array();
        $response['code'] = 400;

        $post_grup = GrupPost::find($request->input('id'));

        if ($post_grup){
            $post_grup_like = GrupLike::where('grup_post_id', $post_grup->id_post_grup)->where('like_user', $user->id)->get()->first();

            if ($post_grup_like) { // UnLike
                if ($post_grup_like->like_user == $user->id) {
                    $deleted = DB::delete('delete from post_grup_likes where grup_post_id='.$post_grup_like->grup_post_id.' and like_user='.$post_grup_like->like_user);
                    if ($deleted){
                        $response['code'] = 200;
                        $response['type'] = 'unlike';
                    }
                }
            }else{
                // Like
                $post_grup_like = new GrupLike();
                $post_grup_like->grup_post_id = $post_grup->id_post_grup;
                $post_grup_like->like_user = $user->id;
                if ($post_grup_like->save()){
                    $response['code'] = 200;
                    $response['type'] = 'like';
                }
            }
            if ($response['code'] == 200){
                $response['like_count'] = $post_grup->getLikeCount();
            }
        }

        return Response::json($response);
    }


    public function comment(Request $request){

        $user = Auth::user();

        $response = array();
        $response['code'] = 400;

        $post = GrupPost::find($request->input('id'));
        $text = $request->input('comment');



        if ($post && !empty($text)){


            $comment = new GrupComment();
            $comment->grup_post_id = $post->id_post_grup;
            $comment->comment_grup_user_id = $user->id;
            $comment->comment = $text;
            if ($comment->save()){
                $response['code'] = 200;
                $html = View::make('groups.widgets.post_detail.single_comment', compact('post', 'comment'));
                $response['comment'] = $html->render();
                $html = View::make('groups.widgets.post_detail.comments_title', compact('post', 'comment'));
                $response['comments_title'] = $html->render();
            }

        }

        return Response::json($response);
    }

    public function deleteComment(Request $request){

        $response = array();
        $response['code'] = 400;

        $grup_comment = GrupComment::find($request->input('id'));


        if ($grup_comment){
            $post = $grup_comment->gruppost;
            if ($grup_comment->comment_grup_user_id == Auth::id() || $grup_comment->gruppost->user_id == Auth::id()) {
                if ($grup_comment->delete()) {
                    $response['code'] = 200;
                    $html = View::make('groups.widgets.post_detail.comments_title', compact('post'));
                    $response['comments_title'] = $html->render();
                }
            }
        }

        return Response::json($response);
    }


    public function likes(Request $request){

        $user = Auth::user();

        $response = array();
        $response['code'] = 400;

        $post = Post::find($request->input('id'));

        if ($post){
            $response['code'] = 200;
            $html = View::make('groups.widgets.post_detail.likes', compact('post'));
            $response['likes'] = $html->render();
        }

        return Response::json($response);
    }


    public function create(Request $request){

        $data = $request->all();
        $input = json_decode($data['data'], true);
        unset($data['data']);
        foreach ($input as $key => $value) $data[$key] = $value;


        $response = array();
        $response['code'] = 400;


        if ($request->hasFile('image')){
            $validator_data['image'] = 'required|mimes:jpeg,jpg,png,gif|max:2048';
        }else if($request->hasFile('file')){
            $validator_data['file'] = 'required|mimes:docx,docs,zip,rar,xls,xlsx,pdf,pptx,txt|max:10048';
        }else{
            $validator_data['content'] = 'required';
        }

        $validator = Validator::make($data, $validator_data);

        if ($validator->fails()) {
            $response['code'] = 400;
            $response['message'] = implode(' ', $validator->errors()->all());
        }else{

            $post = new GrupPost();
            $post->content = !empty($data['content'])?$data['content']:'';
            $post->group_post_id = $data['group_id'];
            $post->user_id = Auth::user()->id;

            $image_name = '';
            $file_name = "";

            if ($request->hasFile('image')) {
                $post->has_image = 1;
                $file = $request->file('image');

                $image_name = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
                if ($file->storeAs('public/uploads/posts', $image_name)) {
                    $process = true;
                } else {
                    $process = false;
                }
            }else if($request->hasFile('file')){
                $post->has_image = 1;
                $file = $request->file('file');
                $coba = $request->file;
                if (count($coba) != 14) {
                  for ($i=0; $i < count($coba); $i++) {
                    $def = $coba->getClientOriginalName()[$i].',';
                    $file_name .= $def;
                }
                $fpdf = substr($file_name, 0, -1);
            }else{
                $fpdf = $coba->getClientOriginalName();
          }

          if ($file->storeAs('public/uploads/posts', $fpdf)) {
            $process = true;
        } else {
            $process = false;
        }
    }else{
        $process = true;
    }

    if ($process){
        if ($post->save()) {
            if ($post->has_image == 1) {
                $post_image = new GrupImage();
                $post_image->image_path = $image_name;
                $post_image->file_path = $fpdf;
                $post_image->post_grup_id = $post->id_post_grup;
                if ($post_image->save()){
                    $response['code'] = 200;
                    // $response['message'] = dd($request->file);
                }else{
                    $response['code'] = 400;
                    $response['message'] = "Something went wrong!";
                    $post->delete();
                }
            }else{
                $response['code'] = 200;
            }
        }
    }else{ 
        $response['code'] = 400;
        $response['message'] = "Something went wrong!";
    }


}

return Response::json($response);

}


}