<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{

    protected $table = 'saldo';

    public $incrementing = false;

    protected $primaryKey = 'id_saldo';

    protected $dates = [
        'updated_at'
    ];

}