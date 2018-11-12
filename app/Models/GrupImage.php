<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupImage extends Model
{
    
    protected $table = 'post_grup_images';
     protected $primaryKey = 'post_grup_id'; 
    public $timestamps = false;


    public function getURL(){
        return url('storage/uploads/posts/'.$this->image_path);
    }
    public function getFile(){
        return url('storage/uploads/posts/'.$this->file_path);
    }

}
