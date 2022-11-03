<?php

namespace App;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = ['id','phone_number', 'image', 'security_question'];

    // public function getTakeImageAttribute()
    // {
    //     return $this->image;
    // }
    public function getImagePathAttribute()
    {
        return URL::to('/') . '/storage/' . $this->image;
    }

}
