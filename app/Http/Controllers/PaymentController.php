<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function show()
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
}
