<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnHistory extends Model
{
    //
    protected $fillable = [
        'withdraw_history_id', 'qty', 'date', 'is_final', 'is_damage'
    ];


    // list data
    public static function list_data($request)
    {
        $data = new ReturnHistory();
        $data = $data->select('return_histories.*', 'brands.name AS brand_name', 'categories.name AS category_name', 'stock_types.name as stock_type_name', 'withdrawers.name AS withdrawer_name', 'withdrawers.id AS withdrawer_id', 'stocks.name AS stock_name', 'stocks.id AS stock_id', 'users.name AS approve_by', 'stocks.img AS stock_img')
            ->leftjoin('withdraw_histories', 'withdraw_histories.id', 'return_histories.withdraw_history_id')
            ->leftjoin('stocks', 'stocks.id', 'withdraw_histories.stock_id')
            ->leftjoin('withdrawers', 'withdrawers.id', 'withdraw_histories.withdrawer_id')
            ->leftjoin('stock_types', 'stock_types.id', 'stocks.stock_type_id')
            ->leftjoin('brands', 'brands.id', 'stocks.brand_id')
            ->leftjoin('users', 'users.id', '=', 'withdraw_histories.action_by')
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
            $data = $data->where('withdraw_histories.withdrawer_id', $request->withdrawer_id);
        }

        // is final
        if ($request->is_final != '') {
            $data = $data->where('return_histories.is_final', $request->is_final);
        }

        // is damage
        if ($request->is_damage != '') {
            $data = $data->where('return_histories.is_damage', $request->is_damage);
        }

        // date range
        if (!empty($request->from_date) and !empty($request->to_date)) {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $to_date = date('Y-m-d', strtotime($request->to_date));
            $data = $data->whereBetween('return_histories.date', [$from_date, $to_date]);
        }

        // qty range
        if (!empty($request->qty_from) and !empty($request->qty_to)) {
            $data = $data->whereBetween('return_histories.qty', [$request->qty_from, $request->qty_to]);
        }

        return $data;
    }
}