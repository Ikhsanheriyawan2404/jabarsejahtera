<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = ['title', 'image', 'description', 'total_budget', 'category'];
    protected $appends = ['total_collected'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    public function getTotalCollectedAttribute()
    {
        return Transaction::where('id', $this->id)->sum('nominal');
    }
}
