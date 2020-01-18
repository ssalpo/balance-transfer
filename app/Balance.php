<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'balance';

    protected $fillable = [
        'user_id', 'amount'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
