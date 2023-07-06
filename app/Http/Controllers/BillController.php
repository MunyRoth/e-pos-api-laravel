<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\UpdateBillRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $bills =  Auth::guard('api')->user()['bills'];

        return Response([
            'status' => 200,
            'message' => 'got successfully',
            'data' => $bills
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBillRequest $request, Bill $bill): Response
    {
        $userId =  Auth::guard('api')->user()['id'];

        $bill->user_id = $userId;
        $bill->save();

        return Response([
            'status' => 201,
            'message' => 'uploaded successfully',
            'data' => $bill
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill): Response
    {
        return Response([
            'status' => 200,
            'message' => 'got successfully',
            'data' => $bill->load('billDetails')
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBillRequest $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        //
    }
}
