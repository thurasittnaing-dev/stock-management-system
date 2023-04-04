<?php

namespace App\Http\Controllers\Admin;

use App\DamageHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DamageHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $damaged_histories = DamageHistory::list_data($request);
        $count = $damaged_histories->count();
        $damaged_histories = $damaged_histories->paginate(10);

        return view('backend.damaged_history.index', compact('damaged_histories', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DamageHistory  $damageHistory
     * @return \Illuminate\Http\Response
     */
    public function show(DamageHistory $damageHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DamageHistory  $damageHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(DamageHistory $damageHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DamageHistory  $damageHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DamageHistory $damageHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DamageHistory  $damageHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(DamageHistory $damageHistory)
    {
        //
    }
}