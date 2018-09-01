<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

	protected $primaryKey = "id_events";
    public $timestamps = false;
    
    protected $dates = [
        'tanggal'
    ];
    private $comment_count = null;

    public function user(){
        return $this->belongsTo('App\Models\User', 'id_users');
    }
    public function checkOwner($id_users){
        if ($this->id_users == $id_users)return true;
        return false;
    }
    public function comments(){
        return $this->hasMany('App\Models\EventComment', 'id_events', 'id_events');
    }
    public function getCommentCount(){
        if ($this->comment_count == null){
            $this->comment_count = $this->comments()->count();
        }
        return $this->comment_count;
    }


}
