<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupLike extends Model
{
    
    protected $table = 'post_grup_likes';

    public $incrementing = false;

    protected $primaryKey = ['grup_post_id', 'like_user'];

    public function grup(){
        return $this->belongsTo('App\Models\Post', 'grup_post_id');
    }


    public function user(){
        return $this->belongsTo('App\Models\User', 'like_user');
    }
}
 