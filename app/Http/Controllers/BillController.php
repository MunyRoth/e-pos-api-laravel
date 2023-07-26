<?php

namespace App\Http\Controllers;

use App\Models\Bill;
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
}
