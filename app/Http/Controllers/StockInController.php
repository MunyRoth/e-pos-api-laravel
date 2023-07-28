<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockInRequest;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Item;
use App\Models\Store;
use App\Models\StoreBranch;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class StockInController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StockInRequest $request, Bill $bill): Response
    {
        $userId =  Auth::guard('api')->user()['id'];
        $branchId = Store::find($request->input('store_id'))
            ->branches
            ->get($request->input('branch_index'))
            ->id;

        $bill['store_branch_id'] = $branchId;
        $bill['user_id'] = $userId;
        $bill->save();

        $bill_details = [];
        foreach ($request->input('items') as $reqItem) {
            $bill_detail = new BillDetail;
            $bill_detail['item_id'] = $reqItem['id'];
            $bill_detail['item_price'] = $reqItem['price'];
            $bill_detail['item_cost'] = $reqItem['cost'];
            $bill_detail['item_VAT'] = $reqItem['VAT'];
            $bill_detail['item_discount'] = $reqItem['discount'];
            $bill_detail['item_quantity'] = $reqItem['quantity'];
            $bill_details[] = $bill_detail;

            // update stock
            $item = Item::find($reqItem['id']);
            $item->update([
                'price' => $reqItem['price'],
                'cost' => $reqItem['cost'],
                'VAT' => $reqItem['VAT'],
                'discount' => $reqItem['discount'],
                'quantity' => $item['quantity'] + $reqItem['quantity']
            ]);
        }
        $bill->billDetails()->saveMany($bill_details);

        return Response([
            'status' => 201,
            'message' => 'uploaded successfully',
            'data' => $bill
        ], 201);
    }

}
