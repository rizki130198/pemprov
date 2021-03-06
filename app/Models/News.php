<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'post_news';

    protected $primaryKey = 'id';

	protected $dates = [
		'created_at',
		'updated_at',
		'tanggal',
	];

	public function user(){
		return $this->belongsTo('App\Models\User', 'user_id','id');
	}
	public function comments(){
        return $this->hasMany('App\Models\News_Comment', 'id','id_news');
    }

}
 