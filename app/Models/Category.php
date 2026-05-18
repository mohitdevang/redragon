<?php

namespace App\Models;;

use Illuminate\Database\Eloquent\Model;
use App\Post;

class Category extends Model
{
    protected $fillable = ['parent','title','slug','description','image','post_status'];

    public $timestamps = true;

    public function posts()
    {
        return $this->belongsToMany(Post::class,'post_category_relationships');

    }
}
