<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DamageHistory extends Model
{
    //
    protected $fillable = [
        'withdrawer_id', 'stock_id', 'qty', 'remark', 'location_id'
    ];
}