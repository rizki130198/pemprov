<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class FormPengajuan extends Model
{

    protected $table = 'pengajuan_spj';

    protected $primaryKey = 'id_pengajuan';

    protected $dates = [
        'created_at'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'id_user');
    }
}