<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History_spj extends Model
{
    protected $table = 'history_spj';

    protected $primaryKey = 'id_spj';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'id_user');
    }
    public function spj()
    {
        return $this->belongsTo('App\Models\Formpengajuan', 'id_spj');
    }
}
 