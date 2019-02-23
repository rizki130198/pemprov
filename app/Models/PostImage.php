<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{

    protected $table = 'post_images';

    public $timestamps = false;


    public function getURL(){
        return url('storage/uploads/posts/'.$this->image_path);
    }
    public function getFile(){
        return url('storage/uploads/posts/'.$this->file_path);
    }
}