<?php

namespace App\Models;;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = ['name','email','status'];
    public $timestamps = true;
}
