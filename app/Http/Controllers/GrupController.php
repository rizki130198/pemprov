<?php
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Library\sHelper;
use App\Models\Grup;
use App\Models\GrupPost;
use App\Models\GrupLike;
use App\Models\GrupComment;
use App\Models\GrupImage;
use App\Models\User_grup;
use App\Models\NotifGrup;
use App\Models\User;
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

    public $group;
    
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
                    $user_grup->jabatan_grup = 'admin';
                    $user_grup->allow = '1';
                    $user_grup->seen = '1';

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
        $post_min_id = intval($request->input('postgrup_min_id')); // If not empty, post_id < post_min_id
        $post_max_id = intval($request->input('postgrup_max_id')); // If not empty, post_id > post_max_id
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
            $posts = GrupPost::where('group_post_id', $optional_id);
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
        $user_list = $user->messagePeopleList();
        $comment_count = 2000000;

        if ($post->group_id == 0) {
            $can_see = $post->user->canSeeProfile(Auth::id());
            if (!$can_see) return redirect('/404');
        }


        $update_all = $post->comments()->where('seen', 0)->update(['seen' => 1]);
        $update_all = $post->likes()->where('seen', 0)->update(['seen' => 1]);



        return view('groups.post', compact('post', 'user', 'comment_count', 'can_see','user_list'));
    }

    public function singlepost(Request $request, $id){

        // return dd($id);

        $post = GrupPost::find($id);

        if (!$post) return redirect('/404');

        $user = Auth::user();
        $user_list = $user->messagePeopleList();
        $comment_count = 2000000;

        if ($post->group_id == 0) {
            $can_see = $post->user->canSeeProfile(Auth::id());
            if (!$can_see) return redirect('/404');
        }
        $notif = NotifGrup::where('id_user',Auth::user()->id)->where('id_post',$id)->get()->first();
        if ($notif == NULL) {
            $insert = new NotifGrup();
            $insert->id_grup = $post->group_post_id;
            $insert->id_post = $id;
            $insert->id_user = Auth::user()->id;
            $insert->seen = 1;
            $insert->save();
        }
        return view('groups.post', compact('post', 'user', 'comment_count', 'can_see','user_list'));
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

        $post = GrupPost::find($request->input('id'));

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
            $validator_data['image.*'] = 'required|mimes:jpg,png,jpeg';
        }else if($request->hasFile('files')){
            $validator_data['files.*'] = 'required|mimes:xls,xlsx,ppt,pptx,zip,rar,txt,docx,doc';
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

            $imageupload = '';
            $fileupload = '';
            $originaupload = '';

            if ($request->hasFile('image')) {
                $post->has_image = 1;
                $image = $request->file('image');
                if (count($image) != 14) {
                  for ($i=0; $i < count($image); $i++) {
                    $dataimage = md5(uniqid() . time()) . '.' . $image[$i]->getClientOriginalExtension().',';
                    $originalimage = $image[$i]->getClientOriginalName().',';
                    $imagestore = str_replace(',', '', $dataimage);
                    $image[$i]->storeAs('public/uploads/posts', $imagestore);
                    $imageupload .= $dataimage;
                    $originaupload .= $originalimage;
                }
                $image_path = substr($imageupload, 0, -1);
                $image_original = substr($originaupload, 0, -1);
            }else{
              $image_path = $image->getClientOriginalName();
          }
          $process = true;
      }else if($request->hasFile('files')){
         $post->has_image = 1;
         $file = $request->file('files');
         if (count($file) != 14) {
          for ($i=0; $i < count($file); $i++) {
            $datafile = md5(uniqid() . time()) . '.' . $file[$i]->getClientOriginalExtension().',';
            $originalfile = $file[$i]->getClientOriginalName().',';
            $filestore = str_replace(',', '', $datafile);
            $fileupload .= $datafile;
            $originaupload .= $originalfile;

            $file[$i]->storeAs('public/uploads/posts', $filestore);
        }
        $file_path = substr($fileupload, 0, -1);
        $originalcontent = substr($originaupload, 0, -1);
    }else{
        $file_path = $file->getClientOriginalName();
    }
    $process = true;
}else{
    $process = true;
}

if ($process){
    if ($post->save()) {
        if ($post->has_image == 1) {
            $post_image = new GrupImage();
            if ($request->file('image') != NULL) {
                $post_image->image_path = $image_path;
                $post_image->original_name = $image_original;
                $post_image->id_user = Auth::user()->id;
            }else if($request->file('files') !=NULL){
                $post_image->file_path = $file_path;
                $post_image->original_name = $originalcontent;
                $post_image->id_user = Auth::user()->id;
            }
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
            sHelper::notifications($data['group_id']);

        }
    }
}else{ 
    $response['code'] = 400;
    $response['message'] = "Something went wrong!";
}
}
return Response::json($response);

}
public function tambah(Request $request,$grup_id)
{

    $s = $request->input('cari');

    $query = User::where('id', '!=', Auth::user()->id)->whereNotExists(function ($query) use($grup_id) {
        $query->select(DB::raw(1))
        ->from('user_groups')
        ->whereRaw('users.id = user_groups.id_user and user_groups.id_groups = '. $grup_id);
    })->where('users.username','LIKE','%'.$s.'%')->limit(5)->get();
    
    if (count($query) == 0){ ?>
        <div>Tidak ada data</div>
    <?php }else{ ?>

        <?php foreach ($query as $key ): ?>
            <a href="javascript:;" onclick="gabung('<?=$grup_id?>','<?= $key->id ?>','#people-listed-<?=$grup_id?>','btn-sm')"><div><?= $key->username ?></div></a>
        <?php endforeach ?>

    <?php } 
}
public function gabung(Request $request){

    $response = array();
    $response['code'] = 400;

    $id_grup = $request->input('idgrup');
    $id_user = $request->input('iduser');
    $element = $request->input('element');
    $size = $request->input('size');



    $grup = Grup::find($id_grup);
    $user = User::find($id_user);



    if ($grup && $user){

        $relation = User_grup::where('id_user',$id_user)->where('id_groups',$id_grup)->get()->first();

        if ($relation){
            if ($relation->delete()){
                $response['code'] = 200;
                $response['refresh'] = 1;
            }
        }else{
            $relation = new User_grup();
            $relation->id_user = $id_user;
            $relation->id_groups = $id_grup;
            $relation->allow = 1;
            $relation->seen = 0;
            if ($relation->save()){
                $response['code'] = 200;
                $response['refresh'] = 1;
            }
        }

        if ($response['code'] == 200){
            $response['button'] = sHelper::grupButton($id_grup, $id_user, $element, $size);
        }
    }


    return Response::json($response);

}


}