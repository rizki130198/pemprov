<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CekCommentGrup extends Model
{
	protected $table = 'ceks_notif_grup';

	protected $primaryKey = 'id_cek';

	
	public $timestamps = false;

	public function user(){
		return $this->belongsTo('App\Models\User', 'id_users','id');
	}
}
