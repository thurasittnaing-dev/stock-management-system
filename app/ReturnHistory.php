<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnHistory extends Model
{
    //
    protected $fillable = [
        'withdraw_history_id', 'qty', 'date', 'is_final'
    ];
}