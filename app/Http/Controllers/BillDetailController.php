<?php

namespace App\Http\Controllers;

use App\Models\BillDetail;
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
     * Display the specified resource.
     */
    public function show(BillDetail $billDetail): Response
    {
        return Response([
            'status' => 200,
            'message' => 'got successfully',
            'data' => $billDetail
        ], 200);
    }
}
