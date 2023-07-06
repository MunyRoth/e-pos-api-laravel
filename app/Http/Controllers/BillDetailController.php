<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Http\Requests\StoreBillDetailRequest;
use App\Http\Requests\UpdateBillDetailRequest;
use App\Models\Item;
use Illuminate\Http\Response;

class BillDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBillDetailRequest $request): Response
    {
        $bill = Bill::find($request->input('bill_id'));
        $item = Item::find($request->input('item_id'));

        if ($bill && $item) {
            $bill_detail = new BillDetail;
            $bill_detail['item_id'] = $request->input('item_id');
            $bill_detail['item_price'] = $request->input('item_price');
            $bill_detail['item_cost'] = $request->input('item_cost');
            $bill_detail['item_tax'] = $request->input('item_tax');
            $bill_detail['item_discount'] = $request->input('item_discount');
            $bill_detail['item_quantity'] = $request->input('item_quantity');
            $bill->billDetails()->save($bill_detail);

            $item->update([
                'price' => $request->input('item_price'),
                'cost' => $request->input('item_cost'),
                'tax' => $request->input('item_tax'),
                'discount' => $request->input('item_discount'),
                'quantity' => $item['quantity'] + $request->input('item_quantity')
            ]);

            return Response([
                'status' => 201,
                'message' => 'uploaded successfully',
                'data' => $bill_detail
            ], 201);
        }

        return Response([
            'status' => 404,
            'message' => 'not found',
            'data' => ''
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(BillDetail $billDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBillDetailRequest $request, BillDetail $billDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillDetail $billDetail)
    {
        //
    }
}
