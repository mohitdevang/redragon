<?php

namespace App\Models;;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    protected $fillable = ['title','description','content'];
    public $timestamps = false;
}
