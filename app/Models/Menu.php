<?php

namespace App\Models;;

use Illuminate\Database\Eloquent\Model;
use App\Post;

class Menu extends Model
{
    protected $fillable = ['post_id','flag','parent_page'];

    public $timestamps = false;

     public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
