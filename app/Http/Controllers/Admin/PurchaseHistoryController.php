<?php

namespace App\Http\Controllers\Admin;

use App\PurchaseHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseHistoryStoreRequest;

class PurchaseHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $purchase_histories = PurchaseHistory::list_data($request);
        $count = $purchase_histories->count();
        $purchase_histories = $purchase_histories->paginate(10);
        return view('backend.purchase_history.index', compact('count', 'purchase_histories'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseHistoryStoreRequest $request)
    {
        //

        if ($request->price <= 0 || $request->qty <= 0) {
            return redirect()->back()->with('error', 'Inappropriate value detected');
        }

        PurchaseHistory::store_data($request);
        return redirect()->back()->with('success', 'Purchased history added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseHistory  $purchaseHistory
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseHistory $purchaseHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseHistory  $purchaseHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseHistory $purchaseHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PurchaseHistory  $purchaseHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseHistory $purchaseHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PurchaseHistory  $purchaseHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseHistory $purchaseHistory)
    {
        //
    }
}