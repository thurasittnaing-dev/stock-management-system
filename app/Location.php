<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    // fillable
    protected $fillable = [
        'name',
        'status',
        'lat',
        'lng'
    ];

    // stocks orm
    public function stocks()
    {
        return $this->hasMany('App\Stock');
    }

    // store data
    public static function store_data($request)
    {
        Location::create($request->all());
    }

    // update data
    public static function update_data($location, $request)
    {
        $location->update([
            'name' => $request->name,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'status' => $request->status
        ]);
    }
}