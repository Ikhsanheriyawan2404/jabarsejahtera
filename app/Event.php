<?php

namespace App;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'description', 'organizer', 'date', 'location', 'image'];

    protected $casts = [
        'date' => 'datetime:d-m-Y'
    ];

    protected $hidden = ['updated_at', 'created_at'];

    public function getImageAttribute($value)
    {
        return URL::to('/') . '/storage/' . $value;
    }
}
