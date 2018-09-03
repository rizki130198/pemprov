<?php
/**
 * Created by lvntayn
 * Date: 03/06/2017
 * Time: 22:45
 */

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