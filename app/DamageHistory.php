<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DamageHistory extends Model
{
    //
    protected $fillable = [
        'withdrawer_id', 'stock_id', 'qty', 'remark', 'location_id'
    ];

    // list data
    public static function list_data($request)
    {
        $data = new DamageHistory();
        $data = $data->select('damage_histories.*', 'brands.name AS brand_name', 'locations.name AS location_name', 'categories.name AS category_name', 'stock_types.name as stock_type_name', 'withdrawers.name AS withdrawer_name', 'withdrawers.id AS withdrawer_id', 'stocks.name AS stock_name', 'stocks.id AS stock_id', 'stocks.img AS stock_img')
            ->leftjoin('stocks', 'stocks.id', 'damage_histories.stock_id')
            ->leftjoin('withdrawers', 'withdrawers.id', 'damage_histories.withdrawer_id')
            ->leftjoin('stock_types', 'stock_types.id', 'stocks.stock_type_id')
            ->leftjoin('brands', 'brands.id', 'stocks.brand_id')
            ->leftjoin('locations', 'locations.id', 'damage_histories.location_id')
            ->leftjoin('categories', 'categories.id', 'stocks.category_id');

        // keyword
        if (!empty($request->keyword)) {
            $data = $data->where('stocks.name', "LIKE", '%' . $request->keyword . '%');
        }

        // brand
        if (!empty($request->brand)) {
            $data = $data->where('stocks.brand_id', $request->brand);
        }

        //stocktype
        if (!empty($request->stock_type_id)) {
            $data = $data->where('stocks.stock_type_id', $request->stock_type_id);
        }

        //category
        if (!empty($request->category)) {
            $data = $data->where('stocks.category_id', $request->category);
        }

        // withdrawer
        if (!empty($request->withdrawer_id)) {
            $data = $data->where('damage_histories.withdrawer_id', $request->withdrawer_id);
        }

        // location
        if (!empty($request->location)) {
            $data = $data->where('damage_histories.location_id', $request->location);
        }

        // date range
        if (!empty($request->from_date) and !empty($request->to_date)) {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $to_date = date('Y-m-d', strtotime($request->to_date));
            $data = $data->whereBetween('damage_histories.created_at', [$from_date, $to_date]);
        }

        // qty range
        if (!empty($request->qty_from) and !empty($request->qty_to)) {
            $data = $data->whereBetween('damage_histories.qty', [$request->qty_from, $request->qty_to]);
        }

        return $data;
    }
}