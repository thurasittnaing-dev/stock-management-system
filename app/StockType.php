<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockType extends Model
{
    //

    protected $fillable = [
        'name', 'statsu',
    ];


    public static function store_data($request)
    {
        StockType::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);
    }

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