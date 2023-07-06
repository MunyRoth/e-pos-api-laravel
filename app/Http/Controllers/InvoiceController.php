<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $invoices =  Auth::guard('api')->user()['invoices'];

        return Response([
            'status' => 200,
            'message' => 'got successfully',
            'data' => $invoices
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request, Invoice $invoice): Response
    {
        $userId =  Auth::guard('api')->user()['id'];

        $invoice->user_id = $userId;
        $invoice->customer_id = $request->input('customer_id');
        $invoice->save();

        $payment = new Payment;
        $payment->payment_method_id = $request->input('payment_method_id');
        $payment->payment_status_id = $request->input('payment_status_id');
        $invoice->payment()->save($payment);

        $invoice_details = [];
        foreach ($request->input('items') as $item)  {
            $detail = new InvoiceDetail;
            $detail->item_id = $item->item_id;
            $invoice_details[] = $detail;
        }
        $invoice->invoice_details()->saveMany($invoice_details);

        return Response([
            'status' => 201,
            'message' => 'uploaded successfully',
            'data' => $invoice
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice): Response
    {
        return Response([
            'status' => 200,
            'message' => 'got successfully',
            'data' => $invoice
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
