<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDirectMessage;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;
use Response;
use View;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $response = array();
        $response['code'] = 200;

        $user = Auth::user();

        $user_list = [];

        $data = User::all();
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
        $file = FileUpload::all();
        return view('file.file', compact('user','data','user_list','file'));
    }
    public function Uploadfile(Request $request)
    {
            $response = array();
            $response['code'] = 400;
            $data = $request->all();
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
            if ($request->hasFile('myfile')){
                $validator_data['myfile.*'] = 'required|mimes:doc,docx,psd,xls,xlsx,jpg,gif,jpeg,png,pdf,rar,zip';
            } 
            $validator = Validator::make($data, $validator_data);
            if ($validator->fails()) {
                $response['code'] = 400;
                $response['message'] = implode(' ', $validator->errors()->all());
            }else{
                $imageupload = '';
                $extensinya = '';
                $originaupload = '';
                if ($request->hasFile('myfile')) {
                    $image = $request->file('myfile');
                    if (count($image) != 14) {
                      for ($i=0; $i < count($image); $i++) {
                        $dataimage = md5(uniqid() . time()) . '.' . $image[$i]->getClientOriginalExtension().',';
                        $extensi_file = $image[$i]->getClientOriginalExtension().',';
                        $originalimage = $image[$i]->getClientOriginalName().',';
                        $imagestore = str_replace(',', '', $dataimage);
                        $image[$i]->storeAs('public/uploads/fileupload', $imagestore);
                        $imageupload .= $dataimage;
                        $originaupload .= $originalimage;
                        $extensinya .= $extensi_file;
                    }
                    $image_path = substr($imageupload, 0, -1);
                    $path_extensi = substr($extensinya, 0, -1);
                    $image_original = substr($originaupload, 0, -1);
                }else{
                    $image_path = '';
                }
            }
            $uploadfile = new FileUpload;
            $uploadfile->id_user = $user->id;
            $uploadfile->encrypt = $image_path;
            $uploadfile->filenya = $image_original;
            $uploadfile->jenis_file = $path_extensi;
            if($uploadfile->save()){
                $response['code'] = 200;
                $file = FileUpload::all();
                $html = View::make('file.newfile', compact('user', 'friend', 'message_list','file'));
                $response['html'] = $html->render();
            }else{
                $response['code'] = 400;
                $response['message'] = 'Data error silakan hubungi tim terkait';
            }
        }
        return Response::json($response);
    }
    public function GetFile()
    {
        $response = array();
        $response['code'] = 200;
        $file = FileUpload::all();
        $html = View::make('file.newfile', compact('file'));
        $response['html'] = $html->render();
        return Response::json($response);
    }
    public function Download($string)
    {
      return response()->download(storage_path("app/public/uploads/fileupload/".$string));
    }
}
