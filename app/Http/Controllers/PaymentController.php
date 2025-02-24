<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payment = new Payment();

        $dates = $request->query('dates', []);
        $type = $request->query('type');

        $data = $payment->getPaymentsByDates($dates, $type);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function showDetail($id)
    {
        $payment = Payment::with([
            'feeType',
            'houseResident.resident',
            'houseResident.house'
        ])->where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $payment
        ]);
    }

    public function store(StorePaymentRequest $request)
    {
        $validatedData = $request->validated();
        $payment = Payment::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Payment created successfully',
            'data' => $payment
        ], 201);
    }

    public function updatePaidStatus($id)
    {
        $payment = Payment::find($id);
        $payment->payment_status = 'paid';
        $payment->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment status updated successfully',
            'data' => $payment
        ]);
    }
}
