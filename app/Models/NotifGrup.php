<?php

namespace App\Models;


use DB;
use Illuminate\Database\Eloquent\Model;

class NotifGrup extends Model
{

	protected $table = 'notif_grup';

	protected $primaryKey = "id_notif";
	public $timestamps = false;
}
