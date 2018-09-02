<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupPost extends Model
{
	protected $table = 'posts_grup';

	protected $primaryKey = "id_post_grup";
	
     protected $dates = [
        'created_at',
        'updated_at'
    ];
	public function userGrup(){ 
		return $this->belongsTo('App\Models\User_grup', 'id_post_grup','id_user');
	}
	public function user(){ 
		return $this->belongsTo('App\Models\User', 'id_user','id');
	}
	public function images(){
		return $this->hasMany('App\Models\GrupImage', 'post_grup_id', 'id_post_grup');
	}

	public function comments(){
		return $this->hasMany('App\Models\GrupComment', 'grup_post_id', 'id_post_grup');
	}

	public function likes(){
		return $this->hasMany('App\Models\GrupLike', 'grup_post_id', 'id_post_grup');
	}

	public function getLikeCount(){
		if ($this->like_count == null){
			$this->like_count = $this->likes()->count();
		}
		return $this->like_count;
	}

	public function getCommentCount(){
		if ($this->comment_count == null){
			$this->comment_count = $this->comments()->count();
		}
		return $this->comment_count;
	}

	public function checkOwner($user_id){
		if ($this->user_id == $user_id)return true;
		return false;
	}

	public function hasImage(){
		return $this->has_image;
	}

	public function checkLike($user_id){
		if ($this->likes()->where('like_user', $user_id)->get()->first()){
			return true;
		}else{
			return false;
		}
	}
}
