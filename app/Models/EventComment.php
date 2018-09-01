<?php

namespace App\Models;


use DB;
use Illuminate\Database\Eloquent\Model;

class EventComment extends Model
{
   protected $table = 'event_coment';

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'id_users');
    }

    public function post(){
        return $this->belongsTo('App\Models\Event', 'id_events');
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
