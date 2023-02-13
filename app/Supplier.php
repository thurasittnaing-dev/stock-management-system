<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $fillable = [
        'name', 'phone', 'status'
    ];

    public static function list_data($request)
    {
        $suppliers = new Supplier();
        $suppliers = $suppliers->orderBy('created_at', 'desc');
        return $suppliers;
    }


    public static function store_data($request)
    {
        Supplier::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);
    }

    public static function update_data($id, $request)
    {
        $supplier = Supplier::findorfail($id);
        $supplier->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);
    }
}