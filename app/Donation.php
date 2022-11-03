<?php

namespace App;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = ['title', 'image', 'description', 'total_budget', 'category', 'location'];
    protected $appends = ['total_collected'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    protected $hidden = ['updated_at'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    public function getTotalCollectedAttribute()
    {
        return (int)Transaction::where('payment_status', 2)->where('donation_id', $this->id)->sum('nominal');
    }

    public function getImagePathAttribute()
    {
        return URL::to('/') . '/storage/' . $this->image;
    }
}
