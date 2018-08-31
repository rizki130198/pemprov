<?php
/**
 * Created by lvntayn
 * Date: 03/06/2017
 * Time: 22:45
 */

namespace App\Models;


use DB;
use Illuminate\Database\Eloquent\Model;

class Grup extends Model
{

    protected $table = 'grup';

	protected $primaryKey = "id_grup";
    public $timestamps = false;

    public function user_grup(){
        return $this->belongsTo('App\Models\User_grup', 'id_grup');
    }

}