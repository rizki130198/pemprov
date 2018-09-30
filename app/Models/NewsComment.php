<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsComment extends Model
{
   protected $table = 'news_comment';

    protected $primaryKey = 'id_comment';

	protected $dates = [
		'created_at',
		'updated_at'
	];

	public function user(){
		return $this->belongsTo('App\Models\User', 'id_user');
	}
}
