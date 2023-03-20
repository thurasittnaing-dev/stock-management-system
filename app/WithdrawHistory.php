<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Withdrawer;
use Illuminate\Support\Facades\DB;
use App\Stock;

class WithdrawHistory extends Model
{
    //

    protected $fillable = [
        'withdrawer_id', 'qty', 'action_by', 'stock_id', 'date', 'withdraw_type', 'status', 'remark'
    ];

    public static function list_data($request)
    {
        $withdraw_history = new WithdrawHistory();
        $withdraw_history = $withdraw_history->select('withdraw_histories.*', 'brands.name AS brand_name', 'categories.name AS category_name', 'stock_types.name as stock_type_name', 'withdrawers.name AS withdrawer_name', 'stocks.name AS stock_name', 'users.name AS approve_by', 'stocks.img AS stock_img')
            ->leftjoin('stocks', 'stocks.id', 'withdraw_histories.stock_id')
            ->leftjoin('withdrawers', 'withdrawers.id', 'withdraw_histories.withdrawer_id')
            ->leftjoin('stock_types', 'stock_types.id', 'stocks.stock_type_id')
            ->leftjoin('brands', 'brands.id', 'stocks.brand_id')
            ->leftjoin('users', 'users.id', '=', 'withdraw_histories.action_by')
            ->leftjoin('categories', 'categories.id', 'stocks.category_id');

        // keyword
        if (!empty($request->keyword)) {
            $withdraw_history = $withdraw_history->where('stocks.name', "LIKE", '%' . $request->keyword . '%');
        }

        // brand
        if (!empty($request->brand)) {
            $withdraw_history = $withdraw_history->where('stocks.brand_id', $request->brand);
        }

        //stocktype
        if (!empty($request->stock_type_id)) {
            $withdraw_history = $withdraw_history->where('stocks.stock_type_id', $request->stock_type_id);
        }

        //category
        if (!empty($request->category)) {
            $withdraw_history = $withdraw_history->where('stocks.category_id', $request->category);
        }

        return $withdraw_history;
    }

    //  store data
    public static function store_data($request)
    {

        $stock = Stock::find($request->stock_id);

        if ($stock->qty < $request->qty) {
            return redirect()->route('stock.index')->with('error', 'Stock quantity not enough');
        }


        try {
            DB::beginTransaction();
            $remainQty = $stock->qty - $request->qty;

            $stock = $stock->update([
                'qty' => $remainQty,
            ]);

            // Handle Withdrawer  
            if (!is_numeric($request->withdrawer_id)) {

                $withdrawer = new Withdrawer();
                $withdrawer = $withdrawer->where('name', $request->withdrawer_id);

                //  check already exits
                if ($withdrawer->count() > 0) {
                    $withdrawerId = $withdrawer->first()->id;
                } else {
                    $withdrawer = Withdrawer::create([
                        'name' => $request->withdrawer_id,
                    ]);
                    $withdrawerId = $withdrawer->id;
                }
            }

            // check status 
            $status = 0;
            if ($request->withdraw_type == "permanent") {
                $status = 1;
            }

            WithdrawHistory::create([
                'withdrawer_id' => $withdrawerId ?? $request->withdrawer_id,
                'stock_id' => $request->stock_id,
                'qty' => $request->qty,
                'withdraw_type' => $request->withdraw_type,
                'date' => date('Y-m-d', strtotime($request->date)),
                'action_by' => $request->actionby,
                'remark' => $request->remark,
                'status' => $status,
            ]);



            DB::commit();

            // Success message
            return true;
        } catch (\Exception $e) {
            DB::rollback();

            // Error message
            dd($e->getMessage());
        }
    }
}