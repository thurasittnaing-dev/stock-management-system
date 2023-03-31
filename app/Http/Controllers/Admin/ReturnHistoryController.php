<?php

namespace App\Http\Controllers\Admin;

use App\DamageHistory;
use App\ReturnHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WithdrawHistory;
use Illuminate\Support\Facades\DB;

class ReturnHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // dd($request->all());

        try {
            // Database Operations Within The Transaction Start
            DB::transaction(function () use ($request) {

                // Create Damaged History
                if ($request->is_damaged) {
                    DamageHistory::create([
                        'withdrawer_id' => $request->withdrawer_id,
                        'stock_id' => $request->stock_id,
                        'qty' => $request->damaged_qty,
                        'location_id' => $request->location,
                        'remark' => $request->remark,
                    ]);
                }

                $final = 0;

                // Update Withdraw History 
                if ($request->is_final) {
                    $final = 1;
                    WithdrawHistory::find($request->withdraw_history_id)->update([
                        'status' => 1,
                    ]);
                }

                // Create Return History
                ReturnHistory::create([
                    'withdraw_history_id' => $request->withdraw_history_id,
                    'qty' => $request->qty,
                    'date' => date('Y-m-d', strtotime($request->date)),
                    'is_final' => $final
                ]);



                DB::commit();
            });
        } catch (QueryException $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();
        }

        return redirect()->route('withdraw_history.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReturnHistory  $returnHistory
     * @return \Illuminate\Http\Response
     */
    public function show(ReturnHistory $returnHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReturnHistory  $returnHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturnHistory $returnHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReturnHistory  $returnHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReturnHistory $returnHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReturnHistory  $returnHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturnHistory $returnHistory)
    {
        //
    }
}