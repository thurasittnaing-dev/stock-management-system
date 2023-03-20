<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdrawer extends Model
{
    //

    protected $fillable = [
        'name', 'phone', 'status'
    ];
}