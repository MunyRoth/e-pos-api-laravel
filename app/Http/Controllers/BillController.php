<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($storeId): Response
    {
        $bills = Bill::query()
            ->select('bills.id',
                'users.name as purchased_by',
                'store_branches.name_km as branch',
                DB::raw('SUM(bill_details.item_cost * bill_details.item_quantity) as total_price'),
                DB::raw('COUNT(bill_details.id) as total_item'))
            ->join('users', 'bills.user_id', '=', 'users.id')
            ->join('store_branches', function (JoinClause $join) use ($storeId) {
                $join->on('bills.store_branch_id', '=', 'store_branches.id')
                    ->where('store_branches.store_id', '=', $storeId);
            })
            ->leftJoin('bill_details', 'bill_details.bill_id', '=', 'bills.id')
            ->groupBy('id')
            ->get();

        return Response([
            'status' => 200,
            'message' => 'got successfully',
            'data' => $bills
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): Response
    {
        $bill = Bill::find($id);

        return Response([
            'status' => 200,
            'message' => 'got successfully',
            'data' => $bill->load('purchasedBy', 'billDetails')
        ], 200);
    }
}
