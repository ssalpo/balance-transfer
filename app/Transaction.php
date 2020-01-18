<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'sender_id', 'sender_name',
        'receiver_id', 'receiver_name',
        'amount'
    ];
}
