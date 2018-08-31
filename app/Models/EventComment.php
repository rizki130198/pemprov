<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventComment extends Model
{
   protected $table = 'event_comment';

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

}
