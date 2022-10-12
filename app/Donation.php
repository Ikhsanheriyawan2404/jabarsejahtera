<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = ['title', 'slug', 'image', 'description', 'type'];
}
