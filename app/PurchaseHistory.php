<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Stock;

class PurchaseHistory extends Model
{
    protected $fillable = [
        'supplier_id', 'stock_id', 'qty', 'price', 'currency', 'remark', 'purchase_date', 'total'
    ];

    // List Data
    public static function list_data($request)
    {
        $purchase_history = new PurchaseHistory();
        $purchase_history = $purchase_history->select('purchase_histories.*', 'brands.name AS brand_name', 'categories.name AS category_name', 'stock_types.name as stock_type_name', 'suppliers.name AS supplier_name', 'stocks.name AS stock_name', 'stocks.img AS stock_img')
            ->leftjoin('stocks', 'stocks.id', 'purchase_histories.stock_id')
            ->leftjoin('suppliers', 'suppliers.id', 'purchase_histories.supplier_id')
            ->leftjoin('stock_types', 'stock_types.id', 'stocks.stock_type_id')
            ->leftjoin('brands', 'brands.id', 'stocks.brand_id')
            ->leftjoin('categories', 'categories.id', 'stocks.category_id');

        // keyword
        if (!empty($request->keyword)) {
            $purchase_history = $purchase_history->where('stocks.name', "LIKE", '%' . $request->keyword . '%');
        }

        // brand
        if (!empty($request->brand)) {
            $purchase_history = $purchase_history->where('stocks.brand_id', $request->brand);
        }

        //stocktype
        if (!empty($request->stock_type_id)) {
            $purchase_history = $purchase_history->where('stocks.stock_type_id', $request->stock_type_id);
        }

        //category
        if (!empty($request->category)) {
            $purchase_history = $purchase_history->where('stocks.category_id', $request->category);
        }

        //supplier
        if (!empty($request->supplier_id)) {
            $purchase_history = $purchase_history->where('purchase_histories.supplier_id', $request->supplier_id);
        }

        //currency
        if (!empty($request->currency)) {
            $purchase_history = $purchase_history->where('purchase_histories.currency', $request->currency);
        }

        // price range
        if (!empty($request->min_price) and !empty($request->max_price) and !empty($request->search_currency)) {
            $purchase_history = $purchase_history->whereBetween('purchase_histories.price', [$request->min_price, $request->max_price])
                ->where('purchase_histories.currency', $request->search_currency);
        }

        // total price range
        if (!empty($request->min_total_price) and !empty($request->max_total_price) and !empty($request->search_total_currency)) {
            $purchase_history = $purchase_history->whereBetween('purchase_histories.total', [$request->min_total_price, $request->max_total_price])
                ->where('purchase_histories.currency', $request->search_total_currency);
        }

        // qty range
        if (!empty($request->qty_from) and !empty($request->qty_to)) {
            $purchase_history = $purchase_history->whereBetween('purchase_histories.qty', [$request->qty_from, $request->qty_to]);
        }

        // date range
        if (!empty($request->from_date) and !empty($request->to_date)) {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $to_date = date('Y-m-d', strtotime($request->to_date));
            $purchase_history = $purchase_history->whereBetween('purchase_histories.purchase_date', [$from_date, $to_date]);
        }

        $purchase_history = $purchase_history->orderBy('purchase_histories.purchase_date', "DESC");

        return $purchase_history;
    }

    // Store Data
    public static function store_data($request)
    {
        DB::beginTransaction();

        try {

            $stock = Stock::findorfail($request->stock_id);

            try {
                $total = $request->price * $request->qty;
            } catch (\Throwable $th) {
                //throw $th;
                $total = 0;
            }

            PurchaseHistory::create([
                'price' => $request->price,
                'stock_id' => $request->stock_id,
                'qty' => $request->qty,
                'currency' => $request->currency,
                'total' => $total,
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