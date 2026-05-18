<?php

namespace App\Models;;

use Illuminate\Database\Eloquent\Model;
use App\Post;

class Tag extends Model
{
    protected $fillable = ['title','slug','description'];

    public $timestamps = true;

    public function posts()
    {
        return $this->belongsToMany(Post::class,'post_tag_relationships');

    }

}
