<?php

namespace App;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'description', 'organizer', 'date', 'location', 'image'];

    public function getImageAttribute($value)
    {
        return URL::to('/') . '/storage/' . $value;
    }
}
