<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

	protected $primaryKey = "id_events";
    public $timestamps = false;

    public function comments(){
        return $this->hasMany('App\Models\EventComment', 'id_events', 'id_events');
    }

}
