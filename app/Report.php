<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['name', 'description', 'nominal', 'donation_id', 'date'];

    protected $casts = [
        'nominal' => 'integer'
    ];

    public function donation()
    {
        return $this->belongsTo(Report::class);
    }
}
