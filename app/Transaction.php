<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['code_transaction', 'total_price', 'payment_status', 'snap_token', 'name', 'phone_number'];
}
