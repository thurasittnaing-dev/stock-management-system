<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockType extends Model
{
    //fillable
    protected $fillable = [
        'name', 'statsu',
    ];

    // stocks orm
    public function stocks()
    {
        return $this->hasMany('App\Stock');
    }

    // store data
    public static function store_data($request)
    {
        StockType::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);
    }

    // update data
    public static function update_data($id, $request)
    {
        $isDuplicate =  StockType::where('id', '!=', $id)->where('name', $request->name)->count() > 0 ? true : false;

        if ($isDuplicate) {
            return false;
        }


        $stockType = StockType::findorfail($id);
        return $stockType->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);
    }
}