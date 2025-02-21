<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with([
            'feeType',
            'houseResident.resident',
            'houseResident.house'
        ])->get();

        return response()->json([
            'status' => 'success',
            'data' => $payments
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

    public function showByDate(Request $request)
    {
        $payment = new Payment();

        $dates = $request->input('dates');
        $type = $request->input('type');

        $data = $payment->getPaymentsByDate($dates, $type);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function store(StorePaymentRequest $request)
    {
        $validatedData = $request->validated();
        $payment = Payment::create($validatedData);

        return response()->json([
            'status' => 'success',
            'data' => $payment
        ], 201);
    }
}
