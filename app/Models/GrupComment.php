<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupComment extends Model
{
	protected $table = 'grup_post_comments';

    protected $primaryKey = 'id';

	protected $dates = [
		'created_at',
		'updated_at'
	];

	public function user(){
		return $this->belongsTo('App\Models\User', 'comment_grup_user_id');
	}

	public function gruppost(){
		return $this->belongsTo('App\Models\GrupPost', 'grup_post_id');
	}

}
