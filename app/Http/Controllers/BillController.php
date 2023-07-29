<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Response;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $bills = Bill::query()
            ->select('bills.id', 'users.name as purchased_by', 'store_branches.name_km as branch')
            ->join('users', 'bills.user_id', '=', 'users.id')
            ->join('store_branches', function (JoinClause $join) {
                $join->on('bills.store_branch_id', '=', 'store_branches.id')
                    ->where('store_branches.store_id', '=', 1);
            })
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
    public function show(Bill $bill): Response
    {
        return Response([
            'status' => 200,
            'message' => 'got successfully',
            'data' => $bill->load('purchasedBy', 'billDetails')
        ], 200);
    }
}
