<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //

    protected $fillable = [
        'name', 'status'
    ];

    public function stocks()
    {
        return $this->hasMany('App\Stock');
    }

    public static function store_data($request)
    {
        Brand::create($request->all());
    }

    public static function update_data($brand, $request)
    {
        $brand->update([
            'name' => $request->name,
            'status' => $request->status
        ]);
    }
}