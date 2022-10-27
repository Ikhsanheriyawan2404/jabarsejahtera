<?php

namespace App;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = ['id','phone_number', 'image', 'security_question'];

    public function getImageAttribute($value)
    {
        return URL::to('/') . '/storage/' . $value;
    }
}
