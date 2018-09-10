<?php
/**
 * Created by lvntayn
 * Date: 03/06/2017
 * Time: 22:45
 */

namespace App\Models;


use DB;
use Illuminate\Database\Eloquent\Model;

class Grup extends Model
{

	protected $table = 'grup';

	protected $primaryKey = "id_grup";
	public $timestamps = false;

	public function user(){
		return $this->belongsTo('App\Models\User_grup', 'id_grup');
	}
	public function getPhoto($w = null, $h = null){
        if (!empty($this->profile_path)){
            $path = 'storage/uploads/profile_photos/'.$this->profile_path;
        }else {
            $path = "images/profile-picture.png";
        }
        if ($w == null && $h == null){
            return url('/'.$path);
        }
        $image = '/resizer.php?';
        if ($w > -1) $image .= '&w='.$w;
        if ($h > -1) $image .= '&h='.$h;
        $image .= '&zc=1';
        $image .= '&src='.$path;
        return url($image);
    }
    public function getCover($w = null, $h = null){
        if (!empty($this->cover_path)){
            $path = 'storage/uploads/covers/'.$this->cover_path;
        }else {
            return "";
        }
        if ($w == null && $h == null){
            return url('/'.$path);
        }
        $image = '/resizer.php?';
        if ($w > -1) $image .= '&w='.$w;
        if ($h > -1) $image .= '&h='.$h;
        $image .= '&zc=1';
        $image .= '&src='.$path;
        return url($image);
    }
} 