<?php

namespace App\Http\Controllers\Admin;

use App\StockType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StockTypeStoreRequest;
use App\Http\Requests\StockTypeUpdateRequest;

class StockTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $stock_types = new StockType();
        $stock_types = $stock_types->where('status', 1);
        $count = $stock_types->count();

        if ($request->keyword != '') {
            $stock_types = $stock_types->where('name', 'LIKE', '%' . $request->keyword . '%');
        }

        if ($request->status != '') {
            $stock_types = $stock_types->where('status', $request->status);
        }

        $stock_types = $stock_types->orderBy('created_at', 'desc')->paginate(10);
        return view('backend.stock_type.index', compact('stock_types', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('backend.stock_type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockTypeStoreRequest $request)
    {
        //

        StockType::store_data($request);
        return redirect()->route('stock_type.index')->with('success', 'Created successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StockType  $stockType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StockType  $stockType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $stock_type = StockType::findorfail($id);
        return view('backend.stock_type.edit', compact('stock_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StockType  $stockType
     * @return \Illuminate\Http\Response
     */
    public function update(StockTypeUpdateRequest $request, $id)
    {
        //
        if (StockType::update_data($id, $request)) {
            return redirect()->route('stock_type.index')->with('success', 'Updated Success');
        } else {
            return redirect()->route('stock_type.index')->with('error', 'Stock Type Duplicated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StockType  $stockType
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockType $stockType)
    {
        //
        $stockType->delete();
        return redirect()->route('stock_type.index')->with('success', 'Deleted successful');
    }
}