<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $user =  Auth::guard('api')->user();
        $bills = User::query()
            ->select('name')
            ->join('bills', 'users.id', '=', 'bills.user_id')
            ->select('users.name as purchased_by', 'bills.id')
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
