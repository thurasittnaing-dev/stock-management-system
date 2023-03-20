<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\WithdrawHistoryStoreRequest;
use App\WithdrawHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WithdrawHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $withdraw_histories = WithdrawHistory::list_data($request);
        $count = $withdraw_histories->count();
        $withdraw_histories = $withdraw_histories->paginate(10);
        return view('backend.withdraw_history.index', compact('withdraw_histories', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
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
    public function store(WithdrawHistoryStoreRequest $request)
    {
        //
        WithdrawHistory::store_data($request);
        return redirect()->route('stock.index')->with('success', 'Withdraw success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WithdrawHistory  $withdrawHistory
     * @return \Illuminate\Http\Response
     */
    public function show(WithdrawHistory $withdrawHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WithdrawHistory  $withdrawHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(WithdrawHistory $withdrawHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WithdrawHistory  $withdrawHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WithdrawHistory $withdrawHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WithdrawHistory  $withdrawHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(WithdrawHistory $withdrawHistory)
    {
        //
    }
}