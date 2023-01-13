<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    protected $fillable = [
        'name', 'status',
    ];


    public static function store_data($request)
    {
        Category::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);
    }

    public static function update_data($category, $request)
    {
        $category->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);
    }
}