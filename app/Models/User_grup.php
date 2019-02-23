<?php


namespace App\Models;


use DB;
use Illuminate\Database\Eloquent\Model;

class User_grup extends Model
{

    protected $table = 'user_groups';

    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = 'id_user';
    
}