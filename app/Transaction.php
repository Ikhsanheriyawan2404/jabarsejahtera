<?php

namespace App;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use Uuid;

    protected $fillable = ['code_transaction', 'donation_id','nominal', 'payment_status', 'snap_token', 'name', 'phone_number', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    // public function setNominalAttribute($nominal) {
    //     $this->attributes['nominal'] = (int)$nominal;
    // }

    public function getNominalAttribute($value)
    {
        return (int)$value;
    }
}
