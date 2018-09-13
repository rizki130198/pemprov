<?php
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostImage;
use App\Models\PostLike;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Response;
use Session;
use View;


class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
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

        $posts = Post::with('user');

        if ($wall_type == 1){
            $posts = $posts->where('user_id', $optional_id)->where('group_id', 0);
        }else if ($wall_type == 2){

            $city = $user->location->city;

            $posts = $posts->where('group_id', $optional_id)->whereExists(function ($query) use($city) {
                $query->select(DB::raw(1))
                ->from('user_locations')
                ->whereRaw('posts.user_id = user_locations.user_id and user_locations.city_id = '.$city->id);
            });
        }else{
            $posts = $posts->where(function($query) use ($user) {
                $query->whereIn('user_id', function ($q) use ($user) {
                    $q->select('following_user_id')->from('user_following')->where('follower_user_id', $user->id)->where('allow', 1);
                });
                $query->orWhere('user_id', $user->id);
            })->where('group_id', 0);
        }

        if ($list_type == 1){
            $posts = $posts->where('has_image', 1);
        }else if ($list_type == 2) {
            $posts = $posts->where('has_image', 2);
        }

        if ($post_min_id > -1){
            $posts = $posts->where('id', '<', $post_min_id);
        }else if ($post_max_id > -1){
            $posts = $posts->where('id', '>', $post_max_id);
        }

        $posts = $posts->limit($limit)->orderBy('id', 'DESC')->get();




        if ($div_location == 'initialize'){
            $div_location = ['top', 'bottom'];
        }else{
            $div_location = [$div_location];
            if (count($posts) == 0) return "";
        }

        $comment_count = 2;

        return view('widgets.wall_posts', compact('posts', 'user', 'wall_type', 'list_type', 'optional_id', 'limit', 'div_location', 'comment_count'));
    }

    public function single(Request $request, $id){

        $post = Post::find($id);


        if (!$post) return redirect('/404');

        $user = Auth::user();

        $user_list = $user->messagePeopleList();
        $comment_count = 2000000;

        if ($post->group_id == 0) {
            $can_see = $post->user->canSeeProfile(Auth::id());
            if (!$can_see) return redirect('/404');
        }


        $update_all = $post->comments()->where('seen', 0)->update(['seen' => 1]);
        $update_all = $post->likes()->where('seen', 0)->update(['seen' => 1]);



        return view('post', compact('post', 'user', 'comment_count', 'can_see','user_list'));
    }

    public function delete(Request $request){

        $response = array();
        $response['code'] = 400;

        $post = Post::find($request->input('id'));

        if ($post){
            if ($post->user_id == Auth::id()) {
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

        $post = Post::find($request->input('id'));

        if ($post){
            $post_like = PostLike::where('post_id', $post->id)->where('like_user_id', $user->id)->get()->first();

            if ($post_like) { // UnLike
                if ($post_like->like_user_id == $user->id) {
                    $deleted = DB::delete('delete from post_likes where post_id='.$post_like->post_id.' and like_user_id='.$post_like->like_user_id);
                    if ($deleted){
                        $response['code'] = 200;
                        $response['type'] = 'unlike';
                    }
                }
            }else{
                // Like
                $post_like = new PostLike();
                $post_like->post_id = $post->id;
                $post_like->like_user_id = $user->id;
                if ($post_like->save()){
                    $response['code'] = 200;
                    $response['type'] = 'like';
                }
            }
            if ($response['code'] == 200){
                $response['like_count'] = $post->getLikeCount();
            }
        }

        return Response::json($response);
    }


    public function comment(Request $request){

        $user = Auth::user();

        $response = array();
        $response['code'] = 400;

        $post = Post::find($request->input('id'));
        $text = $request->input('comment');



        if ($post && !empty($text)){


            $comment = new PostComment();
            $comment->post_id = $post->id;
            $comment->comment_user_id = $user->id;
            $comment->comment = $text;
            if ($comment->save()){
                $response['code'] = 200;
                $html = View::make('widgets.post_detail.single_comment', compact('post', 'comment'));
                $response['comment'] = $html->render();
                $html = View::make('widgets.post_detail.comments_title', compact('post', 'comment'));
                $response['comments_title'] = $html->render();
            }

        }

        return Response::json($response);
    }

    public function deleteComment(Request $request){

        $response = array();
        $response['code'] = 400;

        $post_comment = PostComment::find($request->input('id'));


        if ($post_comment){
            $post = $post_comment->post;
            if ($post_comment->comment_user_id == Auth::id() || $post_comment->post->user_id == Auth::id()) {
                if ($post_comment->delete()) {
                    $response['code'] = 200;
                    $html = View::make('widgets.post_detail.comments_title', compact('post'));
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
            $html = View::make('widgets.post_detail.likes', compact('post'));
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
            $validator_data['image.*'] = 'required|mimes:jpeg,jpg,png,gif';
        }else if($request->hasFile('file')){
            $validator_data['file.*'] = 'required|mimes:xls,xlsx,ppt,pptx,zip,rar,txt,docx,doc';
        }else{
            $validator_data['content'] = 'required';
        }

        $validator = Validator::make($data, $validator_data);

        if ($validator->fails()) {
            $response['code'] = 400;
            $response['message'] = implode(' ', $validator->errors()->all());
        }else{

            $post = new Post();
            $post->content = !empty($data['content'])?$data['content']:'';
            $post->group_id = $data['group_id'];
            $post->user_id = Auth::user()->id;

            $imageupload = '';
            $fileupload = '';

            if ($request->hasFile('image')) {
                $post->has_image = 1;
                $image = $request->file('image');
                if (count($image) != 14) {
                  for ($i=0; $i < count($image); $i++) {
                    $dataimage = md5(uniqid() . time()) . '.' . $image[$i]->getClientOriginalExtension().',';
                    $imagestore = str_replace(',', '', $dataimage);
                    $image[$i]->storeAs('public/uploads/posts', $imagestore);
                    $imageupload .= $dataimage;

                }
                $image_path = substr($imageupload, 0, -1);
            }else{
              $image_path = '';
          }
          $process = true;
      }else if($request->hasFile('file')){
         $post->has_image = 1;
         $file = $request->file('file');
         if (count($file) != 14) {
          for ($i=0; $i < count($file); $i++) {
            $datafile = md5(uniqid() . time()) . '.' . $file[$i]->getClientOriginalExtension().',';
            $filestore = str_replace(',', '', $datafile);
            $fileupload .= $datafile;

            $file[$i]->storeAs('public/uploads/posts', $filestore);
        }
        $database = substr($fileupload, 0, -1);
    }else{
        $database = '';
    }
    $process = true;
}else{
    $process = true;
}

if ($process){
    if ($post->save()) {
        if ($post->has_image == 1) {
            $post_image = new PostImage();
            if ($request->hasFile('file')) {
                $post_image->file_path = $database;
            }else if($request->hasFile('image')){
                $post_image->image_path = $image_path;
            }
            $post_image->post_id = $post->id;
            if ($post_image->save()){
                $response['code'] = 200;
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