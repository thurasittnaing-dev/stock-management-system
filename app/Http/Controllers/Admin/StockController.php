<?php

namespace App\Http\Controllers\Admin;

use App\Stock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StockStoreRequest;
use App\Exports\StockExport;
use App\Http\Requests\StockUpdateRequest;
use Excel;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        // $this->middleware('permission:stock-list|stock-create|stock-edit|stock-delete', ['only' => ['index', 'store']]);
        // $this->middleware('permission:stock-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:stock-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:stock-delete', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        //
        $stocks = Stock::list_data($request);
        $count = $stocks->count();
        $stocks = $stocks->paginate(10);

        return view('backend/stock.index', compact('stocks', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('backend.stock.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockStoreRequest $request)
    {
        //
        Stock::store_data($request);
        return redirect()->route('stock.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
        return view('backend.stock.edit', compact('stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(StockUpdateRequest $request, Stock $stock)
    {
        //
        Stock::update_data($request, $stock);
        return redirect()->route('stock.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }


    public function export()
    {
        return Excel::download(new StockExport, 'stocks.xlsx');
    }
}