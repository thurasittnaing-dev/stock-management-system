<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Stock;

class PurchaseHistory extends Model
{
    protected $fillable = [
        'supplier_id', 'stock_id', 'qty', 'price', 'currency', 'remark', 'purchase_date'
    ];

    // List Data
    public static function list_data($request)
    {
        $purchase_history = new PurchaseHistory();
        $purchase_history = $purchase_history->select('purchase_histories.*', 'suppliers.name AS supplier_name', 'stocks.name AS stock_name', 'stocks.img AS stock_img')
            ->leftjoin('stocks', 'stocks.id', 'purchase_histories.stock_id')
            ->leftjoin('suppliers', 'suppliers.id', 'purchase_histories.supplier_id')
            ->orderBy('purchase_histories.purchase_date', "DESC");

        return $purchase_history;
    }

    // Store Data
    public static function store_data($request)
    {
        DB::beginTransaction();

        try {

            $stock = Stock::findorfail($request->stock_id);

            PurchaseHistory::create([
                'price' => $request->price,
                'stock_id' => $request->stock_id,
                'qty' => $request->qty,
                'currency' => $request->currency,
                'purchase_date' => date('Y-m-d', strtotime($request->purchase_date)),
                'supplier_id' => $request->supplier_id,
                'remark' => $request->remark,
            ]);


            $qty = $stock->qty += $request->qty;

            $stock->update([
                'qty' => (int) $qty
            ]);

            // Commit
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            throw $e;
        }
    }
}