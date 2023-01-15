<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'status'
    ];

    public static function store_data($request)
    {
        Location::create($request->all());
    }

    public static function update_data($location, $request)
    {
        $location->update([
            'name' => $request->name,
            'status' => $request->status
        ]);
    }
}
